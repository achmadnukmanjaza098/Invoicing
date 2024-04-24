@extends('layouts.master')

@section('title') Web Invoicing | Dashboard @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') Dashboard @endslot
    @endcomponent
    
    <div class="row">
        <div class="col-xl-12">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-3">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p>DAMAIJAYA Dashboard</p>
                            </div>
                        </div>
                        <div class="col-9 text-sm-end">
                            <img src="{{ asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid" style="height:100px;">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img src="{{ asset('/assets/images/users/default.jpeg') }}" alt="" class="img-thumbnail rounded-circle">
                            </div>
                            <h5 class="font-size-15 text-truncate">{{ucfirst(Auth::user()->name)}}</h5>
                            <h5 class="font-size-15 text-truncate">Role : {{ucfirst(Auth::user()->role)}}</h5>
                            <p class="text-muted mb-0 text-truncate font-size-11">{{ucfirst(Auth::user()->email)}}</p>
                        </div>

                        <div class="col-sm-9">
                            <div class="pt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body" style="background-color:#dbebfa">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-0 text-truncate"><b>Invoice</b></p>
                                                        <p class="text-muted fw-medium font-size-12">Total ({{ $invoice }})</p>
                                                        <h4 class="mb-0 font-size-16">Rp. {{ number_format($invoicePrice, 2) }}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-cart-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-3">
                        </div>

                        <div class="col-sm-9">
                            <div class="pt-1">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body" style="background-color:#dbebfa">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-0 text-truncate"><b>Invoice</b></p>
                                                        <p class="text-muted fw-medium font-size-12">Belum DP ({{ $invoiceBelumDp }})</p>
                                                        <h4 class="mb-0 font-size-16">Rp. {{ number_format($invoiceBelumDpPrice, 2) }}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-loader-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body" style="background-color:#dbebfa">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-0 text-truncate"><b>Invoice</b></p>
                                                        <p class="text-muted fw-medium font-size-12">Sudah DP ({{ $invoiceSudahDp }})</p>
                                                        <h4 class="mb-0 font-size-16">Rp. {{ number_format($invoiceSudahDpPrice, 2) }}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-calculator font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-3">
                        </div>    
                        <div class="col-sm-9">
                            <div class="pt-1">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body" style="background-color:#dbebfa">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-0 text-truncate"><b>Invoice</b></p>
                                                        <p class="text-muted fw-medium font-size-12">Menunggu Pelunasan ({{ $invoiceMenungguPelunasan }})</p>
                                                        <h4 class="mb-0 font-size-16">Rp. {{ number_format($invoiceMenungguPelunasanPrice, 2) }}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-time font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body" style="background-color:#dbebfa">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-0 text-truncate"><b>Invoice</b></p>
                                                        <p class="text-muted fw-medium font-size-12">Lunas ({{ $invoiceLunas }})</p>
                                                        <h4 class="mb-0 font-size-16">Rp. {{ number_format($invoiceLunasPrice, 2) }}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-dollar font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
