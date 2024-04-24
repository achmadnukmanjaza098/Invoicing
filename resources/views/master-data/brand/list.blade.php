@extends('layouts.master')

@section('title')
    Web Invoicing | Brand
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Master Data @endslot
        @slot('title') Brand @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-sm-start">
                        <button
                            type="button"
                            class="btn btn-success waves-effect btn-label waves-light mb-3"
                            onclick="window.location='{{ route('showFormBrand') }}'"
                        >
                            <i class="bx bx-user-plus label-icon me-1"></i>
                            Add Brand
                        </button>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>{{ $brand['name'] }}</td>
                                    <td>{{ $brand['address'] }}</td>
                                    <td>{{ $brand['phone'] }}</td>
                                    <td>
                                        @if ($brand['active'] == 1)
                                                <span class="badge badge-pill badge-soft-success font-size-12">Active</span>
                                            @else
                                                <span class="badge badge-pill badge-soft-danger font-size-12">Deactive</span>
                                        @endif
                                    <td>
                                        <div class="d-flex justify-content-center gap-3">
                                            <i
                                                class="mdi mdi-pencil font-size-18 text-success"
                                                style="cursor: pointer"
                                                onclick="edit({{$brand->id}})"
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
            let url = "{{ route('showFormBrand', ':id') }}";
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