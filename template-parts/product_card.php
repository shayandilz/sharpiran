<?php
global $product;
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
            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($loop->post->ID), 'single-post-thumbnail'); ?>
            <img src="<?php echo $image[0]; ?>"
                 class="card-img-top"
                 data-id="<?php echo $loop->post->ID; ?>"
                 alt="cat-1-product-<?= $i ?>">
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
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-<?= get_the_ID(); ?>">
                    <?php the_title(); ?>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                <div class="accordion accordion-flush" id="accordionExample">
                    <?php
                    $field = get_field_object('pay_method');
                    $b = 0;
                    $c = 0;
                    $x = 0;
                    if ($field) {
                        foreach ($field['choices'] as $k => $v) { ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?= $k ?>">
                                    <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse<?= $k ?>"
                                            aria-expanded="false"
                                            aria-controls="collapse<?= $k ?>">
                                        <?php
                                        echo $v;
                                        ?>
                                    </button>
                                </h2>
                                <div id="collapse<?= $k ?>" class="accordion-collapse collapse"
                                     aria-labelledby="heading<?= $k ?>"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form action="" class="add-product" method="post" enctype="multipart/form-data">
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">نام مشتری</label>
                                                    <input disabled value="shayan" required id="name" type="text" name="name" class="name form-control"/>
                                                    <input type="text" value="<?= get_the_ID(); ?>" id="product_id" hidden>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">تلفن</label>
                                                    <input required id="phone" type="tel" name="phone" class="phone form-control"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">آدرس</label>
                                                    <input required id="address" type="text" name="address"
                                                           class="address form-control"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">تعداد</label>
                                                    <input type="number" name="number" required
                                                           class="number form-control"/>
                                                </div>
                                                <div class="col-md-12 mt-3 ">
                                                    <button class="btn btn-primary w-100" type="submit">ارسال</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-secondary">
                    سفارش
                </button>
            </div>
        </div>
    </div>
</div>
