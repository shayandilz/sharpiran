<?php
global $product;
$attachment_ids = $product->get_gallery_image_ids();
$image_urls = array();
$image_id = $product->get_image_id();
if ($image_id) {
    $image_url = wp_get_attachment_image_url($image_id, 'full');

    $image_urls[0] = $image_url;
}

foreach ($attachment_ids as $attachment_id) {
    $image_urls[] = wp_get_attachment_url($attachment_id);
}
?>
<div class="swiper product-gallery">
    <div class="swiper-wrapper">
        <?php
        foreach ($image_urls as $image_src_url) { ?>
            <div class="swiper-slide">
                <div class="img-fluid">
                    <img src="<?= $image_src_url ?>">
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="swiper-pagination"></div>
</div>