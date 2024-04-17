<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\DetailInvoice;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController extends Controller
{
    public function invoice()
    {
        $invoices = Invoice::join('customers', 'customers.id', '=', 'invoices.customer_id')
                                    ->select('invoices.*', 'customers.name as customer')
                                    ->get();

        return view('invoice.list')
                        ->with('invoices', $invoices);
    }

    public function showFormInvoice(Request $request)
    {
        $brands = Brand::all();
        $items = Item::all();
        $customers = Customer::all();

        if ($request->id) {
            $invoice = Invoice::findOrFail($request->id);
            $detail_invoices = DetailInvoice::join('items', 'items.id', '=', 'detail_invoices.item_id')
                                            ->where('invoice_id', $invoice->id)
                                            ->select('detail_invoices.*', 'items.name as item')
                                            ->get();

            return view('invoice.edit')
                        ->with('invoice', $invoice)
                        ->with('detail_invoices', $detail_invoices)
                        ->with('items', $items)
                        ->with('customers', $customers)
                        ->with('brands', $brands);
        } else {
            return view('invoice.add')
                        ->with('items', $items)
                        ->with('customers', $customers)
                        ->with('brands', $brands);
        }
    }

    public function storeInvoice(Request $request)
    {
        $request->validate([
            'order_id' => 'required|unique:invoices,order_id',
            'customer_id' => 'required',
            'date' => 'required',
            'due_date' => 'required',
            'brand_id' => 'required',
            'detail_items' => 'required',
            'detail_items.*.item_id' => 'required',
            'detail_items.*.qty' => 'required',
            'detail_items.*.price' => 'required',
            'detail_items.*.amount' => 'required',
        ]);

        try {
            $invoice = Invoice::create([
                'order_id' => $request->order_id,
                'customer_id' => $request->customer_id,
                'status_payment' => 'Not Yet Paid',
                'date' => $request->date,
                'due_date' => $request->due_date,
                'brand_id' => $request->brand_id,
                'tax' => 0,
                'subtotal' => str_replace(",", "", $request->total_amount),
                'total' => str_replace(",", "", $request->total_amount),
            ]);

            foreach ($request->detail_items as $value) {
                $detail_invoice = DetailInvoice::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $value['item_id'],
                    'qty' => str_replace(",", "", $value['qty']),
                    'price' => str_replace(",", "", $value['price']),
                    'total' => str_replace(",", "", $value['amount']),
                ]);
            }

        } catch (\exception $e) {
            \Log::debug($e);
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function updateInvoice(Request $request)
    {
        $invoice = Invoice::findOrFail($request->id);

        $request->validate([
            'payment_method' => 'required',
            'proof_of_payment' => $request->input('payment_method') == 'Transfer' ? 'required' : ''
        ]);

        try {
            $fileName = null;

            if ($request->payment_method == 'Transfer') {
                $file = $request->file('proof_of_payment');
                $fileName = $file->getClientOriginalName();
                $destinationPath = public_path('/assets/uploads/proof_of_payment');
                $file->move($destinationPath, $fileName);
            }

            $invoice->update([
                'status_payment' => 'Paid',
                'payment_method' => $request->payment_method,
                'proof_of_payment' => $fileName,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function deleteInvoice(Request $request)
    {
        $invoice = Invoice::findOrFail($request->id);

        try {
            $invoice->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function downloadInvoice(Request $request)
    {
        $invoice = Invoice::join('brands', 'brands.id', '=', 'invoices.brand_id')
                                ->where('invoices.id', '=', $request->id)
                                ->select('invoices.*', 'brands.image as logo', 'brands.name as brand_name')
                                ->first();

        $detail_invoices = DetailInvoice::where('invoice_id', '=', $request->id)->get();

        $imagePath = public_path('/assets/uploads/logo/' . $invoice['logo']);
        $imageData = base64_encode(file_get_contents($imagePath));
        $src = 'data:'.mime_content_type($imagePath).';base64,'.$imageData;

        $data = [
            'title' => "Invoice $invoice->order_id",

            'invoice' => $invoice,
            'detail_invoices' => $detail_invoices,

            'logo' => $src,
        ];


        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('invoice/download', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();

        // return $dompdf->stream("Invoice $invoice->order_id.pdf");
        return $dompdf->stream("Invoice $invoice->order_id.pdf", array("Attachment" => 0));
    }
}
