@extends('layouts.master')

@section('title')
    @lang('translation.Form_Repeater')
@endsection

@section('css')
    <style>
        .table-input-height {
            height: 36px !important;
        }
    </style>
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
                    <form method="post" action="{{ route('storeInvoice') }}" enctype="multipart/form-data">
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
                                                            <input class="form-control" type="text" name="order_id" placeholder="Enter Order Id...">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="customer_id">Customer * :</label>
                                                            <select class="form-control select2" id="customer_id"
                                                                name="customer_id">
                                                                <option value="">Select Customer</option>
                                                                @foreach ($customers as $customer)
                                                                    <option value="{{ $customer->id }}">
                                                                        {{ $customer->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="date">Date * :</label>
                                                            <input class="form-control" type="date" name="date">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="due_date">Due Date * :</label>
                                                            <input class="form-control" type="date" name="due_date">
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
                                                <div style="text-align: right;">
                                                    <button type="button" id="add" class="btn btn-sm btn-success waves-effect btn-label waves-light mb-3">
                                                        <i class="bx bx-plus label-icon me-1"></i>
                                                        Add Item
                                                    </button>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-editable table-nowrap align-middle table-edits">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 14%">Brand</th>
                                                                <th style="width: 29%">Item</th>
                                                                <th style="width: 12%">Qty</th>
                                                                <th style="width: 17%">Price</th>
                                                                <th style="width: 17%">Amount</th>
                                                                <th style="width: 5%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="detail_invoices">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="total_amount" id="total_amount" value="0">

                                <button type="submit" class="btn btn-primary" style="margin-top: 27px;">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function updateTotalAmount() {
                var totalAmount = 0;
                $('input[name^="detail_items"][name$="[amount]"]').each(function() {
                    totalAmount += parseFloat($(this).val().replace(',', '')) || 0;
                });
                $('#total_amount').val(totalAmount.toLocaleString());
            }

            $('form').one('submit', function(event) {
                updateTotalAmount();
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

            var rowCount = 0;

            function addRow() {
                var newRow = `
                    <tr id="row${rowCount}">
                        <td>
                            <select class="form-control select2 brand-select" name="detail_items[${rowCount}][brand_id]">
                                <option value="">Select Brand</option>
                                ${brands.map(brand => `<option value="${brand.id}">${brand.name}</option>`).join('')}
                            </select>
                        </td>
                        <td>
                            <select class="form-control select2 item-select" name="detail_items[${rowCount}][item_id]" disabled>
                                <option value="">Select Item</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control table-input-height" name="detail_items[${rowCount}][qty]" placeholder="Enter Qty...">
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
                rowCount++;
            }

            $('#add').click(function() {
                addRow();
            });

            $(document).on('change', '.brand-select', function() {
                var brandId = $(this).val();
                var itemSelect = $(this).closest('tr').find('.item-select');
                itemSelect.empty();
                itemSelect.closest('tr').find('.size-select').empty().prop('disabled', true).append(
                    '<option value="">Select Size</option>');
                if (brandId) {
                    itemSelect.prop('disabled', false);
                    var itemsFound = items.filter(item => item.brand_id == brandId);
                    if (itemsFound.length > 0) {
                        itemsFound.forEach(item => {
                            itemSelect.append('<option value="">Select Item</option>')
                            itemSelect.append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    } else {
                        itemSelect.append(`<option value="" disabled>Data not found</option>`);
                    }
                } else {
                    itemSelect.prop('disabled', true);
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

            $('.select2').select2();

            var brands = {!! json_encode($brands) !!};
            var items = {!! json_encode($items) !!};

            addRow();
        });
    </script>

    <script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
