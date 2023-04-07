<?php
global $product;

?>
<div class="card border-0 py-1 px-2">
    <div class="d-block z-top">
        <?php
        $newness_days = 30;
        $created = strtotime($product->get_date_created());
        if ((time() - (60 * 60 * 24 * $newness_days)) < $created) {
            echo '<span class="px-2 pt-1 pb-2 rounded text-white bg-danger">' . esc_html__('جدید', 'woocommerce') .
                '</span>';
        }
        ?>
    </div>
    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->ID), 'single-post-thumbnail');
    if($image) {?>
    <img src="<?php echo $image[0]; ?>"
         alt="<?php the_title(); ?>"
         class=" mx-auto d-block border-0" height="100">

    <?php }
    else { ?>
        <img class="object-fit" height="100" src="<?= get_field('default_image' , 'option')['url'];?>"
             alt="<?= the_title(); ?>">
    <?php  }?>
    <div class="card-body">
        <h6 class="card-title text-dark">
            <a href="<?php the_permalink(); ?>"
               class="stretched-link text-dark fw-bold"><?php the_title(); ?></a>
        </h6>
        <p class="card-text">
            <?php
            if (is_numeric($product->get_price())) :
                if (!$product->is_type('variable')) {
                    if ($product->get_sale_price() == true) { ?>
                        <span class="text-primary text-decoration-line-through me-1">
                    <?php echo number_format($product->get_regular_price()); ?>
                </span> <?php echo number_format($product->get_sale_price());
                    } else {
                        echo number_format($product->get_regular_price());
                    }
                } else {
                    echo number_format($product->get_variation_regular_price([$min_or_max = 'min'][$for_display = false])) .
                        ' تا '
                        . number_format($product->get_variation_regular_price([$min_or_max = 'max'][$for_display = false]));
                }
                ?>

                <span class="text-primary ms-1">تومان</span>
            <?php endif; ?>
        </p>
<!--        --><?php
//        echo apply_filters( 'woocommerce_loop_add_to_cart_link',
//            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="btn btn-primary">%s</a>',
//                esc_url( $product->add_to_cart_url() ),
//                esc_attr( $product->get_id() ),
//                esc_attr( $product->get_sku() ),
//                $product->is_purchasable() ? 'اضافه کردن به سبد خرید' : '',
//                esc_attr( $product->get_type() ),
//                esc_html( $product->add_to_cart_text() )
//            ),
//            $product );
//        ?>
    </div>
</div>