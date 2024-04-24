@extends('layouts.master')

@section('title')
    Web Invoicing | User
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master Data
        @endslot
        @slot('title')
            User
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-sm-start">
                        <button
                            type="button"
                            class="btn btn-success waves-effect btn-label waves-light mb-3"
                            onclick="window.location='{{ route('showFormUser') }}'"
                        >
                            <i class="bx bx-user-plus label-icon me-1"></i>
                            Add User
                        </button>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Access Brand</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['role'] }}</td>
                                    <td>
                                        {{ $access_brands = '' }}
                                        @foreach (json_decode($user['access_brand']) as $i => $acces)
                                            @foreach ($brands as $brand)
                                                @if ($acces == $brand['id'])
                                                    @if ((count(json_decode($user['access_brand'])) - 1) == $i)
                                                        {{ $access_brands .= $brand['name'] }}
                                                    @else
                                                        {{ $access_brands .= $brand['name'].', ' }}
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($user['active'] == 1)
                                                <span class="badge badge-pill badge-soft-success font-size-12">Active</span>
                                            @else
                                                <span class="badge badge-pill badge-soft-danger font-size-12">Deactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-3">
                                            <i
                                                class="mdi mdi-pencil font-size-18 text-success"
                                                style="cursor: pointer"
                                                onclick="edit({{$user->id}})"
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
            let url = "{{ route('showFormUser', ':id') }}";
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

