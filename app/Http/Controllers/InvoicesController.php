<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use App\Models\Persediaan;
use Carbon\Carbon;
use PDF;
use DB;

class InvoicesController extends Controller
{
    public function show($id)
    {
        $invoice = invoices::with('pendapatan')->findOrFail($id);
        return view('invoices/template', compact('invoice'));
    }

    public function downloadPDF($id)
    {
        set_time_limit(120);
        $invoice = invoices::with('pendapatan')->findOrFail($id);
        $pdf = PDF::loadView('invoices/dw_pdf', compact('invoice'))
            ->setPaper([0, 0, 420 * 3.78, 297 * 3.78], 'portrait');
        return $pdf->download('invoice_' . $invoice->nama_faktur . '.pdf');
    }
}
