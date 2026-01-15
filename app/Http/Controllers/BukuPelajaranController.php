<?php

namespace App\Http\Controllers;

use App\Models\BukuPelajaran;
use App\Models\Kelas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class BukuPelajaranController extends Controller
{
    // ============================= Admin =============================
    public function adminIndex(): Response
    {
        $books = BukuPelajaran::with('kelas')
            ->orderByDesc('created_at')
            ->get();

        $kelasList = Kelas::orderBy('ID_KELAS')->get();
        $defaultWatermark = config('app.name', 'LMS');

        return response()->view('admin_pages.buku_pelajaran', [
            'books' => $books,
            'kelasList' => $kelasList,
            'defaultWatermark' => $defaultWatermark,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'JUDUL' => 'required|string|max:255',
            'DESKRIPSI' => 'nullable|string',
            'KATEGORI' => 'nullable|string|max:100',
            'WATERMARK_TEXT' => 'nullable|string|max:255',
            'STATUS' => 'required|in:Active,Inactive',
            'kelas_ids' => 'array',
            'kelas_ids.*' => 'string|exists:KELAS,ID_KELAS',
            'file' => 'required|file|mimes:pdf|max:20480', // 20 MB
        ]);

        $file = $validated['file'];
        $filename = uniqid('buku_') . '.' . $file->getClientOriginalExtension();
        $storedPath = $file->storeAs('buku_pelajaran', $filename, 'public');

        $book = BukuPelajaran::create([
            'JUDUL' => $validated['JUDUL'],
            'DESKRIPSI' => $validated['DESKRIPSI'] ?? null,
            'FILE_PATH' => $storedPath,
            'FILE_SIZE' => $file->getSize(),
            'FILE_EXT' => $file->getClientOriginalExtension(),
            'MIME_TYPE' => $file->getClientMimeType(),
            'KATEGORI' => $validated['KATEGORI'] ?? null,
            'WATERMARK_TEXT' => $validated['WATERMARK_TEXT'] ?? config('app.name', 'LMS'),
            'STATUS' => $validated['STATUS'],
            'UPLOADED_BY' => auth()->id(),
        ]);

        $book->kelas()->sync($validated['kelas_ids'] ?? []);

        return redirect()->back()->with('success', 'Buku pelajaran berhasil ditambahkan');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $book = BukuPelajaran::with('kelas')->findOrFail($id);

        $validated = $request->validate([
            'JUDUL' => 'required|string|max:255',
            'DESKRIPSI' => 'nullable|string',
            'KATEGORI' => 'nullable|string|max:100',
            'WATERMARK_TEXT' => 'nullable|string|max:255',
            'STATUS' => 'required|in:Active,Inactive',
            'kelas_ids' => 'array',
            'kelas_ids.*' => 'string|exists:KELAS,ID_KELAS',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $updateData = [
            'JUDUL' => $validated['JUDUL'],
            'DESKRIPSI' => $validated['DESKRIPSI'] ?? null,
            'KATEGORI' => $validated['KATEGORI'] ?? null,
            'WATERMARK_TEXT' => $validated['WATERMARK_TEXT'] ?? config('app.name', 'LMS'),
            'STATUS' => $validated['STATUS'],
        ];

        if (isset($validated['file'])) {
            $file = $validated['file'];
            $filename = uniqid('buku_') . '.' . $file->getClientOriginalExtension();
            $storedPath = $file->storeAs('buku_pelajaran', $filename, 'public');

            // remove old file
            if ($book->FILE_PATH) {
                Storage::disk('public')->delete($book->FILE_PATH);
            }

            $updateData = array_merge($updateData, [
                'FILE_PATH' => $storedPath,
                'FILE_SIZE' => $file->getSize(),
                'FILE_EXT' => $file->getClientOriginalExtension(),
                'MIME_TYPE' => $file->getClientMimeType(),
            ]);
        }

        $book->update($updateData);
        $book->kelas()->sync($validated['kelas_ids'] ?? []);

        return redirect()->back()->with('success', 'Buku pelajaran berhasil diperbarui');
    }

    public function destroy(int $id): RedirectResponse
    {
        $book = BukuPelajaran::findOrFail($id);
        if ($book->FILE_PATH) {
            Storage::disk('public')->delete($book->FILE_PATH);
        }
        $book->kelas()->detach();
        $book->delete();

        return redirect()->back()->with('success', 'Buku pelajaran dihapus');
    }

    // ============================= Library (admin/guru/siswa/ortu) =============================
    public function library(Request $request): Response
    {
        $kelasFilter = $request->query('kelas');

        $query = BukuPelajaran::with('kelas')
            ->where('STATUS', 'Active')
            ->orderBy('JUDUL');

        if ($kelasFilter) {
            $query->whereHas('kelas', function ($q) use ($kelasFilter) {
                $q->where('ID_KELAS', $kelasFilter);
            });
        }

        $books = $query->get();
        $kelasList = Kelas::orderBy('ID_KELAS')->get();

        return response()->view('library.buku_pelajaran', [
            'books' => $books,
            'kelasList' => $kelasList,
            'kelasFilter' => $kelasFilter,
        ]);
    }

    public function stream(int $id)
    {
        $book = BukuPelajaran::findOrFail($id);

        // Only allow active books in public library
        if ($book->STATUS !== 'Active' && ! request()->is('admin/*')) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($book->FILE_PATH);
        if (! file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan');
        }

        return $this->streamWithWatermark($book, $fullPath);
    }

    private function streamWithWatermark(BukuPelajaran $book, string $fullPath): Response
    {
        $watermarkText = $book->WATERMARK_TEXT ?: config('app.name', 'LMS');

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($fullPath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tplId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($tplId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);

            // Simple watermark at top-left; light gray
            $pdf->SetFont('Arial', 'B', 18);
            $pdf->SetTextColor(180, 180, 180);
            $pdf->SetXY(12, 12);
            $pdf->Cell(0, 10, $watermarkText, 0, 0, 'L');
        }

        $output = $pdf->Output('S');

        return response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($book->FILE_PATH) . '"',
        ]);
    }
}
