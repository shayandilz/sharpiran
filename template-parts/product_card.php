<?php
global $product;

$product_id = get_the_ID();
$new_product_id = $product_id; // Set a new variable for $product_id

// Get the category IDs from the $args array
$category_ids = isset($args['category_ids']) ? $args['category_ids'] : array();

// Convert the category IDs to a comma-separated string
$category_string = implode(',', $category_ids);
?>
<div class="p-lg-2 p-1 product-card " data-categories="<?php echo $category_string; ?>">
    <div class="card text-center rounded-3 p-2 overflow-hidden">
        <div class="ratio ratio-1x1 animate__animated animate__backInDown">
            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail'); ?>
            <img src="<?php echo $image[0]; ?>"
                 class="card-img-top rounded-3 p-1 p-lg-2 bg-white"
                 alt="<?php the_title(); ?>">
        </div>
        <div class="card-body">
            <h6 class="card-title mb-0 animate__animated animate__slideInUp">
                <?php the_title(); ?>
            </h6>
            <p class="card-text animate__animated animate__slideInUp">
                <?php
                if (is_numeric($product->get_price())) :
                    if (!$product->is_type('variable')) {
                        if ($product->get_sale_price() !== null && $product->get_sale_price() !== '') { ?>
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
            <!-- Button trigger modal -->
<!--            <a data-bs-toggle="modal" data-bs-target="#modal---><?//= get_the_ID(); ?><!--" type="button" href="#"-->
<!--               class="stretched-link btn btn-addToCard rounded-1">ثبت سفارش</a>-->
            <a  href="<?php the_permalink(); ?>" class="stretched-link btn btn-addToCard rounded-1">ثبت سفارش</a>
<!--            <a class="position-absolute top-0 start-0 ps-4 pt-4 fs-4" href="--><?php //the_permalink(); ?><!--"><i class="bi bi-info-circle"></i></a>-->
        </div>

    </div>
</div>

