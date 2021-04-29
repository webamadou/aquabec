<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="{{--{{ route('admin.dashboard') }}--}}" class="brand-link">
        <img src="{{ asset('images/logo/logo_white.png') }}" alt="{{ config('app.name') }}" class="brand-image"
            style="opacity: .8">
        <!-- <span class="brand-text font-weight-light">{{ config('app.name') }}</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/avatar5.png') }}" class="img-circle elevation-2" title="{{Auth::user()->username}}" alt="{{Auth::user()->name}}">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->username }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @if(auth()->user()->hasRole('banquier'))
                    <li class="nav-item has-treeview {{ side_nav_bar_menu_status('banker','menu-open') }}">
                        <a href="#" class="nav-link {{ side_nav_bar_menu_status('banker','active') }}">
                            <i class="fa fa-coins nav-icon"></i>
                            <p>
                                Monnaies
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- <li class="nav-item">
                                <a href="{ { route('banker.credit_pack.index') }}" class="nav-link {{ side_nav_bar_menu_status('regions','active')  }}">
                                    <i class="fa fa-list-ul nav-icon"></i>
                                    <p>Packs Crédit</p>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="{{ route('banker.currencies.accounts') }}" class="nav-link {{ side_nav_bar_menu_status('regions','active')  }}">
                                    <i class="fas fa-coins nav-icon"></i> 
                                    <p>Les monnaies</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('banker.currencies.index') }}" class="nav-link {{ side_nav_bar_menu_status('regions','active')  }}">
                                    <i class="fa fa-plus nav-icon"></i>
                                    <p>Ajouter une monnaie</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.credits.logs') }}" class="nav-link {{ side_nav_bar_menu_status('regions','active')  }}">
                                    <i class="fa fa-list nav-icon"></i>
                                    <p>Historique transferts</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(!auth()->user()->hasRole('banker|banquier'))
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ side_nav_bar_menu_status('dashboard','active') }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Tableau de bord
                        </p>
                    </a>
                </li>
                @if(auth()->user()->hasRole('super-admin'))
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ side_nav_bar_menu_status('users','active') }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Utilisateurs
                                <span class="ml-2 badge badge-danger">{{ App\Models\User::count() }}</span>
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('admin.organisations.index') }}" class="nav-link {{ side_nav_bar_menu_status('organisations','active') }}">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            Organisations
                            <span class="ml-2 badge badge-danger">{{ App\Models\Organisation::count() }}</span>
                        </p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="{{ route('admin.subscriptions.index') }}" class="nav-link {{ side_nav_bar_menu_status('subscriptions','active') }}">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Abonnements
                        </p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="{{route('admin.announcements')}}" class="nav-link {{ side_nav_bar_menu_status('announcements','active') }}">
                        <i class="nav-icon fas fa-award"></i>
                        <p>
                            Annonces
                            <span class="ml-2 badge badge-danger">{{ App\Models\Announcement::count() }}</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.listevents')}}" class="nav-link {{ side_nav_bar_menu_status('events','active') }}">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                            Événements
                            <span class="ml-2 badge badge-danger">{{ App\Models\Event::count() }}</span>
                        </p>
                    </a>
                </li>
                <li><hr></li>
                <li class="nav-item">
                    <a href="{{route('admin.credits.logs')}}" class="nav-link {{ side_nav_bar_menu_status('currencies','active') }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Transferts credits logs
                        </p>
                    </a>
                </li>
                <li><hr></li>
                <li class="nav-header text-uppercase">Configurations</li>
                @endif
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
                @if(auth()->user()->hasRole('super-admin'))
                <li><hr></li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.pages.index') }}" class="nav-link {{ side_nav_bar_menu_status('pages','active')  }}">
                        <i class="fa fa-list nav-icon"></i>
                        <p>Pages</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.categories.index') }}" class="nav-link {{ side_nav_bar_menu_status('categories','active')  }}">
                        <i class="fa fa-list nav-icon"></i>
                        <p>Catégories</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="{{ route('admin.settings.caracteristics.index') }}" class="nav-link {{ side_nav_bar_menu_status('caracteristics','active')  }}">
                        <i class="fa fa-list-alt nav-icon"></i>
                        <p>Caractéristiques</p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="{{ route('admin.settings.age_ranges.index') }}" class="nav-link {{ side_nav_bar_menu_status('age_ranges','active')  }}">
                        <i class="fa fa-users-cog nav-icon"></i>
                        <p>Groupes d'age</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
