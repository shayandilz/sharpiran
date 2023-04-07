<!--items-->
<div class="bg-primary bg-opacity-25 p-3 rounded">
    <div class="d-flex flex-column gap-3">
        <?php
        while (have_rows('property', 'option')): the_row(); ?>
            <div class="d-flex align-items-center gap-3 ">
                <img class="bg-primary rounded p-1" src="<?= get_sub_field('property_image', 'option')['url']; ?>"
                     alt="<?= get_sub_field('property_image', 'option')['title']; ?>">
                <div>
                    <h6 class="fw-bold text-dark fs-6"><?= get_sub_field('property_name'); ?></h6>
                    <p class="text-dark opacity-75 mb-0 small"><?= get_sub_field('property_detail'); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<!--banner-->
<div style="background-color : <?= get_field('banner_menu_color', 'option'); ?>;"
     class="position-relative row justify-content-start p-4 pt-5 align-items-center rounded shadow-sm mt-3 mx-1
     mx-lg-0">
    <img class="position-absolute end-0 bottom-0 col-8 p-0 object-fit"
         src="<?= get_field('banner_menu_image', 'option')['url']; ?>"
         alt="<?= get_field('banner_menu_image', 'option')['title']; ?>">
    <div class="col-10 z-top" style="color:<?= get_field('banner_menu_text_color', 'option'); ?>">
        <span style="background-color:<?= get_field('banner_menu_badge_color', 'option'); ?>"
              class="py-1 px-2 rounded"><?= get_field('banner_menu_badge', 'option'); ?></span>
        <h5 class="my-3 fs-3 fw-bolder"><?= get_field('banner_menu_title', 'option'); ?></h5>
        <p style="color:<?= get_field('banner_menu_text_color'); ?>"
        ><?= get_field('banner_menu_content', 'option'); ?></p>
        <a target="_blank" href="<?= get_field('banner_menu_btn_url', 'option')['url']; ?>"
           class="btn bg-white px-4 py-2 fw-bold text-dark mt-3"><?= get_field('banner_menu_btn', 'option'); ?></a>
    </div>
</div>
