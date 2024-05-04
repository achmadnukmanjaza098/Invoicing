@extends('layouts.master')

@section('title')
    Web Invoicing | Dashboard
@endsection

@section('css')
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
                    <div class="d-flex align-items-center gap-3 flex-wrap justify-content-end">
                        <form id="filter-form" method="POST" action="{{ route('index') }}" class="d-flex flex-wrap gap-3">
                            @csrf
                            <select id="currentMonth" name="currentMonth" class="form-control select2" style="width: 200px" value="{{ $currentMonth }}">
                                <option value="" {{ $currentMonth == '' ? 'selected' : '' }}>All Month</option>
                            </select>

                            <select id="currentYear" name="currentYear" class="form-control select2" style="width: 200px" value="{{ $currentYear }}">
                                <option value="" {{ $currentYear == '' ? 'selected' : '' }}>All Year</option>
                            </select>

                            <button type="submit" class="btn btn-primary" id="apply-filter-button">Apply Filter</button>
                        </form>
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
                                            <p class="text-muted">
                                                @if ($percentageOrder === 0)
                                                    <span class="text-warning me-2"> {{ $percentageOrder }}%
                                                        <i class="mdi mdi-equal"></i>
                                                    </span> dari Bulan {{ ucfirst($labelPreviousMonth) }}
                                                @elseif ($percentageOrder > 0)
                                                    <span class="text-success me-2"> {{ $percentageOrder }}%
                                                        <i class="mdi mdi-arrow-up"></i>
                                                    </span> dari Bulan {{ ucfirst($labelPreviousMonth) }}
                                                @else
                                                    <span class="text-danger me-2"> {{ $percentageOrder }}%
                                                        <i class="mdi mdi-arrow-down"></i>
                                                    </span> dari Bulan {{ ucfirst($labelPreviousMonth) }}
                                                @endif
                                            </p>
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
                                            <p class="text-muted">
                                                @if ($percentageProduct === 0)
                                                    <span class="text-warning me-2"> {{ $percentageProduct }}%
                                                        <i class="mdi mdi-equal"></i>
                                                    </span> dari Bulan {{ ucfirst($labelPreviousMonth) }}
                                                @elseif ($percentageProduct > 0)
                                                    <span class="text-success me-2"> {{ $percentageProduct }}%
                                                        <i class="mdi mdi-arrow-up"></i>
                                                    </span> dari Bulan {{ ucfirst($labelPreviousMonth) }}
                                                @else
                                                    <span class="text-danger me-2"> {{ $percentageProduct }}%
                                                        <i class="mdi mdi-arrow-down"></i>
                                                    </span> dari Bulan {{ ucfirst($labelPreviousMonth) }}
                                                @endif
                                            </p>
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
                                            <p class="text-muted">
                                                @if ($percentageIncome === 0)
                                                    <span class="text-warning me-2"> {{ $percentageIncome }}%
                                                        <i class="mdi mdi-equal"></i>
                                                    </span> dari Bulan {{ ucfirst($labelPreviousMonth) }}
                                                @elseif ($percentageIncome > 0)
                                                    <span class="text-success me-2"> {{ $percentageIncome }}%
                                                        <i class="mdi mdi-arrow-up"></i>
                                                    </span> dari Bulan {{ ucfirst($labelPreviousMonth) }}
                                                @else
                                                    <span class="text-danger me-2"> {{ $percentageIncome }}%
                                                        <i class="mdi mdi-arrow-down"></i>
                                                    </span> dari Bulan {{ ucfirst($labelPreviousMonth) }}
                                                @endif
                                            </p>
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
    <script>
        $(document).ready(function() {
            function populateMonths(selectedMonth) {
                var monthSelect = document.getElementById("currentMonth");
                var months = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];

                months.forEach(function (month, index) {
                    var option = document.createElement("option");
                    option.value = index + 1;
                    option.text = month;

                    if ((selectedMonth !== '') && (Number(selectedMonth) === Number(index + 1))) {
                        option.selected = true;
                    }

                    monthSelect.appendChild(option);
                });
            }

            function populateYears(startYear, endYear, selectedYear) {
                var yearSelect = document.getElementById("currentYear");

                for (var year = startYear; year <= endYear; year++) {
                    var option = document.createElement("option");
                    option.value = year;
                    option.text = year;

                    if ((selectedYear !== '') && (Number(selectedYear) === Number(year))) {
                        option.selected = true;
                    }

                    yearSelect.appendChild(option);
                }

            }

            function initFilter() {
                var selectedMonth = @json($currentMonth);
                var selectedYear = @json($currentYear);
                var currentYear = new Date().getFullYear();
                populateMonths(selectedMonth);
                populateYears(2000, currentYear, selectedYear);
                $('.select2').select2();
            }

            window.onload = initFilter;
        })
    </script>

    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
