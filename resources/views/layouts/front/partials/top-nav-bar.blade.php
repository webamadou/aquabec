<div class="tw-top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-8 text-left">
                <div class="top-contact-info top-bar-link">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-row" id="top-header-links">
                @php 
                    $menus = \App\Models\Menu::where('visible',1)->orderby('position')->get();
                    foreach($menus as $menu){
                        echo '<li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> '.$menu->name.' <span class="icon icon-chevron-down"></span> </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                        if($menu->hasLinks()){
                            foreach($menu->menu_links as $link){
                                echo '<li><a class="dropdown-item" href="'.$link->url.'">'.$link->name.'</a></li>';
                            }
                        }
                        echo '  </ul>
                              </li>';
                    }
                @endphp
                </ul>
                    <!-- <span>
                        <a href="{{ url('/pages/bien-debuter') }}">Bien Débuter</a>
                    </span>
                    <span>
                        <a href="{{ url('/pages/comment') }}">Comment ?</a>
                    </span>
                    <span>
                        <a href="{{ route('contact') }}">Nous Contacter</a>
                    </span> -->
                </div>
            </div>
            <div class="col-md-4 ml-auto text-right">
                <div class="top-contact-info">
                    <span><i class="icon icon-chat"></i>Assistance en Ligne</span>
                </div>
            </div>
        </div>
        <!-- Row End -->
    </div>
    <!-- Container End -->
</div>
<!-- Top Bar end -->
