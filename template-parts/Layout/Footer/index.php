<div class="container">
    <div class="row justify-content-between">
        <!--            aboutUs-->
        <div class="col-lg-5 col-12 ">
           <h5 class="text-white pb-3">درباره ما</h5>
            <p class="text-white text-justify">
                <?= get_field('aboutus-footer', 'option'); ?>
            </p>
        <!--            footer menu-->
            <hr class="text-white">
            <nav>
                <?php
                $locations = get_nav_menu_locations();
                $menu = wp_get_nav_menu_object($locations['footerLocationOne']);
                if ($menu) :
                    wp_nav_menu(array(
                        'theme_location' => 'footerLocationOne',
                        'menu_class' => 'navbar-nav flex-row gap-4',
                        'container' => false,
                        'menu_id' => 'navbarTogglerMenu',
                        'item_class' => 'nav-item',
                        'link_class' => 'lazy text-decoration-none text-white',
                        'depth' => 1,
                    ));
                endif;
                ?></nav>
        </div>
        <!--            contact us form -->
        <div class="col-lg-5 col-12">
            <h5 class="text-white pb-3">تماس با ما</h5>
            <?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]') ?>
        </div>
    </div>
</div>
