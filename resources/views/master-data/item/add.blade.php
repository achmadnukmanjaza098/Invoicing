@extends('layouts.master')

@section('title')
    Web Invoicing | Item
@endsection

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Item @endslot
        @slot('li_2')
            <button
                type="button"
                class="btn btn-danger waves-effect btn-label waves-light"
                onclick="window.location='{{ route('item') }}'"
            >
                <i class="bx bx-arrow-back label-icon me-1"></i>
                Back
            </button>
        @endslot
        @slot('title') Item Form @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if(session()->has('success'))
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
                    <form method="post" action="{{ route('storeItem') }}" enctype="multipart/form-data">
                    @csrf
                        <div data-repeater-list="outer-group" class="outer">
                            <div data-repeater-item class="outer">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="brand_id">Brand * :</label>
                                            <select class="form-control select2" id="brand_id" name="brand_id">
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="code">Code * :</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="code"
                                                name="code"
                                                placeholder="Enter Code..."
                                            >
                                        </div>
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
                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                            <input type="hidden" id="active_hidden" name="active_hidden" value="true">
                                            <input class="form-check-input" type="checkbox" id="active" name="active" checked>
                                            <label class="form-check-label" for="active">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="size">Size * :</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="size"
                                                name="size"
                                                placeholder="Enter Size..."
                                            >
                                        </div>
                                        <div class="mb-3">
                                            <label for="qty">Qty * :</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="qty"
                                                name="qty"
                                                placeholder="Enter Qty..."
                                            >
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
                $('#active_hidden').val(1);
            }

            checkActive()

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
