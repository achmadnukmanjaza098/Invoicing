<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoicesExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    private $status_invoice;
    private $payment_method;

    public function __construct($status_invoice, $payment_method)
    {
        $this->status_invoice = $status_invoice;
        $this->payment_method = $payment_method;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $invoices = Invoice::join('customers', 'customers.id', '=', 'invoices.customer_id')
                                    ->join('brands', 'brands.id', '=', 'invoices.brand_id')
                                    ->Where('status_invoice', 'like', '' . $this->status_invoice . '%')
                                    ->Where('payment_method', 'like', '%' . $this->payment_method . '%')
                                    ->select('invoices.order_id as order_id', DB::raw("CONCAT(payment_method, ' - ',status_invoice) AS payment"), 'brands.name as brand', 'customers.name as customer', DB::raw("DATE_FORMAT(date, '%d-%b-%Y') as formatted_dob"), DB::raw("FORMAT(total, 2)"))
                                    ->get();

        return $invoices;
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Payment',
            'Brand',
            'Customer',
            'Invoice Date',
            'Total',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'D3D3D3'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
        ];
    }
}
