@extends('layouts.master')

@section('title')
    Web Invoicing | Customer
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Customer
        @endslot
        @slot('title')
            List Customer
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-sm-start">
                        <button type="button" class="btn btn-success waves-effect btn-label waves-light mb-3"
                            onclick="window.location='{{ route('showFormCustomer') }}'">
                            <i class="bx bx-user-plus label-icon me-1"></i>
                            Add Customer
                        </button>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>No. Hp</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer['name'] }}</td>
                                    <td>{{ $customer['email'] }}</td>
                                    <td>{{ $customer['no_hp'] }}</td>
                                    <td>
                                        @if ($customer['active'] == 1)
                                            <span class="badge badge-pill badge-soft-success font-size-12">Active</span>
                                        @else
                                            <span class="badge badge-pill badge-soft-danger font-size-12">Deactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-3">
                                            <i class="mdi mdi-pencil font-size-18 text-success" style="cursor: pointer"
                                                onclick="edit({{ $customer->id }})"></i>
                                                <i class="mdi mdi-history font-size-18 text-success" style="cursor: pointer"
                                                data-bs-toggle="modal" data-bs-target=".transactionHistory"
                                                onclick="loadTransactionHistory({{ $customer->id }})"></i>
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

    <div class="modal fade transactionHistory" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Transaction History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="transaction-history-datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Status Invoice</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
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
            let url = "{{ route('showFormCustomer', ':id') }}";
            url = url.replace(':id', id);
            document.location.href = url;
        };

        function loadTransactionHistory(customerId) {
            $.ajax({
                url: '/customerTransactionHistory/' + customerId,
                type: 'GET',
                success: function(data) {
                    let tableBody = $('#transaction-history-datatable tbody');
                    tableBody.empty();
                    console.log('data', data)
                    data.forEach(transaction => {
                        tableBody.append(
                            `<tr>
                                <td>${transaction.order_id}</td>
                                <td>${transaction.status_invoice}</td>
                                <td>${transaction.total}</td>
                            </tr>`
                        );
                    });

                    if ($.fn.DataTable.isDataTable('#transaction-history-datatable')) {
                        $('#transaction-history-datatable').DataTable().destroy();
                    }

                    $('#transaction-history-datatable').DataTable();
                }
            });
        }

        $(document).ready(function() {
            $('#datatable').DataTable();
            $('.transactionHistory').on('shown.bs.modal', function() {
                $('#transaction-history-datatable').DataTable().columns.adjust().responsive.recalc();
            });
        });
    </script>

    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
