@extends('layouts.master')

@section('title')
    @lang('translation.Form_Repeater')
@endsection

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
        @slot('li_1')
            User
        @endslot
        @slot('li_2')
            <button type="button" class="btn btn-danger waves-effect btn-label waves-light"
                onclick="window.location='{{ route('user') }}'">
                <i class="bx bx-arrow-back label-icon me-1"></i>
                Back
            </button>
        @endslot
        @slot('title')
            User Form
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if (session()->has('success'))
                    <div class="card-header alert alert-success alert-dismissible fade show" role="alert">
                        <div class="text-left">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>Success!</strong> Data update success</span>
                        </div>
                    </div>
                @elseif(session()->has('failed'))
                    <div class="card-header alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="text-left">
                            <span class="alert-icon"><i class="ni ni-cross"></i></span>
                            <span class="alert-text"><strong>Failed!</strong> Data update failed</span>
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
                    <form method="post" action="{{ route('updateUser', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div data-repeater-list="outer-group" class="outer">
                            <div data-repeater-item class="outer">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="name">Name * :</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}" placeholder="Enter Name...">
                                        </div>

                                        <div class="mb-3">
                                            <label for="email">Email * :</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}" placeholder="Enter Email...">
                                        </div>

                                        <div class="mb-3">
                                            <label for="password">Password * :</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" name="password" class="form-control" id="password"
                                                    placeholder="Enter password..." aria-label="Password"
                                                    aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i
                                                        class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                            <input type="hidden" id="active_hidden" name="active_hidden" value="true">
                                            <input class="form-check-input" type="checkbox" id="active" name="active"
                                                {{ $user->active == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="role">Role * :</label>
                                            <select class="form-control select2" id="role" name="role"
                                                value="{{ $user->role }}">
                                                <option>Select Role...</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                                </option>
                                                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="access_brand">Access Brand * :</label>
                                            <select class="form-control select2" id="access_brand" name="access_brand[]"
                                                multiple="multiple">
                                                @foreach ($brands as $brand)
                                                    @if (in_array($brand->id, json_decode($user->access_brand)))
                                                        <option value="{{ $brand->id }}" selected>{{ $brand->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
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
    <!-- end row -->

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            function checkActive() {
                var active = '{{ $user->active }}';
                $('#active_hidden').val(active == 1 ? 1 : 0);
            }

            checkActive();
            $('.select2').select2();

            $('#active').change(function() {
                var activeValue = $(this).prop('checked');
                $('#active_hidden').val(activeValue ? 1 : 0);
            });

        });
    </script>

    <script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
