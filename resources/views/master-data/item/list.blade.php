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
        @slot('title') Item @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-sm-start">
                        <button
                            type="button"
                            class="btn btn-success waves-effect btn-label waves-light mb-3"
                            onclick="window.location='{{ route('showFormItem') }}'"
                        >
                            <i class="bx bx-user-plus label-icon me-1"></i>
                            Add Item
                        </button>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item['brand'] }}</td>
                                    <td>{{ $item['code'] }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['size'] }}</td>
                                    <td>{{ $item['qty'] }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-3">
                                            <i
                                                class="mdi mdi-pencil font-size-18 text-success"
                                                style="cursor: pointer"
                                                onclick="edit({{$item->id}})"
                                            ></i>
                                            <i
                                                class="mdi mdi-delete font-size-18 text-success"
                                                style="cursor: pointer"
                                                data-bs-toggle="modal"
                                                data-bs-target="#exampleModal"
                                                onclick="destroy({{$item->id}})"
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
            let url = "{{ route('showFormItem', ':id') }}";
            url = url.replace(':id', id);
            document.location.href = url;
        };

        function destroy(id) {
            if (confirm("Are you sure, Data will be deleted?") == true) {
                let url = "{{ route('deleteItem', ':id') }}";
                url = url.replace(':id', id);
                document.location.href = url;
            } else {

            }
        };
    </script>

    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection