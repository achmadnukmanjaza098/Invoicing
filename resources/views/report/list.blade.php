@extends('layouts.master')

@section('title')
    Web Invoicing | Report
@endsection

@section('css')
    <style>
        /* .select2-container {
            margin-left: 16px !important;
        }
        .select2-dropdown {
            margin-right: 10px !important;
        } */
        .margin-right-16 {
            margin-right: 16px !important;
        }
    </style>

    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Report
        @endslot
        @slot('title')
            List Report
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-3">
                            <button type="button" class="btn btn-success waves-effect btn-label waves-light" id="export-button">
                                <i class="mdi mdi-download label-icon me-1"></i>
                                Export Report
                            </button>
                        </div>

                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <form id="filter-form" method="POST" action="{{ route('filterReport') }}" class="d-flex flex-wrap gap-3">
                                @csrf
                                <select id="status_invoice" name="status_invoice" class="form-control select2" style="width: 200px" value="{{ $status_invoice }}">
                                    <option value="" {{ $payment_method == '' ? 'selected' : '' }}>All Status Invoice</option>
                                    <option value="Belum DP" {{ $status_invoice == 'Belum DP' ? 'selected' : '' }}>Belum DP</option>
                                    <option value="Sudah DP" {{ $status_invoice == 'Sudah DP' ? 'selected' : '' }}>Sudah DP</option>
                                    <option value="Menunggu Pelunasan" {{ $status_invoice == 'Menunggu Pelunasan' ? 'selected' : '' }}>Menunggu Pelunasan</option>
                                    <option value="Lunas" {{ $status_invoice == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                </select>

                                <select id="payment_method" name="payment_method" class="form-control select2" style="width: 200px" value="{{ $payment_method }}">
                                    <option value="" {{ $payment_method == '' ? 'selected' : '' }}>All Payment Method</option>
                                    <option value="Cash" {{ $payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Transfer" {{ $payment_method == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                </select>

                                <button type="submit" class="btn btn-primary" id="apply-filter-button">Apply Filter</button>
                            </form>
                        </div>
                    </div><br>

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Payment</th>
                                <th>Brand</th>
                                <th>Customer</th>
                                <th>Invoice Date</th>
                                <th>Total</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $report['order_id'] }}</td>
                                    <td>
                                        @if ($report['status_payment'] == 'Paid')
                                            <span class="badge badge-pill badge-soft-success font-size-12">
                                                @if ($report['payment_method'] == 'Cash')
                                                    <i class="bx bx-money"></i>
                                                @else
                                                    <i class="bx bx-transfer-alt"></i>
                                                @endif
                                                {{ $report['payment_method'] }} - {{ $report['status_payment'] }}
                                            </span>
                                        @else
                                            @if ($report['payment_method'])
                                                <span class="badge badge-pill badge-soft-danger font-size-12">
                                                    @if ($report['payment_method'] == 'Cash')
                                                        <i class="bx bx-money"></i>
                                                    @else
                                                        <i class="bx bx-transfer-alt"></i>
                                                    @endif
                                                    {{ $report['payment_method'] }} -
                                                    {{ $report['status_invoice'] }}
                                                </span>
                                            @else
                                                <span
                                                    class="badge badge-pill badge-soft-danger font-size-12">{{ $report['status_payment'] }}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $report['brand'] }}</td>
                                    <td>{{ $report['customer'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($report['date'])->format('d - m - Y') }}</td>
                                    <td>Rp {{ number_format($report['total'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#export-button').click(function() {
                var statusInvoice = $('#status_invoice').val();
                var paymentMethod = $('#payment_method').val();

                var downloadUrl = 'exportReport?status_invoice=' + statusInvoice + '&payment_method=' + paymentMethod;

                var $a = $('<a>', {
                    href: downloadUrl,
                    target: '_blank'
                });

                $a.appendTo('body').get(0).click();
                $a.remove();
            });
        })
    </script>

    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
