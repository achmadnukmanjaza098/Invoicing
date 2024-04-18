@extends('layouts.master')

@section('title')
    @lang('translation.Orders')
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Master Data @endslot
        @slot('title') Invoice @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-sm-start">
                        <button
                            type="button"
                            class="btn btn-success waves-effect btn-label waves-light mb-3"
                            onclick="window.location='{{ route('showFormInvoice') }}'"
                        >
                            <i class="bx bx-user-plus label-icon me-1"></i>
                            Add Invoice
                        </button>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Payment</th>
                                <th>Brand</th>
                                <th>Customer</th>
                                <th>Invoice Date</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice['order_id'] }}</td>
                                    <td>
                                        @if ($invoice['status_payment'] == 'Paid')
                                                <span class="badge badge-pill badge-soft-success font-size-12">
                                                    {{ $invoice['status_payment'] }} - {{ $invoice['payment_method'] }}
                                                    @if ($invoice['payment_method'] == 'Cash')
                                                        <i class="bx bx-money"></i>
                                                    @else
                                                        <i class="bx bx-transfer-alt"></i>
                                                    @endif
                                                </span>
                                            @else
                                                <span class="badge badge-pill badge-soft-danger font-size-12">{{ $invoice['status_payment'] }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $invoice['brand'] }}</td>
                                    <td>{{ $invoice['customer'] }}</td>
                                    <td>{{ $invoice['date'] }}</td>
                                    <td>{{ $invoice['total'] }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-3">
                                            <i
                                                class="mdi mdi-pencil font-size-18 text-warning"
                                                style="cursor: pointer"
                                                onclick="edit({{$invoice->id}})"
                                            ></i>
                                            @if (!$invoice['payment_method'])
                                                <i
                                                    class="mdi mdi-delete font-size-18 text-danger"
                                                    style="cursor: pointer"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal"
                                                    onclick="destroy({{$invoice->id}})"
                                                ></i>
                                            @endif
                                            <i
                                                class="mdi mdi-download font-size-18 text-success"
                                                style="cursor: pointer"
                                                onclick="download({{$invoice->id}})"
                                            ></i>
                                        </div>
                                    </td>
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
        function edit(id) {
            let url = "{{ route('showFormInvoice', ':id') }}";
            url = url.replace(':id', id);
            document.location.href = url;
        };

        function destroy(id) {
            if (confirm("Are you sure, Data will be deleted?") == true) {
                let url = "{{ route('deleteInvoice', ':id') }}";
                url = url.replace(':id', id);
                document.location.href = url;
            } else {

            }
        };
        function download(id) {
            let url = "{{ route('downloadInvoice', ':id') }}";
            url = url.replace(':id', id);
            document.location.href = url;
        };
    </script>

    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection