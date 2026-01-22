<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CHICKin</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @vite(['resources/css/style.css', 'resources/js/app.js', 'resources/js/script.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">



        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ asset('images/logo.png') }}" alt="" style="width: 20%;" />
                        <h3 class="mt-1">CHICKin</h3>
                    </div>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>

                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                            <span class="hide-menu">Admin</span>
                        </li>


                        <li class="sidebar-item">
                            <a class="sidebar-link{{ request()->routeIs('dashboard.admin') ? ' active' : '' }}" href="{{ route('dashboard.admin') }}">
                                <span><iconify-icon icon="mdi:view-dashboard" class="fs-6"></iconify-icon></span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link{{ request()->routeIs('admin.menegement.user') ? ' active' : '' }}" href="{{ route('admin.menegement.user') }}">
                                <span><iconify-icon icon="mdi:account-plus" class="fs-6"></iconify-icon></span>
                                <span class="hide-menu">Management Users</span>
                            </a>
                        </li>

                        <li class="sidebar-item ">
                            <a class="sidebar-link{{ request()->routeIs('data.product*') ? ' active' : '' }}" href="{{ route('data.product') }}">
                                <span><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20 7l-8-4-8 4m16 0l-8 4-8-4m16 0v10l-8 4-8-4V7" />
                                    </svg>
                                </span>
                                <span class="hide-menu">Data Product</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a class="sidebar-link{{ request()->routeIs('admin.pesanan.*') ? ' active' : '' }}" href="{{ route('admin.pesanan') }}">
                                <span><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                                    </svg>

                                </span>
                                <span class="hide-menu">Data Penjualan</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a class="sidebar-link{{ request()->routeIs('admin.vouchers.*') ? ' active' : '' }}" href="{{ route('admin.vouchers.index') }}">
                                <span><svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M3 8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4V8z" />
                                    </svg>


                                </span>
                                <span class="hide-menu">Data Voucher</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a class="sidebar-link" href="{{ route('admin.chat') }}">
                                <span> <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 10h8M8 14h5M21 12c0 4.418-4.03 8-9 8a9.98 9.98 0 01-4.39-1.02L3 22v-8c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>

                                </span>

                                <span class="hide-menu">Chat</span>
                                <livewire:chat-notification />
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a class="sidebar-link" href="{{ route('admin.penghasilan') }}">
                                <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-700">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 6A2.25 2.25 0 016 3.75h12A2.25 2.25 0 0120.25 6v1.5H16.5a3 3 0 000 6h3.75V18A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 9H16.5a1.5 1.5 0 000 3h3.75V9z" />
                                    </svg>


                                </span>

                                <span class="hide-menu">Keuangan</span>

                            </a>
                        </li>
                        {{-- <li class="sidebar-item ">
                            <a class="sidebar-link" href="/admin/penghasilan">
                                <span><iconify-icon icon="mdi:currency-usd" class="fs-6"></iconify-icon></span>
                                <span class="hide-menu">Penghasilan</span>
                            </a>
                        </li> --}}





                    </ul>
                </nav>
            </div>
        </aside>

        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="/assets/images/profile/user-1.jpg" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="/logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <main>
                <div class="container py-20" style="padding-top: 80px;">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    @yield('content')

                </div>
            </main>
        </div>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="/assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="/assets/js/sidebarmenu.js"></script>
    <script src="/assets/js/app.min.js"></script>
    <script src="/assets/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</body>

</html>
