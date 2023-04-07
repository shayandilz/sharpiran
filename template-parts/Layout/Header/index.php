<nav class="navbar navbar-light navbar-expand-lg sticky-top mb-1 py-2 border-bottom border-red border-1 shadow-sm">
    <div class="container">
        <a class="navbar-brand me-5" href="/">شارپ ایران</a>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header bg-red text-white">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">شارپ ایران</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav flex-grow-1 pe-3 col">
                    <?php
                    $locations = get_nav_menu_locations();
                    $menu = wp_get_nav_menu_object($locations['headerMenuLocation']);
                    if ($menu) :
                        wp_nav_menu(array(
                            'theme_location' => 'headerMenuLocation',
                            'menu_class' => 'navbar-nav gap-3 desktop-menu',
                            'container' => false,
                            'menu_id' => 'navbarTogglerMenu',
                            'item_class' => 'nav-item',
                            'link_class' => 'lazy text-decoration-none text-red',
                            'depth' => 1,
                        ));
                    endif;
                    ?>
                </ul>
                <div class="d-lg-none fixed-bottom d-flex py-2 bg-red gap-2 justify-content-center">
                    <!--                search icon-->
                    <button class="btn fw-bold fs-4 text-white shadow rounded-circle border-0" type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasBottom"
                            aria-controls="offcanvasBottom">
                        <i class="bi bi-search"></i>
                    </button>
                    <!--                my acount icon-->
                    <a class="btn fw-bold text-white shadow rounded-circle py-1 border-0"
                       href="/my-account/">
                        <i class="bi bi-person fs-3"></i>
                    </a>
                </div>
            </div>

        </div>
        <!--        menu button-->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
            <i class="bi bi-list"></i>
        </button>
        <div class="d-none d-lg-flex align-items-center gap-2">
            <!--                search icon-->
<!--            <a class="fs-5 text-red" type="button"-->
<!--               data-bs-toggle="offcanvas"-->
<!--               data-bs-target="#offcanvasBottom"-->
<!--               aria-controls="offcanvasBottom">-->
<!--                <i class="bi bi-search"></i>-->
<!--            </a>-->
            <!--                my acount icon-->
            <a class="w-bold text-center" href="/my-account/">
                <i class="bi bi-person fs-3"></i>
            </a>
        </div>
    </div>
</nav>
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
     aria-labelledby="offcanvasBottomLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title col text-center fs-4" id="offcanvasBottomLabel">جستجوی محصول</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <form class="search-form"
              method="get"
              action="<?php echo esc_url(home_url('/')); ?>">
            <div class="input-group">
<!--                ---><?//= $args['place'] ?>
                <input id="search-form" type="search" name="s"
                       class="s form-control fs-5"
                       placeholder="جستجو"
                       aria-label="Search">
                <button type="submit" class="bg-red search-submit text-white btn p-3 rounded-start rounded-1">
                    <i class="bi bi-search fs-5 small-sm-down"></i>
                </button>
            </div>
        </form>
    </div>
</div>