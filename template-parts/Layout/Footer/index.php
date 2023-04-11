<div class="container">
    <div class="row justify-content-between">
        <!--            aboutUs-->
        <div class="col-lg-5 col-12 ">
           <h5 class="text-white pb-3 text-center text-lg-start">درباره ما</h5>
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
                        'menu_class' => 'navbar-nav flex-row gap-4 justify-content-center justify-content-lg-start',
                        'container' => false,
                        'menu_id' => 'navbarToggler Menu',
                        'item_class' => 'nav-item',
                        'link_class' => 'lazy text-decoration-none text-white',
                        'depth' => 1,
                    ));
                endif;
                ?></nav>
        </div>
        <!--            contact us form -->
        <div class="col-lg-6 col-12 mt-5 mt-lg-0">
            <h5 class="text-white text-center text-lg-start pb-3 pb-lg-5">تماس با ما</h5>
            <div class="input-group shadow-sm contact-us__form">
                <div class="form-floating">
                    <input class="form-control bg-red text-white" placeholder="ایمیل" id="floatingEmail" type="email">
                    <label class="text-white" for="floatingEmail">ایمیل</label>
                </div>
                <div class="form-floating">
                    <input class="form-control bg-red text-white" placeholder="تلفن تماس" id="floatingPhone" type="tel">
                    <label class="text-white" for="floatingPhone">تلن تماس</label>
                </div>
                <button type="button" class="form-control" aria-label="Example text with two button addons">ارسال</button>
            </div>
            </div>
<!--            --><?php //echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]') ?>
        </div>
    </div>
</div>
