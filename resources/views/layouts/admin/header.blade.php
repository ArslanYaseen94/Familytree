<style>
    .sidebar {
        height: 100vh;
        background-color: #343a40;
        color: #fff;
        position: fixed;
        width: 250px;
        padding-top: 1rem;
        overflow-y: auto;
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

    /* Hide sidebar initially on small screens */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 999;
            background: white;
            width: 250px;
        }

        .sidebar.active {
            transform: translateX(0);
        }

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
    }

    /* Base Sidebar Style */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        /* background-color: #fff; */
        border-right: 1px solid #ddd;
        z-index: 999;
        transition: transform 0.3s ease;
    }

    /* Hidden state on large screen */
    .sidebar.hide {
        transform: translateX(-100%);
    }

    /* Overlay */
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

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .overlay.active {
            display: block;
        }
    }

    /* Layout container */
    .layout-wrapper {
        display: flex;
        height: 100vh;
        width: 100%;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #fff;
        border-right: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .sidebar.hide {
        width: 0;
        overflow: hidden;
    }

    /* Main content area */
    .main-content {
        flex: 1;
        transition: all 0.3s ease;
        padding: 20px;
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

    /* Mobile responsive */
    @media (max-width: 768px) {
        .layout-wrapper {
            flex-direction: column;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            transform: translateX(-100%);
            width: 250px;
            height: 100vh;
            z-index: 999;
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main-content {
            padding: 10px;
        }

        .overlay.active {
            display: block;
        }
    }
</style>

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
<div class="overlay" id="sidebarOverlay"></div>
<div class="content">
    <div class="header">
        <div class="header-left">
            <a href="#" class="burger-menu"><i data-feather="menu"></i></a>
        </div>

        <div class="header-right">
            @php
            $locale = Session::get('locale', 'en');
            $language = DB::table('tbl_language')->where('LanguageCode', $locale)->value('LanguageName');
            @endphp
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle"
                    style="background-color: transparent;border-color: gray;color: black;" type="button"
                    id="dropdownLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $language }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownLanguage">
                    @php($languages = \App\Models\Language::where('Status', '0')->get())
                    @foreach ($languages as $language)
                    <a class="dropdown-item"
                        href="{{ route('language.switch', ['language_code' => $language->LanguageCode]) }}">{{ $language->LanguageName }}</a>
                    @endforeach
                </div>
            </div>
            <div class="dropdown dropdown-notification">
                <!--<a href="#" class="dropdown-link new" data-toggle="dropdown"><i data-feather="bell"></i></a>-->
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-menu-header">
                        <h6>Notifications</h6>
                        <a href="#"><i data-feather="more-vertical"></i></a>
                    </div><!-- dropdown-menu-header -->
                    <div class="dropdown-menu-body">
                        <a href="#" class="dropdown-item">
                            <div class="avatar"><span
                                    class="avatar-initial rounded-circle text-primary bg-primary-light">s</span></div>
                            <div class="dropdown-item-body">
                                <p><strong>Socrates Itumay</strong> marked the task as completed.</p>
                                <span>5 hours ago</span>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item">
                            <div class="avatar"><span
                                    class="avatar-initial rounded-circle tx-pink bg-pink-light">r</span></div>
                            <div class="dropdown-item-body">
                                <p><strong>Reynante Labares</strong> marked the task as incomplete.</p>
                                <span>8 hours ago</span>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item">
                            <div class="avatar"><span
                                    class="avatar-initial rounded-circle tx-success bg-success-light">d</span></div>
                            <div class="dropdown-item-body">
                                <p><strong>Dyanne Aceron</strong> responded to your comment on this
                                    <strong>post</strong>.
                                </p>
                                <span>a day ago</span>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item">
                            <div class="avatar"><span
                                    class="avatar-initial rounded-circle tx-indigo bg-indigo-light">k</span></div>
                            <div class="dropdown-item-body">
                                <p><strong>Kirby Avendula</strong> marked the task as incomplete.</p>
                                <span>2 days ago</span>
                            </div>
                        </a>
                    </div><!-- dropdown-menu-body -->
                    <div class="dropdown-menu-footer">
                        <a href="#">View All Notifications</a>
                    </div>
                </div><!-- dropdown-menu -->
            </div>
            <div class="dropdown dropdown-loggeduser">
                <a href="#" class="dropdown-link" data-toggle="dropdown">
                    <div class="avatar avatar-sm">
                        <img src="{{ asset('assets/front-end/images/nextcome_favicone.png') }}"
                            class="rounded-circle" alt="">
                    </div><!-- avatar -->
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-menu-header">
                        <div class="media align-items-center">
                            <div class="avatar">
                                <img src="{{ asset('assets/front-end/images/nextcome_favicone.png') }}"
                                    class="rounded-circle" alt="">
                            </div><!-- avatar -->
                            <div class="media-body mg-l-10">
                                <h6>{{ Auth::guard('admin')->user()->name }}</h6>
                                <span>Administrator</span>
                            </div>
                        </div><!-- media -->
                    </div>
                    <div class="dropdown-menu-body">
                        <a href="{{ route('admin.profile') }}" class="dropdown-item"><i data-feather="user"></i>
                            Profile</a>
                        <a href="{{ route('admin.logout') }}" class="dropdown-item"><i data-feather="log-out"></i>
                            Sign Out</a>
                    </div>
                </div><!-- dropdown-menu -->
            </div>
        </div><!-- header-right -->
    </div>


    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const burger = document.querySelector('.burger-menu');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            burger.addEventListener('click', function(e) {
                e.preventDefault();

                if (window.innerWidth <= 768) {
                    // Mobile
                    sidebar.classList.add('active');
                    overlay.classList.add('active');
                } else {
                    // Desktop
                    sidebar.classList.toggle('hide');
                }
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });

            feather.replace(); // Replace feather icons
        });
    </script>