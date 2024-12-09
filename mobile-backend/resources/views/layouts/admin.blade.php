<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bảng điều khiển</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/layoutsite.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-mapael@2.2.0/jquery.mapael.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-mapael@2.2.0/maps/world_countries.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .navbar {
            background-color: #090a0b;
        }

        .navbar a.nav-link {
            color: #ffffff;
        }

        .main-sidebar {
            background-color: #23272b;
        }

        .main-sidebar .nav-link {
            color: #c2c7d0;
        }

        .main-sidebar .nav-link.active {
            background-color: #007bff;
            color: #ffffff;
        }

        .main-sidebar .nav-header {
            color: #ffffff;
        }

        .content-wrapper {
            background-color: #f4f6f9;
        }

        .footer {
            background-color: #343a40;
            color: #ffffff;
        }

        .footer a {
            color: #ffffff;
        }

        .brand-link {
            background-color: #343a40;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="http://localhost/Shopee1/Shopee1/Shopee1/Shopee/public/admin#" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Liên Hệ</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">

                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
                <!-- New Items -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i>
                        <span class="d-none d-md-inline">Hồ sơ</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog"></i> Cài đặt
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-question-circle"></i>
                        <span class="d-none d-md-inline">Hổ trợ</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="darkModeToggle" href="#" role="button">
                        <i class="fas fa-moon"></i>
                        <span class="d-none d-md-inline">Chế độ tối</span>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Quản trị viên</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Phan Thanh Bình</a>
                    </div>
                </div>
                <!-- Tìm kiếm trong Sidebar -->
                <div class="form-inline">
                    <div class="input-group">
                        <input id="sidebar-search" class="form-control form-control-sidebar" type="search"
                            placeholder="Tìm kiếm" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Dashboard Section -->
                        <li class="nav-item menu-open">
                            <a href="{{ route('admin.dashboard.index') }}" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Bảng điều khiển
                                </p>
                            </a>
                        </li>

                        <!-- Products Management -->
                        <li
                            class="nav-item {{ request()->is('admin/product*') ||
                            request()->is('admin/productreview*') ||
                            request()->is('admin/category*') ||
                            request()->is('admin/brand*') ||
                            request()->is('admin/promotion*')
                                ? 'menu-open'
                                : '' }}">
                            <a href="#" class="nav-link">
                                <i class="fas fa-gifts nav-icon"></i>
                                <p>
                                    Quản lý sản phẩm
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.product.index') ? 'active' : '' }}">
                                        <i class="fas fa-box-open nav-icon"></i>
                                        <p>Sản phẩm</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.productreview.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.productreview.index') ? 'active' : '' }}">
                                        <i class="fas fa-star nav-icon"></i>
                                        <p>Đánh giá sản phẩm</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.index') }}"
                                        class="nav-link {{ request()->is('admin/category*') ? 'active' : '' }}">
                                        <i class="fas fa-tasks nav-icon"></i>
                                        <p>Danh mục</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.brand.index') }}"
                                        class="nav-link {{ request()->is('admin/brand*') ? 'active' : '' }}">
                                        <i class="fab fa-shopify nav-icon"></i>
                                        <p>Thương Hiệu</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.promotion.index') }}"
                                        class="nav-link {{ request()->is('admin/promotion*') ? 'active' : '' }}">
                                        <i class="fas fa-gift nav-icon"></i>
                                        <p>Khuyến mãi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Bán hàng -->
                        <li
                            class="nav-item {{ request()->is('admin/order*') || request()->is('admin/shipping*') || request()->is('admin/payment*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Việc bán hàng
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview m">
                                <li class="nav-item">
                                    <a href="{{ route('admin.order.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.oder.index') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-dot-circle"></i>
                                        <p>Đơn hàng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.shipping.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.shipping.index') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-dot-circle"></i>
                                        <p>Vận chuyển</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.payment.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.payment.index') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-dot-circle"></i>
                                        <p>Phương thức thanh toán</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Nội dung -->
                        <li
                            class="nav-item {{ request()->is('admin/banner*') || request()->is('admin/post*') || request()->is('admin/topic*') || request()->is('admin/promotion*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="fas fa-bullhorn nav-icon"></i>
                                <p>
                                    Quản lý nội dung
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview"
                                style="{{ request()->is('admin/banner*') || request()->is('admin/post*') || request()->is('admin/topic*') || request()->is('admin/promotion*') ? 'display: block;' : '' }}">
                                <li class="nav-item">
                                    <a href="{{ route('admin.banner.index') }}"
                                        class="nav-link {{ request()->is('admin/banner*') ? 'active' : '' }}">
                                        <i class="fas fa-image nav-icon"></i>
                                        <p>Banner</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.post.index') }}"
                                        class="nav-link {{ request()->is('admin/post*') ? 'active' : '' }}">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>Bài viết</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.topic.index') }}"
                                        class="nav-link {{ request()->is('admin/topic*') ? 'active' : '' }}">
                                        <i class="fas fa-tags nav-icon"></i>
                                        <p>Chủ đề</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Thành viên -->
                        <li
                            class="nav-item {{ request()->is('admin/user*') || request()->is('admin/roles*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-user"></i>
                                <p>
                                    Thành viên
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview m">
                                <li class="nav-item">
                                    <a href="{{ route('admin.user.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-dot-circle"></i>
                                        <p>Người dùng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-dot-circle"></i>
                                        <p>Vai trò của người dùng</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <!-- Báo cáo -->
                        <li class="nav-item {{ request()->is('admin/report*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Báo cáo
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview m">
                                <li class="nav-item">
                                    <a href="{{ route('admin.report.SalesSummary') }}"
                                        class="nav-link {{ request()->routeIs('admin.report.SalesSummary') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-dot-circle"></i>
                                        <p>Tóm tắt đơn hàng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.report.LowStock') }}"
                                        class="nav-link {{ request()->routeIs('admin.report.LowStock') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-dot-circle"></i>
                                        <p>Còn ít hàng</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- CONTENT -->
            @yield('content')
            <!-- /.CONTENT -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer text-center">
            <strong>Copyright &copy; 2024 <a href="">Phan Thanh Bình</a>.</strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery Mapael -->
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;

            // Kiểm tra nếu chế độ Dark Mode đã được bật từ trước
            if (localStorage.getItem('darkMode') === 'enabled') {
                body.classList.add('dark-mode');
                darkModeToggle.classList.add('dark-mode');
            }

            darkModeToggle.addEventListener('click', () => {
                if (body.classList.contains('dark-mode')) {
                    body.classList.remove('dark-mode');
                    darkModeToggle.classList.remove('dark-mode');
                    localStorage.setItem('darkMode', 'disabled');
                } else {
                    body.classList.add('dark-mode');
                    darkModeToggle.classList.add('dark-mode');
                    localStorage.setItem('darkMode', 'enabled');
                }
            });
        });
    </script>
</body>

</html>
