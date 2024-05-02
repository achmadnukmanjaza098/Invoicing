<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('index') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                @if (Auth::user()->role === "admin")
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-store"></i>
                            <span key="t-master">Master Data</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('user') }}" key="t-user">List User</a></li>
                            <li><a href="{{ route('brand') }}" key="t-brand">List Brand</a></li>
                            <li><a href="{{ route('item') }}" key="t-brand">List Item</a></li>
                        </ul>
                    </li>
                @endif

                <li>
                    <a href="{{ route('customer') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-customer">Customer</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('invoice') }}" class="waves-effect">
                        <i class="bx bx-receipt"></i>
                        <span key="t-invoice">Invoice</span>
                    </a>
                </li>

                @if (Auth::user()->role === "admin")
                    <!--
                    <li>
                        <a href="{{ route('monitoring-invoice') }}" class="waves-effect">
                            <i class="bx bx-history"></i>
                            <span key="t-monitoring-invoice">Monitoring Invoice</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('monthly-target') }}" class="waves-effect">
                            <i class="bx bx-money"></i>
                            <span key="t-monthly-target">Master Monthly Target</span>
                        </a>
                    </li>
                    -->
                    <li>
                        <a href="{{ route('report') }}" class="waves-effect">
                            <i class="bx bxs-report"></i>
                            <span key="t-report">Report</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
