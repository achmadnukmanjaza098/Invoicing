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
                                <p>Hallo, Selamat {{ $timeOfDay }} <b>{{ ucfirst(Auth::user()->name) }}</b></p>
                            </div>
                        </div>
                        <div class="col-9 text-sm-end">
                            <img src="{{ asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid"
                                style="height:100px;">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <div>
                        <div class="row">
                            <div class="col-7">
                            </div>
                            <div class="col-3">
                                <select id="month" name="month" class="form-control select2" style="width:250px">
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <select id="year" name="year" class="form-control select2" style="width:120px">
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
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
                                            <h1 style="font-size:26px">{{ $order }}</h1>
                                            <p class="text-muted mb-0 text-truncate"><b>Order</b></p>
                                            <p class="text-muted"><span class="text-success me-2"> 12% <i class="mdi mdi-arrow-up"></i> </span> dari Bulan April</p>
                                            <!--p class="text-muted fw-medium font-size-12">{{ $percentageOrder }}</p-->
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
                                            <h1 style="font-size:26px">{{ $product }}</h1>
                                            <p class="text-muted mb-0 text-truncate"><b>Produk Dikerjakan</b></p>
                                            <p class="text-muted"><span class="text-success me-2"> 50% <i class="mdi mdi-arrow-up"></i> </span> dari Bulan April</p>
                                            <!--p class="text-muted fw-medium font-size-12">{{ $percentageProduct }}</p-->
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
                                            <h1 style="font-size:26px">Rp {{ number_format($income, 2) }}</h1>
                                            <p class="text-muted mb-0 text-truncate"><b>Pendapatan Kotor</b></p>
                                            <p class="text-muted"><span class="text-success me-2"> 70% <i class="mdi mdi-arrow-up"></i> </span> dari Bulan April</p>
                                            <!--p class="text-muted fw-medium font-size-12">{{ $percentageIncome }}</p>-->
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
                                  <div class="mb-4 card-title">Produk Terlaris</div>
                                  <div class="table-responsive mt-4">
                                    <table class="table align-middle table-nowrap">
                                      <tbody>
                                          @foreach ($bestSellerProduct as $key => $item)
                                          <tr>
                                              <td style="width: 30%;">
                                                <p class="mb-0">{{ $item['item'] }}</p>
                                              </td>
                                              <td style="width: 25%;">
                                                <h5 class="mb-0">{{ $item['total_qty'] }}</h5>
                                              </td>
                                              <td>
                                                <div class="bg-transparent progress-sm progress">
                                                  <div class="progress-bar bg-success" style="width: 94%;" role="progressbar" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                              </td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                </div>

                                <!--div class="card-body" style="background-color:#dbebfa">
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
                                </div-->
                            </div>
                            <div class="col-8">
                                <div class="card-body" style="background-color:#dbebfa">
                                    <div style="display: flex; align-items: center;">
                                        <div class="mb-4 card-title">Sales Report</div>
                                    </div>
                                    <table class="table mb-0" style="width: 100%;">
                                        <thead>
                                            <th align="center">#</th>
                                            <th align="center">Name Sales</th>
                                            <th align="center">Jumlah Order</th>
                                            <th align="center">Jumlah Produk</th>
                                            <th align="center">Total Pendapatan</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($salesReport as $key => $item)
                                                <tr>
                                                    <td align="center">{{ $key + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td align="center">{{ $item->total_order }}</td>
                                                    <td align="center">{{ $item->total_qty }}</td>
                                                    <td align="center">Rp {{ number_format($item->total_pendapatan, 2) }}</td>
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
