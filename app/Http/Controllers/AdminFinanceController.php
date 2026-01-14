<?php

namespace App\Http\Controllers;

use App\Models\FeeComponent;
use App\Models\FeeCategory;
use App\Models\Periode;
use App\Models\StudentFee;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\EnrollmentKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminFinanceController extends Controller
{
    public function components()
    {
        $components = FeeComponent::with('category')->orderBy('NAME')->get();
        $categories = FeeCategory::orderBy('NAME')->get();
        return view('admin_pages.finance_components', compact('components', 'categories'));
    }

    public function storeComponent(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:128',
            'amount_default' => 'required|numeric|min:0',
            'type' => 'required|in:Wajib,Tambahan',
            'category_id' => 'nullable|integer|exists:FEE_CATEGORIES,ID_CATEGORY',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive',
            'id_component' => 'nullable|integer|exists:FEE_COMPONENTS,ID_COMPONENT',
            'auto_bill' => 'nullable|boolean',
        ]);

        if (! empty($data['id_component'])) {
            $comp = FeeComponent::find($data['id_component']);
            $comp->update([
                'NAME' => $data['name'],
                'AMOUNT_DEFAULT' => $data['amount_default'],
                'TYPE' => $data['type'],
                'ID_CATEGORY' => $data['category_id'] ?? null,
                'DESCRIPTION' => $data['description'] ?? null,
                'STATUS' => $data['status'],
                'AUTO_BILL' => (bool) ($data['auto_bill'] ?? false),
            ]);
        } else {
            FeeComponent::create([
                'NAME' => $data['name'],
                'AMOUNT_DEFAULT' => $data['amount_default'],
                'TYPE' => $data['type'],
                'ID_CATEGORY' => $data['category_id'] ?? null,
                'DESCRIPTION' => $data['description'] ?? null,
                'STATUS' => $data['status'],
                'AUTO_BILL' => (bool) ($data['auto_bill'] ?? false),
            ]);
        }

        return redirect()->route('admin.finance.components')->with('success', 'Komponen biaya tersimpan');
    }

    public function deleteComponent($id)
    {
        FeeComponent::where('ID_COMPONENT', $id)->delete();
        return redirect()->route('admin.finance.components')->with('success', 'Komponen dihapus');
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'id_category' => 'nullable|integer|exists:FEE_CATEGORIES,ID_CATEGORY',
            'name' => 'required|string|max:128',
            'status' => 'required|in:Active,Inactive',
        ]);

        if (! empty($data['id_category'])) {
            $cat = FeeCategory::find($data['id_category']);
            $cat->update([
                'NAME' => $data['name'],
                'STATUS' => $data['status'],
            ]);
        } else {
            FeeCategory::create([
                'NAME' => $data['name'],
                'STATUS' => $data['status'],
            ]);
        }

        return redirect()->route('admin.finance.components')->with('success', 'Kategori tersimpan');
    }

    public function deleteCategory($id)
    {
        FeeCategory::where('ID_CATEGORY', $id)->delete();
        return redirect()->route('admin.finance.components')->with('success', 'Kategori dihapus');
    }

    public function listFees(Request $request)
    {
        $periodes = Periode::orderByDesc('ID_PERIODE')->get();
        $selectedPeriode = $request->query('periode');

        $feesQuery = StudentFee::with(['siswa', 'periode', 'component'])
            ->orderByDesc('created_at');

        if ($selectedPeriode && $selectedPeriode !== 'all') {
            $feesQuery->where('ID_PERIODE', $selectedPeriode);
        }

        $fees = $feesQuery->limit(200)->get();

        $components = FeeComponent::where('STATUS', 'Active')->orderBy('NAME')->with('category')->get();
        $kelass = Kelas::with('detailKelas')->orderBy('ID_KELAS')->get();
        $siswas = Siswa::orderBy('NAMA_SISWA')->get();

        return view('admin_pages.finance_fees', [
            'fees' => $fees,
            'components' => $components,
            'periodes' => $periodes,
            'kelass' => $kelass,
            'siswas' => $siswas,
            'selectedPeriode' => $selectedPeriode,
        ]);
    }

    public function storeFeeBatch(Request $request)
    {
        $data = $request->validate([
            'scope' => 'required|in:all_siswa,kelas,siswa',
            'ID_PERIODE' => 'required|integer',
            'ID_COMPONENT' => 'required|integer|exists:FEE_COMPONENTS,ID_COMPONENT',
            'AMOUNT' => 'nullable|numeric|min:0',
            'DUE_DATE' => 'nullable|date',
            'kelas_ids' => 'array',
            'kelas_ids.*' => 'string',
            'siswa_ids' => 'array',
            'siswa_ids.*' => 'string',
        ]);

        $component = FeeComponent::findOrFail($data['ID_COMPONENT']);
        $amount = $data['AMOUNT'] ?? $component->AMOUNT_DEFAULT;

        // Determine target students
        $targetIds = collect();
        if ($data['scope'] === 'all_siswa') {
            $targetIds = Siswa::where('STATUS_SISWA', 'Active')->pluck('ID_SISWA');
        } elseif ($data['scope'] === 'kelas') {
            $kelasIds = collect($data['kelas_ids'] ?? [])->filter();
            if ($kelasIds->isNotEmpty()) {
                $targetIds = EnrollmentKelas::whereIn('ID_KELAS', $kelasIds)->pluck('ID_SISWA');
            }
        } elseif ($data['scope'] === 'siswa') {
            $targetIds = collect($data['siswa_ids'] ?? [])->filter();
        }

        $targetIds = $targetIds->unique()->values();
        if ($targetIds->isEmpty()) {
            return redirect()->route('admin.finance.fees')->with('error', 'Tidak ada siswa yang dipilih');
        }

        DB::transaction(function () use ($targetIds, $data, $amount) {
            foreach ($targetIds as $sid) {
                $invoice = 'INV-' . Str::upper(Str::random(10));
                StudentFee::create([
                    'ID_SISWA' => $sid,
                    'ID_PERIODE' => $data['ID_PERIODE'],
                    'ID_COMPONENT' => $data['ID_COMPONENT'],
                    'AMOUNT' => $amount,
                    'DUE_DATE' => $data['DUE_DATE'] ?? null,
                    'STATUS' => 'Unpaid',
                    'INVOICE_CODE' => $invoice,
                ]);
            }
        });

        return redirect()->route('admin.finance.fees')->with('success', 'Tagihan berhasil dibuat untuk ' . $targetIds->count() . ' siswa');
    }

    public function updateFeeStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['Paid', 'Pending', 'Unpaid', 'Overdue', 'Cancelled'])],
        ]);

        $fee = StudentFee::findOrFail($id);
        $fee->STATUS = $data['status'];
        $fee->save();

        return redirect()->route('admin.finance.fees')->with('success', 'Status tagihan diperbarui');
    }
}
