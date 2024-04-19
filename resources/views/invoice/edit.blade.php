@extends('layouts.master')

@section('title')
    @lang('translation.Form_Repeater')
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
                                                            <input class="form-control" type="text"
                                                                value="{{ $invoice->order_id }}" disabled>
                                                        </div>
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
                                                        <div class="mb-3">
                                                            <label for="brand_id">Brand * :</label>
                                                            <select class="form-control select2" disabled>
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
                                                            <input class="form-control" type="date"
                                                                value="{{ $invoice->date }}" disabled>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="due_date">Due Date * :</label>
                                                            <input class="form-control" type="date"
                                                                value="{{ $invoice->due_date }}" disabled>
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
                                                <table class="table table-editable table-nowrap align-middle table-edits">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 30%">Item</th>
                                                            <th style="width: 18%">Qty</th>
                                                            <th style="width: 19%">Price</th>
                                                            <th style="width: 20%">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="detail_invoices">
                                                        @foreach ($detail_invoices as $detail_invoice)
                                                            <tr>
                                                                <td>{{ $detail_invoice['item'] }}</td>
                                                                <td>{{ $detail_invoice['qty'] }}</td>
                                                                <td>{{ $detail_invoice['price'] }}</td>
                                                                <td>{{ $detail_invoice['total'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

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
                                                        <div class="mb-3" id="file-upload-section" style="display: none;">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($invoice->status_payment == 'Not Yet')
                                    <button type="submit" class="btn btn-primary"
                                        style="margin-top: 27px;">Submit</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="file-preview"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();

            function checkPaymentStatus() {
                var status_payment = '{{ $invoice->status_payment }}';
                var payment_method = $('#payment_method').val();
                var status_invoice = $('#status_invoice').val();

                if (status_payment === 'Paid' && status_invoice === 'Lunas' && payment_method === 'Transfer') {
                    $('#file-upload-section').show();
                    $('#proof_of_payment').prop('disabled', true);
                    var previewButton = $(
                        '<button type="button" class="btn btn-sm btn-outline-info waves-effect mt-2" id="previewButton"><i class="mdi mdi-eye"></i> Preview</button>'
                    );
                    previewButton.insertAfter('#proof_of_payment');
                    previewButton.click(function() {
                        $('#previewModal').modal('show');
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
                    $('#file-preview').html(preview);
                } else {
                    if (status_invoice === 'Lunas' && payment_method === 'Transfer') {
                        $('#file-upload-section').show();
                    } else {
                        $('#proof_of_payment').val('');
                        $('#file-upload-section').hide();
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

                        $('#file-preview').html(preview);
                        $('#previewButton').remove();
                        var previewButton = $(
                            '<button type="button" class="btn btn-sm btn-outline-info waves-effect mt-2" id="previewButton"><i class="mdi mdi-eye"></i> Preview</button>'
                        );
                        previewButton.insertAfter('#proof_of_payment');
                        previewButton.click(function() {
                            $('#previewModal').modal('show');
                        });
                    };
                    fileReader.readAsDataURL(file);
                } else {
                    alert('Invalid file type. Please upload an image or PDF.');
                }
            });
        });
    </script>

    <script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
