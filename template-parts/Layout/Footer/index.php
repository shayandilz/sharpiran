<div class="container">
    <div class="row justify-content-lg-between justify-content-center">
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
                        'menu_class' => 'navbar-nav flex-row gap-4 justify-content-center justify-content-lg-start flex-wrap',
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
        <div class="col-lg-6 col-12 mt-5 mt-lg-0 row">
            <h5 class="text-white text-center text-lg-start pb-3">تماس با ما</h5>
            <a class="text-white" href="tel:<?= get_field('phone' , 'option');?>"><i class="bi bi-telephone-fill me-3"></i><?= get_field('phone' , 'option');?></a>
            <a class="text-white" href="mailto:<?= get_field('email' , 'option');?>"><i class="bi bi-envelope-fill me-3"></i><?= get_field('email' , 'option');?></a>
            <p class="text-white"><i class="bi bi-geo-alt-fill me-3"></i><?= get_field('address' , 'option');?></p>

<!--            <form method="post" enctype="multipart/form-data" target="gform_ajax_frame_1" id="gform_1" class="contact-us__form" action="/" novalidate="">-->
<!--                <div class="input-group shadow-sm d-grid d-lg-flex">-->
<!--                    <div class="form-floating" id="field_1_4">-->
<!--                        <input id="input_1_4" type="email" class="form-control bg-red text-white" placeholder="ایمیل" name="input_4"  aria-label="Email" aria-describedby="input_1_label" required>-->
<!--                        <label for="input_1_4" class="text-white">ایمیل</label>-->
<!--                    </div>-->
<!--                    <div class="form-floating" id="field_1_3">-->
<!--                        <input id="input_1_3" type="tel" class="form-control bg-red text-white" placeholder="تلفن تماس" name="input_3"  aria-label="Phone" aria-describedby="input_2_label" required>-->
<!--                        <label for="input_1_3" class="text-white">تلفن تماس</label>-->
<!--                    </div>-->
<!--                <button type="submit" id="gform_submit_button_1" class="w-auto form-control btn text-red bg-white" >ارسال</button>-->
<!--                </div>-->
<!--                <input type="hidden" name="gform_ajax" value="form_id=1&amp;title=&amp;description=&amp;tabindex=0">-->
<!--                <input type="hidden" class="gform_hidden" name="is_submit_1" value="1">-->
<!--                <input type="hidden" class="gform_hidden" name="gform_submit" value="1">-->
<!--                <input type="hidden" class="gform_hidden" name="gform_unique_id" value="">-->
<!--                <input type="hidden" class="gform_hidden" name="state_1" value="WyJbXSIsIjg0NmQwOTNjY2RhYTZhMjQwNzdlYjllODIwNzlkOThlIl0=">-->
<!--                <input type="hidden" class="gform_hidden" name="gform_target_page_number_1" id="gform_target_page_number_1" value="0">-->
<!--                <input type="hidden" class="gform_hidden" name="gform_source_page_number_1" id="gform_source_page_number_1" value="1">-->
<!--                <input type="hidden" name="gform_field_values" value="">-->
<!--            </form>-->
            <!--            --><?php //echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]') ?>

        </div>


    </div>
</div>
</div>
