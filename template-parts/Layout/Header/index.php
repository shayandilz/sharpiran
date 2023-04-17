<nav class="sticky__nav navbar navbar-light navbar-expand-lg bg-white start-0 end-0 z-10 mb-1 py-2 border-bottom border-red border-1 anim shadow-sm">
    <div class="container">
        <a class="navbar-brand me-5" href="/">
            <img width="40" height="40" src="<?= get_field('logo', 'option')['url']; ?>"
                 alt="<?= get_field('site-title', 'option'); ?>">
            <?= get_field('site-title', 'option'); ?>
        </a>
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
                </div>
            </div>

        </div>
        <div class="d-flex gap-2">
            <?php
            if (is_user_logged_in()) { ?>
                <div class="btn-group position-relative">
                    <a type="button" class="dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference"
                       data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </a>
                    <a class="fw-bold text-center" href="/my-account/">
                        <i class="bi bi-person-circle fs-3"></i>
                    </a>
                    <ul class="dropdown-menu translate-middle-x" aria-labelledby="dropdownMenuReference">
                        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
                            <li><a class="dropdown-item <?php echo wc_get_account_menu_item_classes($endpoint); ?> "
                                   href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php } else { ?>
                <a type="button" class="fw-bold text-center" data-bs-toggle="modal" data-bs-target="#loginModal"
                   href="#">
                    <i class="bi bi-person-circle fs-3"></i>
                </a>
            <?php }
            ?>
            <!--        menu button-->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar">
                <i class="bi bi-list"></i>
            </button>
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
                <!--                ---><? //= $args['place'] ?>
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
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ورود</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= do_shortcode('[woocommerce_my_account]'); ?>
        </div>
    </div>
</div>