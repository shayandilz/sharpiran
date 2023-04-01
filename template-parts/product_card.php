<?php
global $product;

$product_id = get_the_ID();
?>
<div class="card text-center col-3">
    <div class="position-relative">
        <?php if (is_numeric($product->get_price())) : ?>
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
            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail'); ?>
            <img src="<?php echo $image[0]; ?>"
                 class="card-img-top"
                 alt="<?php the_title(); ?>">
        </div>
    </div>


    <div class="card-body">
        <h6 class="card-title">
            <!-- Button trigger modal -->
            <a data-bs-toggle="modal" data-bs-target="#modal-<?= get_the_ID(); ?>" type="button" href="#"
               class="stretched-link btn btn-primary"><?php the_title(); ?></a>
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
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-<?= get_the_ID(); ?>" tabindex="-1" aria-labelledby="modal-<?= get_the_ID(); ?>"
     aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body flex-row-reverse d-flex">
                <div class="col-4">
                    <div class="ratio ratio-1x1">
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail'); ?>
                        <img src="<?php echo $image[0]; ?>"
                             class="card-img-top"
                             alt="<?php the_title(); ?>">
                    </div>
                </div>
                <div class="col-8">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-part-tab-<?= get_the_ID(); ?>" data-bs-toggle="pill"
                                    data-bs-target="#pills-part-<?= get_the_ID(); ?>" type="button" role="tab"
                                    aria-controls="pills-part-<?= get_the_ID(); ?>" aria-selected="true">قسطی
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-front-tab-<?= get_the_ID(); ?>" data-bs-toggle="pill"
                                    data-bs-target="#pills-front-<?= get_the_ID(); ?>" type="button" role="tab"
                                    aria-controls="pills-front-<?= get_the_ID(); ?>" aria-selected="false">نقدی
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <h2>
                            <?php the_title(); ?>
                        </h2>
                        <div class="tab-pane fade show active" id="pills-part-<?= get_the_ID(); ?>" role="tabpanel"
                             aria-labelledby="pills-part-tab-<?= get_the_ID(); ?>" tabindex="0">
                            <?php get_template_part('template-parts/payment/part'); ?>
                        </div>
                        <div class="tab-pane fade" id="pills-front-<?= get_the_ID(); ?>" role="tabpanel"
                             aria-labelledby="pills-front-tab-<?= get_the_ID(); ?>" tabindex="0">
                            <?php get_template_part('template-parts/payment/front'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
