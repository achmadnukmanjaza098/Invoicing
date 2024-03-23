@extends('layouts.master')

@section('title') @lang('translation.Form_Repeater') @endsection

@section('css')
    {{-- <style>
        .select2-container--open .select2-dropdown {
            width: 92.2em !important; /* Sesuaikan lebar dropdown sesuai kebutuhan */
            left: 12px !important; /* Sesuaikan lebar dropdown sesuai kebutuhan */
            max-height: 200px !important; /* Sesuaikan tinggi maksimum dropdown sesuai kebutuhan */
            overflow-y: auto !important; /* Tambahkan scrolling jika konten melebihi tinggi maksimum */
        }
    </style> --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') User @endslot
        @slot('li_2')
            <button
                type="button"
                class="btn btn-danger waves-effect btn-label waves-light"
                onclick="window.location='{{ route('user') }}'"
            >
                <i class="bx bx-arrow-back label-icon me-1"></i>
                Back
            </button>
        @endslot
        @slot('title') User Form @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if(session()->has('success'))
                    <div class="card-header alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="max-height:30px; padding: 0">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>Success!</strong> Data insert success</span>
                        </div>
                    </div>
                @elseif(session()->has('failed'))
                    <div class="card-header alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="text-center">
                            <span class="alert-icon"><i class="ni ni-cross"></i></span>
                            <span class="alert-text"><strong>Failed!</strong> Data insert failed</span>
                            </button>
                        </div>
                    </div>
                @endif
                @if($errors->any())
                    <div class="card-header alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="text-left">
                            <span class="alert-icon"><i class="ni ni-cross"></i></span>
                            @foreach($errors->all() as $error)
                                <span class="alert-text"><strong>Failed!</strong> {{ $error }}</span> <br>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="card-body">
                    <form method="post" action="{{ route('storeUser') }}" enctype="multipart/form-data">
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

                                        <div class="mb-3">
                                            <label for="password">Password * :</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="password"
                                                name="password"
                                                placeholder="Enter Password...">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="avatar">Avatar :</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="avatar"
                                                name="avatar"
                                                placeholder="Enter Avatar...">
                                        </div>

                                        <div class="mb-3">
                                            <label for="role">Role * :</label>
                                            <select class="form-control select2" id="role" name="role">
                                                <option>Select Role...</option>
                                                <option value="admin">Admin</option>
                                                <option value="staff">Staff</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="access_brand">Access Brand * :</label>
                                            <select class="form-control select2" id="access_brand" name="access_brand[]" multiple="multiple">
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
