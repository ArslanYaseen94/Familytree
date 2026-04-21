<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/front-end/images/nextcome_favicone.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/back-end/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/back-end/assets/css/cassie.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/back-end/assets/css/cassie.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        .layout-wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar.hide {
            width: 0;
            overflow: hidden;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            font-weight: 500;
            padding: 0.6rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #495057;
            border-radius: 0.375rem;
        }

        .sidebar-heading {
            padding: 0.75rem 1rem 0.25rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #ced4da;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }

        .burger-menu {
            display: inline-block;
            cursor: pointer;
        }

        .overlay {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100%;
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .overlay.active {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }
        }

        /* Layout wrapper */
        .layout-wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
        }

        /* When sidebar is hidden */
        .sidebar.hide {
            transform: translateX(-100%);
        }

        /* Main content shifts right when sidebar is visible */
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* Adjust when sidebar is hidden */
        .sidebar.hide+.main-content {
            margin-left: 0;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 10px;
            }
        }

        /* Layout */
        .layout-wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
        }

        /* Sidebar hidden on large screens */
        .sidebar.hide {
            transform: translateX(-250px);
        }

        /* Main content */
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* When sidebar is hidden on large screens */
        .sidebar.hide~.main-content {
            margin-left: 0;
        }

        /* Overlay for mobile */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        .overlay.active {
            display: block;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">

            <div class="sidebar-content d-flex flex-column">
                <div class="sidebar-heading"> {{ __('messages.Menu') }}</div>
                <ul class="nav flex-column px-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i data-feather="home"></i> {{ __('messages.Dashboard') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.plan') }}"
                            class="nav-link {{ request()->routeIs('admin.plan') ? 'active' : '' }}">
                            <i data-feather="calendar"></i> {{ __('messages.Plan Details') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.user') }}"
                            class="nav-link {{ request()->routeIs('admin.user') ? 'active' : '' }}">
                            <i data-feather="users"></i> {{ __('messages.User Details') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.orders') }}"
                            class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                            <i data-feather="shopping-cart"></i> {{ __('messages.Order Management') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.types') }}"
                            class="nav-link {{ request()->routeIs('admin.types') ? 'active' : '' }}">
                            <i data-feather="shopping-cart"></i> {{ __('messages.Types') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.generations') }}"
                            class="nav-link {{ request()->routeIs('admin.generations') ? 'active' : '' }}">
                            <i data-feather="shopping-cart"></i> {{ __('messages.generations') }}
                        </a>
                    </li>
                </ul>

                <div class="sidebar-heading mt-3"> {{ __('messages.Message Board') }}</div>
                <ul class="nav flex-column px-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.messagesto') }}"
                            class="nav-link {{ request()->is('admin/messages-to') ? 'active' : '' }}">
                            <i data-feather="send"></i> {{ __('messages.Message to Members') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.messagesfrom') }}"
                            class="nav-link {{ request()->is('admin/messages-from') ? 'active' : '' }}">
                            <i data-feather="inbox"></i> {{ __('messages.Message from Members') }}
                        </a>
                    </li>
                </ul>

                <div class="sidebar-heading mt-3"> {{ __('messages.Templates') }}</div>
                <ul class="nav flex-column px-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.templates') }}"
                            class="nav-link {{ request()->routeIs('admin.templates') ? 'active' : '' }}">
                            <i data-feather="file-text"></i> {{ __('messages.Templates') }}
                        </a>
                    </li>
                </ul>

                <div class="sidebar-heading mt-3"> {{ __('messages.Configuration') }}</div>
                <ul class="nav flex-column px-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.general') }}"
                            class="nav-link {{ request()->routeIs('admin.general') ? 'active' : '' }}">
                            <i data-feather="settings"></i> {{ __('messages.General') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.security') }}"
                            class="nav-link {{ request()->is('admin/security*') ? 'active' : '' }}">
                            <i data-feather="shield"></i> {{ __('messages.Security') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.payments') }}"
                            class="nav-link {{ request()->is('admin/payments-gateway*') ? 'active' : '' }}">
                            <i data-feather="credit-card"></i> {{ __('messages.Payment Gateway') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.socialmedia') }}"
                            class="nav-link {{ request()->is('admin/social-media*') ? 'active' : '' }}">
                            <i data-feather="share-2"></i> {{ __('messages.Social Media') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.memberships') }}"
                            class="nav-link {{ request()->is('admin/membership-plans*') ? 'active' : '' }}">
                            <i data-feather="user-check"></i> {{ __('messages.Membership Plan') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.recaptcha') }}"
                            class="nav-link {{ request()->is('admin/recaptcha*') ? 'active' : '' }}">
                            <i data-feather="shield-off"></i> {{ __('messages.Recaptcha') }}
                        </a>
                    </li>
                </ul>

                <div class="sidebar-heading mt-3"> {{ __('messages.System Setup') }}</div>
                <ul class="nav flex-column px-2 mb-4">
                    <li class="nav-item">
                        <a href="{{ route('admin.language') }}"
                            class="nav-link {{ request()->is('admin/language*') ? 'active' : '' }}">
                            <i data-feather="globe"></i> {{ __('messages.Language') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Overlay for small screens -->
        <div class="overlay" id="sidebarOverlay"></div>

        <!-- Main content -->
        <div class="main-content">
            <div class="header">
                <div class="header-left">
                    <a href="#" class="burger-menu"><i data-feather="menu"></i></a>
                </div>
                <div class="header-right d-flex align-items-center">
                    <div class="me-3">
                        @php
                        $locale = Session::get('locale', 'en');
                        $language = DB::table('tbl_language')->where('LanguageCode', $locale)->value('LanguageName');
                        @endphp
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownLanguage" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $language }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownLanguage">
                                @php($languages = \App\Models\Language::where('Status', '0')->get())
                                @foreach ($languages as $lang)
                                <li><a class="dropdown-item" href="{{ route('language.switch', ['language_code' => $lang->LanguageCode]) }}">{{ $lang->LanguageName }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="{{ asset('assets/front-end/images/nextcome_favicone.png') }}" width="32" class="rounded-circle" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header">
                                <strong>{{ Auth::guard('admin')->user()->name }}</strong><br />
                                <small>Administrator</small>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i data-feather="user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.logout') }}"><i data-feather="log-out"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Yield Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
         <script src="{{ asset('assets/back-end/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/back-end/js/svg-inline.js') }}"></script>
    <script src="{{ asset('assets/back-end/assets/js/cassie.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/prismjs/prism.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/select2/js/select2.min.js') }}"></script>
    <script>
        document.querySelectorAll('.language-option').forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault();
                const selectedLanguage = event.currentTarget.innerHTML;
                document.querySelector('.current-language').innerHTML = selectedLanguage;

                // Add your code to handle the language change
            });
        });
    </script>
    <!-- Page-specific scripts -->
    @stack('script')
    @yield('scripts')
    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @if (session('success'))
    <script>
        toastr.success("{{ session('success') }}", 'Success', {
            timeOut: 5000
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        toastr.error("{{ session('error') }}", 'Error', {
            timeOut: 5000
        });
    </script>
    @endif
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const burger = document.querySelector('.burger-menu');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            burger.addEventListener('click', function(e) {
                e.preventDefault();
                if (window.innerWidth <= 768) {
                    // Mobile: overlay behavior
                    sidebar.classList.add('active');
                    overlay.classList.add('active');
                } else {
                    // Desktop: toggle sidebar
                    sidebar.classList.toggle('hide');
                }
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });

            feather.replace();
        });
    </script>


    @if (session('success'))
    <script>
        toastr.success("{{ session('success') }}", 'Success', {
            timeOut: 5000
        });
    </script>
    @endif
    @if (session('error'))
    <script>
        toastr.error("{{ session('error') }}", 'Error', {
            timeOut: 5000
        });
    </script>
    @endif

    @stack('script')
    @yield('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

</html>