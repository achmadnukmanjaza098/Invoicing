<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function report()
    {
        $reports = Invoice::join('customers', 'customers.id', '=', 'invoices.customer_id')
                                    ->join('brands', 'brands.id', '=', 'invoices.brand_id')
                                    ->select('invoices.*', 'customers.name as customer', 'brands.name as brand')
                                    ->get();

        return view('report.list')
                        ->with('status_invoice', '')
                        ->with('payment_method', '')
                        ->with('reports', $reports);
    }

    public function filterReport(Request $request)
    {
        $status_invoice = $request->status_invoice ? $request->status_invoice : '';
        $payment_method = $request->payment_method ? $request->payment_method : '';

        $reports = Invoice::join('customers', 'customers.id', '=', 'invoices.customer_id')
                                    ->join('brands', 'brands.id', '=', 'invoices.brand_id')
                                    ->Where('status_invoice', 'like', '' . $status_invoice . '%')
                                    ->Where('payment_method', 'like', '%' . $payment_method . '%')
                                    ->select('invoices.*', 'customers.name as customer', 'brands.name as brand')
                                    ->get();

        return view('report.list')
            ->with('status_invoice', $status_invoice)
            ->with('payment_method', $payment_method)
            ->with('reports', $reports);
    }

    public function exportReport(Request $request)
    {
        $status_invoice = $request->query('status_invoice', '');
        $payment_method = $request->query('payment_method', '');

        return Excel::download(new InvoicesExport($status_invoice, $payment_method), 'Report Invoice.xlsx');
    }
}
