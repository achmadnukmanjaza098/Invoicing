@extends('layouts.master')

@section('title')
    Web Invoicing | Dashboard
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-3">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p>Hallo Selamat {{ $timeOfDay }} {{ ucfirst(Auth::user()->name) }}</p>
                            </div>
                        </div>
                        <div class="col-9 text-sm-end">
                            <img src="{{ asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid"
                                style="height:100px;">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <div class="card mini-stats-wid">
                        <div class="row">
                            <div class="col-4">
                                <div class="card-body" style="background-color:#dbebfa">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-2 font-size-20">{{ $order }}</h4>
                                            <p class="text-muted mb-0 text-truncate"><b>Order</b></p>
                                            <p class="text-muted fw-medium font-size-12">{{ $percentageOrder }}</p>
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
                            <div class="col-4">
                                <div class="card-body" style="background-color:#dbebfa">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-2 font-size-20">{{ $product }}</h4>
                                            <p class="text-muted mb-0 text-truncate"><b>Produk Dikerjakan</b></p>
                                            <p class="text-muted fw-medium font-size-12">{{ $percentageProduct }}</p>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-box font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card-body" style="background-color:#dbebfa">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-2 font-size-20">Rp {{ number_format($income, 2) }}</h4>
                                            <p class="text-muted mb-0 text-truncate"><b>Pendapatan Kotor</b></p>
                                            <p class="text-muted fw-medium font-size-12">{{ $percentageIncome }}</p>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="card mini-stats-wid">
                        <div class="row">
                            <div class="col-4">
                                <div class="card-body" style="background-color:#dbebfa">
                                    <div style="display: flex; align-items: center;">
                                        <p class="text-muted mb-0 text-truncate"><b>Produk Terlaris</b></p>
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary"
                                            style="width: 24px; height: 24px; margin-left: 8px;">
                                            <span class="avatar-title" style="padding: 0;">
                                                <i class="bx bx-check-circle" style="font-size: 16px;"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <br>

                                    <table class="table mb-0" style="width: 100%;">
                                        <thead>
                                            <th>#</th>
                                            <th>Produk</th>
                                            <th>Qty</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($bestSellerProduct as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item['item'] }}</td>
                                                    <td>{{ $item['total_qty'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card-body" style="background-color:#dbebfa">
                                    <div style="display: flex; align-items: center;">
                                        <p class="text-muted mb-0 text-truncate"><b>Produk Terlaris</b></p>
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary"
                                            style="width: 24px; height: 24px; margin-left: 8px;">
                                            <span class="avatar-title" style="padding: 0;">
                                                <i class="bx bx-user-pin" style="font-size: 16px;"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <br>

                                    <table class="table mb-0" style="width: 100%;">
                                        <thead>
                                            <th>#</th>
                                            <th>Name Sales</th>
                                            <th>Jumlah Order</th>
                                            <th>Jumlah Produk</th>
                                            <th>Total Pendapatan</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($salesReport as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->total_order }}</td>
                                                    <td>{{ $item->total_qty }}</td>
                                                    <td>Rp {{ number_format($item->total_pendapatan, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
