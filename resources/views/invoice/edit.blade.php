@extends('layouts.master')

@section('title')
    Web Invoicing | Invoice
@endsection

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Invoice
        @endslot
        @slot('li_2')
            <button type="button" class="btn btn-danger waves-effect btn-label waves-light"
                onclick="window.location='{{ route('invoice') }}'">
                <i class="bx bx-arrow-back label-icon me-1"></i>
                Back
            </button>
        @endslot
        @slot('title')
            Invoice Form
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if (session()->has('success'))
                    <div class="card-header alert alert-success alert-dismissible fade show" role="alert">
                        <div class="text-left">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>Success!</strong> Data insert success</span>
                        </div>
                    </div>
                @elseif(session()->has('failed'))
                    <div class="card-header alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="text-left">
                            <span class="alert-icon"><i class="ni ni-cross"></i></span>
                            <span class="alert-text"><strong>Failed!</strong> Data insert failed</span>
                            </button>
                        </div>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="card-header alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="text-left">
                            <span class="alert-icon"><i class="ni ni-cross"></i></span>
                            @foreach ($errors->all() as $error)
                                <span class="alert-text"><strong>Failed!</strong> {{ $error }}</span> <br>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="card-body">
                    <form method="post" action="{{ route('updateInvoice', $invoice->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div data-repeater-list="outer-group" class="outer">
                            <div data-repeater-item class="outer">
                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                                aria-controls="panelsStayOpen-collapseOne">
                                                <b>Header Invoice</b>
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="panelsStayOpen-headingOne">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="date">Order Id * :</label>
                                                            <input class="form-control" type="text" id="order_id" name="order_id"
                                                                value="{{ $invoice->order_id }}">
                                                        </div>
                                                        @if ($invoice->status_invoice == 'Draft')
                                                            <div class="row mb-3">
                                                                <div class="col-12 col-md-7">
                                                                    <label for="customer_id">Customer * :</label>
                                                                    <select class="form-control select2" id="customer_id" name="customer_id">
                                                                        <option value="">Select Customer</option>
                                                                        @foreach ($customers as $customer)
                                                                            @if ($customer->id == $invoice->customer_id)
                                                                                ))
                                                                                <option value="{{ $customer->id }}" selected>
                                                                                    {{ $customer->name }}</option>
                                                                            @else
                                                                                <option value="{{ $customer->id }}">
                                                                                    {{ $customer->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-12 col-md-3">
                                                                    <button type="button" class="btn btn-success waves-effect btn-label waves-light"
                                                                            style="margin-top: 1.8rem;"
                                                                            data-bs-toggle="modal" data-bs-target="#formAddCustomer">
                                                                        <i class="bx bx-user-plus label-icon me-1"></i> Customer
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="mb-3">
                                                                <label for="customer_id">Customer * :</label>
                                                                <select class="form-control select2" disabled>
                                                                    @foreach ($customers as $customer)
                                                                        @if ($customer->id == $invoice->customer_id)
                                                                            ))
                                                                            <option value="{{ $customer->id }}" selected>
                                                                                {{ $customer->name }}</option>
                                                                        @else
                                                                            <option value="{{ $customer->id }}">
                                                                                {{ $customer->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @endif
                                                        <div class="mb-3">
                                                            <label for="brand_id">Brand * :</label>
                                                            <select class="form-control select2" id="brand_id" name="brand_id">
                                                                @foreach ($brands as $brand)
                                                                    @if ($brand->id == $invoice->brand_id)
                                                                        ))
                                                                        <option value="{{ $brand->id }}" selected>
                                                                            {{ $brand->name }}</option>
                                                                    @else
                                                                        <option value="{{ $brand->id }}">
                                                                            {{ $brand->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="date">Date * :</label>
                                                            <input class="form-control" type="date" id="date" name="date"
                                                                value="{{ $invoice->date }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="due_date">Due Date * :</label>
                                                            <input class="form-control" type="date" id="due_date" name="due_date"
                                                                value="{{ $invoice->due_date }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true"
                                                aria-controls="panelsStayOpen-collapseTwo">
                                                <b>Detail Invoice</b>
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show"
                                            aria-labelledby="panelsStayOpen-headingTwo">
                                            <div class="accordion-body">
                                            @if ($invoice->status_invoice == 'Draft')
                                                <div class="accordion-body">
                                                    <div style="text-align: right;">
                                                        <button type="button" id="add"
                                                            class="btn btn-sm btn-success waves-effect btn-label waves-light mb-3">
                                                            <i class="bx bx-plus label-icon me-1"></i>
                                                            Add Item
                                                        </button>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-editable table-nowrap align-middle table-edits">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 29%">Item</th>
                                                                    <th style="width: 12%">Qty</th>
                                                                    <th style="width: 12%">Category</th>
                                                                    <th style="width: 12%">Price</th>
                                                                    <th style="width: 15%">Amount</th>
                                                                    <th style="width: 5%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="detail_invoices">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @else
                                                <table class="table table-editable table-nowrap align-middle table-edits">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 3%">#</th>
                                                            <th style="width: 30%">Item</th>
                                                            <th style="width: 10%">Qty</th>
                                                            <th style="width: 10%">Category</th>
                                                            <th style="width: 17%">Price</th>
                                                            <th style="width: 17%">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($detail_invoices as $i => $detail_invoice)
                                                            <tr>
                                                                <td>{{ $i + 1 }}</td>
                                                                <td>{{ $detail_invoice['item'] }}</td>
                                                                <td>{{ $detail_invoice['qty'] }}</td>
                                                                <td>{{ $detail_invoice['category_name'] }}</td>
                                                                <td>{{ number_format($detail_invoice['price'], 2) }}</td>
                                                                <td>{{ number_format($detail_invoice['total'], 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($invoice->status_invoice != 'Draft')
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true"
                                                    aria-controls="panelsStayOpen-collapseThree">
                                                    <b>Payment</b>
                                                </button>
                                            </h2>
                                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show"
                                                aria-labelledby="panelsStayOpen-headingThree">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="payment_method">Payment Method * :</label>
                                                                @if ($invoice->payment_method)
                                                                    <select class="form-control select2"
                                                                        value="{{ $invoice->payment_method }}"
                                                                        id="payment_method" name="payment_method"
                                                                        @if ($invoice->status_payment == 'Paid')
                                                                            Disabled
                                                                        @endif>
                                                                        <option value="Cash"
                                                                            {{ $invoice->payment_method == 'Cash' ? 'selected' : '' }}>
                                                                            Cash</option>
                                                                        <option value="Transfer"
                                                                            {{ $invoice->payment_method == 'Transfer' ? 'selected' : '' }}>
                                                                            Transfer</option>
                                                                    </select>
                                                                @else
                                                                    <select class="form-control select2" id="payment_method"
                                                                        name="payment_method">
                                                                        <option value="">Select Payment Method</option>
                                                                        <option value="Cash">Cash</option>
                                                                        <option value="Transfer">Transfer</option>
                                                                    </select>
                                                                @endif
                                                            </div>
                                                            <div class="mb-3" id="file-upload-photo-of-item">
                                                                <label for="photo_of_item">Photo of Item :</label>
                                                                <input type="file" class="form-control"
                                                                    id="photo_of_item" name="photo_of_item"
                                                                    value="{{ $invoice->photo_of_item }}">
                                                            </div>
                                                            <div class="mb-3" id="file-upload-proof-of-payment" style="display: none;">
                                                                <label for="proof_of_payment">Proof of Payment :</label>
                                                                <input type="file" class="form-control"
                                                                    id="proof_of_payment" name="proof_of_payment"
                                                                    value="{{ $invoice->proof_of_payment }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="status_invoice">Status Payment * :</label>
                                                                @if ($invoice->status_invoice)
                                                                    <select class="form-control select2"
                                                                        value="{{ $invoice->status_invoice }}"
                                                                        id="status_invoice" name="status_invoice"
                                                                        @if ($invoice->status_payment == 'Paid')
                                                                            Disabled
                                                                        @endif>
                                                                        <option value="Belum DP"
                                                                            {{ $invoice->status_invoice == 'Belum DP' ? 'selected' : '' }}>
                                                                            Belum DP</option>
                                                                        <option value="Sudah DP"
                                                                            {{ $invoice->status_invoice == 'Sudah DP' ? 'selected' : '' }}>
                                                                            Sudah DP</option>
                                                                        <option value="Menunggu Pelunasan"
                                                                            {{ $invoice->status_invoice == 'Menunggu Pelunasan' ? 'selected' : '' }}>
                                                                            Menunggu Pelunasan</option>
                                                                        <option value="Lunas"
                                                                            {{ $invoice->status_invoice == 'Lunas' ? 'selected' : '' }}>
                                                                            Lunas</option>
                                                                    </select>
                                                                @else
                                                                    <select class="form-control select2" id="status_invoice"
                                                                        name="status_invoice">
                                                                        <option value="">Select Status Invoice</option>
                                                                        <option value="Belum DP">Belum DP</option>
                                                                        <option value="Sudah DP">Sudah DP</option>
                                                                        <option value="Menunggu Pelunasan">Menunggu Pelunasan
                                                                        </option>
                                                                        <option value="Lunas">Lunas</option>
                                                                    </select>
                                                                @endif
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Notes * :</label>
                                                                <div>
                                                                    <textarea class="form-control" rows="3" id="notes" name="notes">{{ $invoice->notes ? $invoice->notes : "" }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true"
                                                    aria-controls="panelsStayOpen-collapseTwo">
                                                    <b>History Status Payment</b>
                                                </button>
                                            </h2>
                                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show"
                                                aria-labelledby="panelsStayOpen-headingTwo">
                                                <div class="accordion-body">
                                                    <table class="table table-editable table-nowrap align-middle table-edits">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%">#</th>
                                                                <th style="width: 35%">Status Payment Before</th>
                                                                <th style="width: 35%">Status Payment After</th>
                                                                <th style="width: 20%">Updated At</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($historyPayments as $i => $historyPayment)
                                                                <tr>
                                                                    <td>{{ $i + 1 }}</td>
                                                                    <td>{{ $historyPayment['before'] }}</td>
                                                                    <td>{{ $historyPayment['after'] }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($historyPayment['created_at'])->format('d - m - Y') }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if ($invoice->status_invoice == 'Draft')
                                    <button type="submit" name="submit" value=false class="btn btn-primary" style="margin-top: 27px;">Save Draft</button>
                                @endif
                                @if ($invoice->status_payment == 'Not Yet')
                                    <input type="hidden" name="total_amount" id="total_amount" value="0">
                                    <button type="submit" name="submit" value=true class="btn btn-primary" style="margin-top: 27px;">Submit</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="modal fade" id="formAddCustomer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Form Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('storeCustomer') }}" enctype="multipart/form-data">
                        @csrf
                        <div data-repeater-list="outer-group" class="outer">
                            <div data-repeater-item class="outer">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="name">Name * :</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                placeholder="Enter Name..."
                                            >
                                        </div>
                                        <div class="mb-3">
                                            <label for="email">Email * :</label>
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="email"
                                                name="email"
                                                placeholder="Enter Email..."
                                            >
                                        </div>
                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                            <input type="hidden" id="active_hidden" name="active_hidden" value=1>
                                            <input class="form-check-input" type="checkbox" id="active" name="active" checked>
                                            <label class="form-check-label" for="active">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="no_hp">No. Hp * :</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="no_hp"
                                                name="no_hp"
                                                placeholder="Enter No. Hp..."
                                            >
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary" style="margin-top: 27px;">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal-photo-of-item" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="file-preview-photo-of-item"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal-proof-of-payment" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="file-preview-proof-of-payment"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.modal').find('#active').change(function () {
                var activeValue = $(this).prop('checked');
                $('#active_hidden').val(activeValue ? 1 : 0);
            });

            var isInvoiceDraft = '{{ $invoice->status_invoice }}';
            var detail_invoices = {!! json_encode($detail_invoices) !!}
            if (isInvoiceDraft != 'Draft') {
                $('#brand_id').prop('disabled', true);
                $('#order_id').prop('disabled', true);
                $('#date').prop('disabled', true);
                $('#due_date').prop('disabled', true);
            }

            function checkPaymentStatus() {
                var photo_of_item = '{{ $invoice->photo_of_item }}';
                var proof_of_payment = '{{ $invoice->proof_of_payment }}';
                var status_payment = '{{ $invoice->status_payment }}';
                var payment_method = $('#payment_method').val();
                var status_invoice = $('#status_invoice').val();

                if (status_payment === 'Paid') {
                    $('#proof_of_payment').prop('disabled', true);
                    $('#photo_of_item').prop('disabled', true);
                    $('#notes').prop('disabled', true);
                }

                console.log('photo_of_item', photo_of_item)
                if (photo_of_item !== '') {
                    $('#previewButton-photo-of-item').remove();
                    var previewButton = $(
                        '<button type="button" class="btn btn-sm btn-outline-info waves-effect mt-2" id="previewButton-photo-of-item"><i class="mdi mdi-eye"></i> Preview</button>'
                    );
                    previewButton.insertAfter('#photo_of_item');
                    previewButton.click(function() {
                        $('#previewModal-photo-of-item').modal('show');
                    });

                    var preview;
                    if (photo_of_item.includes('.pdf')) {
                        preview = '<embed src="/assets/uploads/photo_of_item/' + photo_of_item +
                            '" width="100%" height="600px" />';
                    } else {
                        preview = '<img src="/assets/uploads/photo_of_item/' + photo_of_item +
                            '" style="max-width: 100%; max-height: 600px;" />';
                    }
                    $('#file-preview-photo-of-item').html(preview);
                }

                if (proof_of_payment !== '' && payment_method === 'Transfer') {
                    $('#file-upload-proof-of-payment').show();

                    $('#previewButton-proof-of-payment').remove();
                    var previewButton = $(
                        '<button type="button" class="btn btn-sm btn-outline-info waves-effect mt-2" id="previewButton-proof-of-payment"><i class="mdi mdi-eye"></i> Preview</button>'
                    );
                    previewButton.insertAfter('#proof_of_payment');
                    previewButton.click(function() {
                        $('#previewModal-proof-of-payment').modal('show');
                    });

                    var proof_of_payment_link = '{{ $invoice->proof_of_payment }}';

                    var preview;
                    if (proof_of_payment_link.includes('.pdf')) {
                        preview = '<embed src="/assets/uploads/proof_of_payment/' + proof_of_payment_link +
                            '" width="100%" height="600px" />';
                    } else {
                        preview = '<img src="/assets/uploads/proof_of_payment/' + proof_of_payment_link +
                            '" style="max-width: 100%; max-height: 600px;" />';
                    }
                    $('#file-preview-proof-of-payment').html(preview);
                } else {
                    if (payment_method === 'Transfer') {
                        $('#file-upload-proof-of-payment').show();
                    } else {
                        $('#proof_of_payment').val('');
                        $('#file-upload-proof-of-payment').hide();
                    }
                }
            }

            checkPaymentStatus();

            $('#status_invoice').change(function() {
                checkPaymentStatus();
            });

            $('#payment_method').change(function() {
                checkPaymentStatus();
            });

            $('#proof_of_payment').change(function() {
                var file = this.files[0];
                var fileType = file.type;
                var fileName = file.name;

                if (fileType.includes('image/') || fileType === 'application/pdf') {
                    var fileReader = new FileReader();
                    fileReader.onload = function(e) {
                        var preview;
                        if (fileType === 'application/pdf') {
                            preview = '<embed src="' + e.target.result +
                                '" width="100%" height="600px" />';
                        } else {
                            preview = '<img src="' + e.target.result +
                                '" style="max-width: 100%; max-height: 600px;" />';
                        }

                        $('#file-preview-proof-of-payment').html(preview);
                        $('#previewButton-proof-of-payment').remove();
                        var previewButton = $(
                            '<button type="button" class="btn btn-sm btn-outline-info waves-effect mt-2" id="previewButton-proof-of-payment"><i class="mdi mdi-eye"></i> Preview</button>'
                        );
                        previewButton.insertAfter('#proof_of_payment');
                        previewButton.click(function() {
                            $('#previewModal-proof-of-payment').modal('show');
                        });
                    };
                    fileReader.readAsDataURL(file);
                } else {
                    alert('Invalid file type. Please upload an image or PDF.');
                }
            });

            $('#photo_of_item').change(function() {
                var file = this.files[0];
                var fileType = file.type;
                var fileName = file.name;

                if (fileType.includes('image/') || fileType === 'application/pdf') {
                    var fileReader = new FileReader();
                    fileReader.onload = function(e) {
                        var preview;
                        if (fileType === 'application/pdf') {
                            preview = '<embed src="' + e.target.result +
                                '" width="100%" height="600px" />';
                        } else {
                            preview = '<img src="' + e.target.result +
                                '" style="max-width: 100%; max-height: 600px;" />';
                        }

                        $('#file-preview-photo-of-item').html(preview);
                        $('#previewButton-photo-of-item').remove();
                        var previewButton = $(
                            '<button type="button" class="btn btn-sm btn-outline-info waves-effect mt-2" id="previewButton-photo-of-item"><i class="mdi mdi-eye"></i> Preview</button>'
                        );
                        previewButton.insertAfter('#photo_of_item');
                        previewButton.click(function() {
                            $('#previewModal-photo-of-item').modal('show');
                        });
                    };
                    fileReader.readAsDataURL(file);
                } else {
                    alert('Invalid file type. Please upload an image or PDF.');
                }
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id").replace('remove',
                    '');
                $('#row' + button_id + '').remove();
            });

            $(document).on('input',
                'input[name^="detail_items"][name$="][qty]"], input[name^="detail_items"][name$="][price]"]',
                function() {
                    $(this).val($(this).val().replace(/[^0-9.]/g, ''));
                    var rowNumber = $(this).closest('tr').attr('id').replace('row', '');
                    calculateAmount(rowNumber);
                });

            $(document).on('blur',
                'input[name^="detail_items"][name$="][qty]"], input[name^="detail_items"][name$="][price]"]',
                function() {
                    var value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        $(this).val(value.toLocaleString());
                    }
                });

            function calculateAmount(rowNumber) {
                var row = $(`#row${rowNumber}`);
                var qty = row.find('input[name^="detail_items"][name$="[qty]"]').val();
                var price = row.find('input[name^="detail_items"][name$="[price]"]').val();

                var amount = parseFloat(qty) * parseFloat(price);
                if (isNaN(amount)) amount = 0;
                row.find('input[name^="detail_items"][name$="[amount]"]').val(amount);
                row.find('input[name^="detail_items"][name$="[display_amount]"]').val(amount.toLocaleString());
            }

            $('form').one('submit', function(event) {
                updateTotalAmount();
            });

            function updateTotalAmount() {
                var totalAmount = 0;
                $('input[name^="detail_items"][name$="[amount]"]').each(function() {
                    totalAmount += parseFloat($(this).val().replace(',', '')) || 0;
                });
                $('#total_amount').val(totalAmount.toLocaleString());
            }

            function populateCategory(category_id) {
                var categories = {!! json_encode($categories) !!}

                var options = '<option value="">Select Category</option>';
                categories.forEach(function(item) {
                    if (item.id == category_id) {
                        options += '<option value="' + item.id + '" selected>' + item.name + '</option>';
                    } else {
                        options += '<option value="' + item.id + '">' + item.name + '</option>';
                    }
                });

                $('select[name^="detail_items"][name$="[category_id]"]').last().html(options).prop('disabled', false);
            }

            $('#add').click(function() {
                addRow();
            });

            var rowCount = 0;

            function addRow() {
                var newRow = `
                    <tr id="row${rowCount}">
                        <td>
                            <input type="text" class="form-control table-input-height" name="detail_items[${rowCount}][item]" placeholder="Enter Item...">
                        </td>
                        <td>
                            <input type="text" class="form-control table-input-height" name="detail_items[${rowCount}][qty]" placeholder="Enter Qty...">
                        </td>
                        <td>
                            <select class="form-control select2" name="detail_items[${rowCount}][category_id]">
                                <option value="">Select Category</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control table-input-height" name="detail_items[${rowCount}][price]" placeholder="Enter Price...">
                        </td>
                        <td>
                            <input type="hidden" name="detail_items[${rowCount}][amount]" value="0">
                            <input type="text" class="form-control table-input-height" name="detail_items[${rowCount}][display_amount]" disabled>
                        </td>
                        <td>
                            ${rowCount !== 0 ? `<button type="button" name="remove" id="remove${rowCount}" class="btn btn-danger btn_remove"><i class="bx bxs-trash"></i></button>` : ''}
                        </td>
                    </tr>`;
                $('#detail_invoices').append(newRow);
                $('.select2').select2();

                populateCategory(null);

                rowCount++;
            }

            function loadData(invoiceDetails) {
                if (!invoiceDetails || invoiceDetails.length === 0) {
                    return;  // No data to load, exit early
                }

                for (var i = 0; i < invoiceDetails.length; i++) {
                    var detail = invoiceDetails[i];

                    // Create the HTML structure for the table row
                    var rowHTML = `
                    <tr id="row${rowCount}">
                        <td>
                        <input type="text" class="form-control table-input-height" name="detail_items[${rowCount}][item]" placeholder="Enter Item..." value="${detail.item || ''}">
                        </td>
                        <td>
                        <input type="text" class="form-control table-input-height" name="detail_items[${rowCount}][qty]" placeholder="Enter Qty..." value="${detail.qty || ''}">
                        </td>
                        <td>
                        <select class="form-control select2" name="detail_items[${rowCount}][category_id]">
                            <option value="">Select Category</option>
                        </select>
                        </td>
                        <td>
                        <input type="text" class="form-control table-input-height" name="detail_items[${rowCount}][price]" placeholder="Enter Price..." value="${detail.price || ''}">
                        </td>
                        <td>
                        <input type="hidden" name="detail_items[${rowCount}][amount]" value="0">
                        <input type="text" class="form-control table-input-height" name="detail_items[${rowCount}][display_amount]" disabled>
                        </td>
                        <td>
                        ${rowCount !== 0 ? `<button type="button" name="remove" id="remove${rowCount}" class="btn btn-danger btn_remove"><i class="bx bxs-trash"></i></button>` : ''}
                        </td>
                    </tr>`;

                    // Append the row HTML to the table using append()
                    $('#detail_invoices').append(rowHTML);

                    // Initialize select2 for the newly added row
                    $('.select2').select2();

                    // Update amount and display_amount based on your logic (assuming these calculations are elsewhere)
                    $('#row' + rowCount + ' input[name="detail_items[' + rowCount + '][amount]"]').val(calculateAmount(detail.qty * detail.price) || detail.total);
                    $('#row' + rowCount + ' input[name="detail_items[' + rowCount + '][display_amount]"]').val(calculateAmount(detail.qty * detail.price) || detail.total);

                    populateCategory(detail.category_id);

                    rowCount++;
                }
            }

            if (detail_invoices) {
                loadData(detail_invoices);
            }

            $('.select2').select2();
        });
    </script>

    <script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
