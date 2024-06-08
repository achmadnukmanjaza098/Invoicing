<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DetailInvoice;
use App\Models\HistoryPayment;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function invoice()
    {
        $accessBrand = json_decode(Auth::user()->access_brand);
        $invoices = Invoice::join('customers', 'customers.id', '=', 'invoices.customer_id')
                                    ->join('brands', 'brands.id', '=', 'invoices.brand_id')
                                    ->whereIn('brands.id', $accessBrand)
                                    ->select('invoices.*', 'customers.name as customer', 'brands.name as brand')
                                    ->get();

        return view('invoice.list')
                        ->with('invoices', $invoices);
    }

    public function showFormInvoice(Request $request)
    {
        $accessBrand = json_decode(Auth::user()->access_brand);
        $brands = Brand::whereIn('id', $accessBrand)
                        ->where('active', '=', 1)
                        ->get();
        $items = Item::where('active', '=', 1)->get();
        $customers = Customer::where('active', '=', 1)->get();
        $categories = Category::where('active', '=', 1)->get();

        if ($request->id) {
            $invoice = Invoice::findOrFail($request->id);
            // $detail_invoices = DetailInvoice::join('items', 'items.id', '=', 'detail_invoices.item_id')
            //                                 ->where('invoice_id', $invoice->id)
            //                                 ->select('detail_invoices.*', 'items.name as item')
            //                                 ->get();

            $detail_invoices = DetailInvoice::join('categories', 'categories.id', '=', 'detail_invoices.category_id')
                                            ->where('invoice_id', $invoice->id)
                                            ->select('detail_invoices.*', 'categories.name as category_name')
                                            ->get();

            $historyPayments = HistoryPayment::where('invoice_id', '=', $invoice->id)->orderByDesc('created_at')->get();

            return view('invoice.edit')
                        ->with('invoice', $invoice)
                        ->with('detail_invoices', $detail_invoices)
                        ->with('items', $items)
                        ->with('customers', $customers)
                        ->with('historyPayments', $historyPayments)
                        ->with('brands', $brands)
                        ->with('categories', $categories);
        } else {
            return view('invoice.add')
                        ->with('items', $items)
                        ->with('categories', $categories)
                        ->with('customers', $customers)
                        ->with('brands', $brands);
        }
    }

    public function storeInvoice(Request $request)
    {
        $request->validate([
            'order_id' => 'required|unique:invoices,order_id|numeric',
            'customer_id' => 'required',
            'date' => 'required',
            'due_date' => 'required',
            'brand_id' => 'required',
            'detail_items' => 'required',
            'detail_items.*.item_id' => 'nullable',
            'detail_items.*.item' => 'required',
            'detail_items.*.category_id' => 'required',
            'detail_items.*.qty' => 'required',
            'detail_items.*.price' => 'required',
            'detail_items.*.amount' => 'required',
        ]);

        try {
            $invoice = Invoice::create([
                'order_id' => $request->order_id,
                'customer_id' => $request->customer_id,
                'status_invoice' => 'Draft',
                'status_payment' => 'Not Yet',
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
                    'item' => $value['item'],
                    'category_id' => $value['category_id'],
                    'qty' => str_replace(",", "", $value['qty']),
                    'price' => str_replace(",", "", $value['price']),
                    'total' => str_replace(",", "", $value['amount']),
                ]);
            }

            $historyPayment = HistoryPayment::create([
                'invoice_id' => $invoice->id,
                'before' => "",
                'after' => "Belum DP",
            ]);

        } catch (\exception $e) {
            \Log::debug($e);
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function updateInvoice(Request $request)
    {
        $invoice = Invoice::findOrFail($request->id);

        if ($request->submit === 'true' && $invoice->status_invoice != 'Draft') {
            $request->validate([
                'payment_method' => 'required',
                'proof_of_payment' => ($request->input('status_invoice') === 'Lunas' && $request->input('payment_method') == 'Transfer') ? 'required' : ''
            ]);
        } else {
            $request->validate([
                'order_id' => 'required|numeric',
                'customer_id' => 'required',
                'date' => 'required',
                'due_date' => 'required',
                'brand_id' => 'required',
                'detail_items' => 'required',
                'detail_items.*.item_id' => 'nullable',
                'detail_items.*.item' => 'required',
                'detail_items.*.category_id' => 'required',
                'detail_items.*.qty' => 'required',
                'detail_items.*.price' => 'required',
                'detail_items.*.amount' => 'required',
            ]);
        }

        try {
            if ($request->submit === 'true' && $invoice->status_invoice != 'Draft') {
                $fileNameProofOfPayment = null;
                $fileNamePhotoOfItem = null;

                if ($request->payment_method == 'Transfer' && $request->file('proof_of_payment')) {
                    $file = $request->file('proof_of_payment');
                    $fileNameProofOfPayment = $file->getClientOriginalName();
                    $destinationPath = public_path('/assets/uploads/proof_of_payment');
                    $file->move($destinationPath, $fileNameProofOfPayment);
                }

                if ($request->file('photo_of_item')) {
                    $file = $request->file('photo_of_item');
                    $fileNamePhotoOfItem = $file->getClientOriginalName();
                    $destinationPath = public_path('/assets/uploads/photo_of_item');
                    $file->move($destinationPath, $fileNamePhotoOfItem);
                }

                if ($invoice->status_invoice !== $request->status_invoice) {
                    $historyPayment = HistoryPayment::create([
                        'invoice_id' => $invoice->id,
                        'before' => $invoice->status_invoice,
                        'after' => $request->status_invoice,
                    ]);
                }

                $invoice->update([
                    'status_invoice' => $request->status_invoice,
                    'status_payment' => $request->status_invoice === 'Lunas' ? 'Paid' : 'Not Yet',
                    'payment_method' => $request->payment_method,
                    'notes' => $request->notes,
                    'proof_of_payment' => $fileNameProofOfPayment,
                    'photo_of_item' => $fileNamePhotoOfItem,
                ]);
            } else {
                $invoice->update([
                    'order_id' => $request->order_id,
                    'customer_id' => $request->customer_id,
                    'status_invoice' => $request->submit === 'true' ? 'Belum DP' : 'Draft',
                    'date' => $request->date,
                    'due_date' => $request->due_date,
                    'brand_id' => $request->brand_id,
                    'tax' => 0,
                    'subtotal' => str_replace(",", "", $request->total_amount),
                    'total' => str_replace(",", "", $request->total_amount),
                ]);

                $deleteDetailInvoice = DetailInvoice::where('invoice_id', '=', $invoice->id)->delete();
                foreach ($request->detail_items as $value) {
                    $detail_invoice = DetailInvoice::create([
                        'invoice_id' => $invoice->id,
                        'item' => $value['item'],
                        'category_id' => $value['category_id'],
                        'qty' => str_replace(",", "", $value['qty']),
                        'price' => str_replace(",", "", $value['price']),
                        'total' => str_replace(",", "", $value['amount']),
                    ]);
                }
            }

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
                                ->join('customers', 'customers.id', '=', 'invoices.customer_id')
                                ->where('invoices.id', '=', $request->id)
                                ->select('invoices.*', 'brands.image as logo', 'brands.name as brand_name', 'brands.address as brand_address',
                                        'brands.no_rekening as brand_rekenings', 'customers.name as customer_name')
                                ->first();

        $detail_invoices = DetailInvoice::join('items', 'items.id', '=', 'detail_invoices.item_id')
                                ->where('invoice_id', '=', $request->id)
                                ->select('detail_invoices.*', 'items.name as item_name', 'items.size as item_size')
                                ->get();

        $imagePath = public_path('/assets/uploads/logo/' . $invoice['logo']);
        $src = "";
        if ($invoice['logo']) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $src = 'data:'.mime_content_type($imagePath).';base64,'.$imageData;
        }

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
