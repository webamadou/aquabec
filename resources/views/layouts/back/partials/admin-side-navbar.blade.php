<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="{{--{{ route('admin.dashboard') }}--}}" class="brand-link">
        <img src="{{ asset('images/logo/logo_white.png') }}" alt="{{ config('app.name') }}" class="brand-image"
            style="opacity: .8">
{{--        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>--}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @if(auth()->user()->hasRole('super-admin|banker'))
                    <li class="nav-item has-treeview {{ side_nav_bar_menu_status('banker','menu-open') }}">
                        <a href="#" class="nav-link {{ side_nav_bar_menu_status('banker','active') }}">
                            <i class="fa fa-coins nav-icon"></i>
                            <p>
                                Credits
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('banker.credit_pack.index') }}" class="nav-link {{ side_nav_bar_menu_status('regions','active')  }}">
                                    <i class="fa fa-list-ul nav-icon"></i>
                                    <p>Packs Crédit</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('banker.credits.index') }}" class="nav-link {{ side_nav_bar_menu_status('regions','active')  }}">
                                    <i class="fa fa-coins nav-icon"></i>
                                    <p>Crédits</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ side_nav_bar_menu_status('dashboard','active') }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ side_nav_bar_menu_status('users','active') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Utilisateurs
                            @isset($users)
                              @if($users->count() > 0)
                              <span class="ml-2 badge badge-danger">{{ $users->count() }}</span>
                              @endif
                            @endisset
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.organisations.index') }}" class="nav-link {{ side_nav_bar_menu_status('organisations','active') }}">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            Organisations
                            @isset($organisations)
                              @if($organisations->count() > 0)
                              <span class="ml-2 badge badge-danger">{{ $organisations->count() }}</span>
                              @endif
                            @endisset
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.subscriptions.index') }}" class="nav-link {{ side_nav_bar_menu_status('subscriptions','active') }}">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Abonnements
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                            Evènements
                            {{--                            <span class="ml-2 badge badge-danger">{{ App\Models\User::count() }}</span>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-award"></i>
                        <p>
                            Annonces
                            {{--                            <span class="ml-2 badge badge-danger">{{ App\Models\User::count() }}</span>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-header text-uppercase">Configurations</li>
                @if(auth()->user()->hasRole('super-admin'))
                <li class="nav-item has-treeview {{ side_nav_bar_menu_status('security','menu-open') }}">
                    <a href="#" class="nav-link {{ side_nav_bar_menu_status('security','active') }}">
                        <i class="fa fa-shield-virus nav-icon"></i>
                        <p>
                            Sécurité
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.security.roles.index') }}" class="nav-link {{ side_nav_bar_menu_status('roles','active')  }}">
                                <i class="fa fa-user-shield nav-icon"></i>
                                <p>Fonctions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.security.permissions.index') }}" class="nav-link {{ side_nav_bar_menu_status('permissions','active')  }}">
                                <i class="fa fa-user-lock nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.regions.index') }}" class="nav-link {{ side_nav_bar_menu_status('regions','active')  }}">
                        <i class="fa fa-globe-americas nav-icon"></i>
                        <p>Régions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.cities.index') }}" class="nav-link {{ side_nav_bar_menu_status('cities','active')  }}">
                        <i class="fa fa-city nav-icon"></i>
                        <p>Villes</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('admin.settings.categories.index') }}" class="nav-link {{ side_nav_bar_menu_status('categories','active')  }}">
                        <i class="fa fa-list-alt nav-icon"></i>
                        <p>Catégories</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
