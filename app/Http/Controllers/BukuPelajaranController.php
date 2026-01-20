<?php

namespace App\Http\Controllers;

use App\Models\BukuPelajaran;
use App\Models\EnrollmentKelas;
use App\Models\FeeComponent;
use App\Models\Kelas;
use App\Models\StudentFee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class BukuPelajaranController extends Controller
{
    private function getBookAccessBlockReason(Request $request): ?string
    {
        if (! $request->is('siswa/*') && ! $request->is('orangtua/*')) {
            return null;
        }

        $user = session('userActive');
        $idSiswa = $user->ID_SISWA ?? null;

        if (! $idSiswa) {
            return null;
        }

        $periodeId = EnrollmentKelas::where('ID_SISWA', $idSiswa)
            ->join('KELAS', 'ENROLLMENT_KELAS.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->orderByDesc('KELAS.ID_PERIODE')
            ->value('KELAS.ID_PERIODE');

        if (! $periodeId) {
            return null;
        }

        $bookComponentIds = FeeComponent::where('STATUS', 'Active')
            ->where(function ($q) {
                $q->where('NAME', 'like', '%buku%')
                    ->orWhereHas('category', function ($c) {
                        $c->where('NAME', 'like', '%buku%');
                    });
            })
            ->pluck('ID_COMPONENT');

        if ($bookComponentIds->isEmpty()) {
            return null;
        }

        $hasUnpaid = StudentFee::where('ID_SISWA', $idSiswa)
            ->where('ID_PERIODE', $periodeId)
            ->whereIn('ID_COMPONENT', $bookComponentIds)
            ->whereNotIn('STATUS', ['Paid'])
            ->exists();

        return $hasUnpaid
            ? 'Akses buku dikunci hingga tagihan buku pada periode ini dilunasi.'
            : null;
    }

    private function redirectBlockedAccess(Request $request, string $message): RedirectResponse
    {
        if ($request->is('orangtua/*')) {
            return redirect()->route('orangtua.buku.index')->withErrors($message);
        }

        if ($request->is('siswa/*')) {
            return redirect()->route('siswa.buku.index')->withErrors($message);
        }

        abort(403, $message);
    }

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
        $context = 'admin';

        if ($request->is('guru/*')) {
            $context = 'guru';
        } elseif ($request->is('orangtua/*')) {
            $context = 'orangtua';
        } elseif ($request->is('siswa/*')) {
            $context = 'siswa';
        }

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
        $blockedReason = $this->getBookAccessBlockReason($request);

        if ($blockedReason) {
            $books = collect();
        }

        $viewName = $context === 'siswa'
            ? 'siswa_pages.buku_pelajaran'
            : 'library.buku_pelajaran';

        $previewRoute = [
            'admin' => 'admin.buku.preview',
            'guru' => 'guru.buku.preview',
            'orangtua' => 'orangtua.buku.preview',
            'siswa' => 'siswa.buku.preview',
        ][$context];

        $streamRoute = [
            'admin' => 'admin.buku.view',
            'guru' => 'guru.buku.view',
            'orangtua' => 'orangtua.buku.view',
            'siswa' => 'siswa.buku.view',
        ][$context];

        return response()->view($viewName, [
            'books' => $books,
            'kelasList' => $kelasList,
            'kelasFilter' => $kelasFilter,
            'blockedReason' => $blockedReason,
            'previewRoute' => $previewRoute,
            'streamRoute' => $streamRoute,
            'context' => $context,
        ]);
    }

    public function preview(Request $request, int $id): Response
    {
        $blockedReason = $this->getBookAccessBlockReason($request);
        if ($blockedReason) {
            return $this->redirectBlockedAccess($request, $blockedReason);
        }

        $book = BukuPelajaran::findOrFail($id);

        if ($book->STATUS !== 'Active' && ! $request->is('admin/*')) {
            abort(404);
        }

        $context = 'admin';
        if ($request->is('guru/*')) {
            $context = 'guru';
        } elseif ($request->is('orangtua/*')) {
            $context = 'orangtua';
        } elseif ($request->is('siswa/*')) {
            $context = 'siswa';
        }

        $streamRoute = [
            'admin' => 'admin.buku.view',
            'guru' => 'guru.buku.view',
            'orangtua' => 'orangtua.buku.view',
            'siswa' => 'siswa.buku.view',
        ][$context];

        $backRoute = [
            'admin' => 'admin.buku.index',
            'guru' => 'guru.buku.index',
            'orangtua' => 'orangtua.buku.index',
            'siswa' => 'siswa.buku.index',
        ][$context];

        $fileUrl = route($streamRoute, $book->ID_BUKU);

        return response()->view('library.buku_preview', [
            'book' => $book,
            'fileUrl' => $fileUrl,
            'context' => $context,
            'backRoute' => $backRoute,
        ]);
    }

    public function stream(int $id)
    {
        $blockedReason = $this->getBookAccessBlockReason(request());
        if ($blockedReason) {
            return $this->redirectBlockedAccess(request(), $blockedReason);
        }

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

        // Extend FPDI to support simple rotation for diagonal watermark
        $pdf = new class extends Fpdi {
            protected $angle = 0;

            public function Rotate($angle, $x = -1, $y = -1): void
            {
                if ($x === -1) {
                    $x = $this->x;
                }
                if ($y === -1) {
                    $y = $this->y;
                }
                if ($this->angle !== 0) {
                    $this->_out('Q');
                }
                $this->angle = $angle;
                if ($angle !== 0) {
                    $angle *= M_PI / 180;
                    $c = cos($angle);
                    $s = sin($angle);
                    $cx = $x * $this->k;
                    $cy = ($this->h - $y) * $this->k;
                    $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.5F %.5F cm 1 0 0 1 %.5F %.5F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
                }
            }

            public function _endpage()
            {
                if ($this->angle !== 0) {
                    $this->angle = 0;
                    $this->_out('Q');
                }
                parent::_endpage();
            }

            public function SetTextRenderingMode(int $mode, float $lineWidth = 0.3): void
            {
                // mode: 0 fill, 1 stroke, 2 fill+stroke
                $this->_out(sprintf('%.3F w %d Tr', $lineWidth, $mode));
            }
        };
        $pageCount = $pdf->setSourceFile($fullPath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tplId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($tplId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);

            // Diagonal watermark across the page
            $pdf->SetFont('Arial', 'B', 60);
            $pdf->SetTextColor(200, 200, 200); // outline stroke color
            $centerX = $size['width'] / 2;
            $centerY = $size['height'] / 2;
            $pdf->Rotate(45, $centerX, $centerY);
            $textWidth = $pdf->GetStringWidth($watermarkText);
            $pdf->SetTextRenderingMode(1, 0.5); // stroke only
            $pdf->Text($centerX - ($textWidth / 2), $centerY, $watermarkText);
            $pdf->SetTextRenderingMode(0, 0.2); // reset to fill mode
            $pdf->Rotate(0);
        }

        $output = $pdf->Output('S');

        return response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($book->FILE_PATH) . '"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
