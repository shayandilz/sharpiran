<?php
global $product;
$term_ids = wp_get_post_terms($product->get_id(), 'brand');
?>
<div class="card text-center">
    <?php if (!empty($term_ids)) : ?>
        <?php foreach ($term_ids as $key => $term) : ?>
            <a href="<?= get_term_link($term); ?>" class="badge fw-normal bg-secondary text-dark position-absolute top-0 start-0 z-index-10"><?php echo
                $term->name;
                ?>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="position-relative">
        <?php if(is_numeric($product->get_price())) : ?>
            <?php if (!$product->is_type('variable')) {
                $regular_price = (float)$product->get_regular_price(); // Regular price
                $sale_price = (float)$product->get_price(); // Active price (the "Sale price" when on-sale)
                ?>
                <span class="badge bg-primary position-absolute end-0 bottom-0 z-index-10">%
                <?= $saving_percentage = ceil(round(100 - ($sale_price / $regular_price * 100), 1)) ?>
            </span>
            <?php } ?>
        <?php endif; ?>
        <div class="ratio ratio-1x1">
            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($loop->post->ID), 'single-post-thumbnail'); ?>
            <img src="<?php echo $image[0]; ?>"
                 class="card-img-top"
                 data-id="<?php echo $loop->post->ID; ?>"
                 alt="cat-1-product-<?= $i ?>">
        </div>
    </div>


    <div class="card-body">
        <h6 class="card-title">
            <a href="<?php the_permalink(); ?>"
               class="stretched-link"><?php the_title(); ?></a>
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
            <?php  endif; ?>
        </p>
    </div>
</div>
