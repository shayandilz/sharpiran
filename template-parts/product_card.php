<?php
global $product;

$product_id = get_the_ID();
?>
<div class="p-lg-2 p-1">
    <div class="card text-center product-card rounded-3 p-2 overflow-hidden">
        <div class="ratio ratio-1x1 animate__animated animate__jackInTheBox">
            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail'); ?>
            <img  src="<?php echo $image[0]; ?>"
                 class="card-img-top rounded-3 p-1 p-lg-2 bg-white"
                 alt="<?php the_title(); ?>">
        </div>
        <div class="card-body">
            <h6 class="card-title mb-0 animate__animated animate__slideInUp">
                <!-- Button trigger modal -->
                <?php the_title(); ?>
            </h6>
            <p class="card-text animate__animated animate__slideInUp">
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
            <a data-bs-toggle="modal" data-bs-target="#modal-<?= get_the_ID(); ?>" type="button" href="#"
               class="stretched-link btn btn-addToCard rounded-1">ثبت سفارش</a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal-<?= get_the_ID(); ?>" tabindex="-1"
             aria-labelledby="modal-<?= get_the_ID(); ?>"
             aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-top">
                <div class="modal-content">
                    <div class="modal-header px-4">
                        <p class="fw-bold fs-5 mb-0"> مشخصات محصول</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex-row-reverse d-flex flex-wrap position-relative">
                        <div class="col-12 col-lg-4 pb-3 pb-lg-4 overflow-scroll-y position-lg-sticky top-0 h-100">
                            <?php get_template_part('template-parts/product/thumbnail-gallery') ; ?>
                                <table class="product-table col-11 mx-auto px-3 mt-2 mt-lg-0">
                                    <tbody>
                                    <?php
                                    global $product;

                                    // Get product attributes
                                    $attributes = $product->get_attributes();

                                    foreach ($attributes as $attribute) {
                                        if ($attribute->get_visible()) {
                                            echo '<tr class="row row-cols-2">';
                                            echo '<th class="border py-2">' . $attribute->get_name() . '</th>';
                                            echo '<td class="border py-2">';

                                            if ($attribute->is_taxonomy()) {
                                                // For attributes with taxonomy, get the terms
                                                $attribute_taxonomy = $attribute->get_taxonomy();
                                                $attribute_terms = wp_get_post_terms($product->get_id(), $attribute_taxonomy);

                                                foreach ($attribute_terms as $term) {
                                                    echo $term->name;
                                                }
                                            } else {
                                                // For attributes without taxonomy, get the values
                                                $attribute_values = $attribute->get_options();

                                                foreach ($attribute_values as $value) {
                                                    echo $value;
                                                }
                                            }

                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <p class="pt-3"><?= $product->post->post_excerpt;?></p>
                            </div>
                            <div class="col-12 col-lg-8 p-lg-3 p-1 overflow-scroll-y position-sticky top-0 h-100">
                                <div class="d-flex justify-content-between">
                                    <p class="fs-4 text-center text-lg-start">
                                        <?php the_title(); ?>
                                    </p>
                                    <p class="fs-4">
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
                                <?php if (is_user_logged_in()) { ?>
                                    <ul class="nav nav-pills my-3 justify-content-center justify-content-lg-start mb-lg-3"
                                        id="pills-tab" role="tablist">
                                        <li class="nav-item shadow-sm" role="presentation">
                                            <button class="nav-link active" id="pills-part-tab-<?= get_the_ID(); ?>"
                                                    data-bs-toggle="pill"
                                                    data-bs-target="#pills-part-<?= get_the_ID(); ?>" type="button"
                                                    role="tab"
                                                    aria-controls="pills-part-<?= get_the_ID(); ?>"
                                                    aria-selected="true">
                                                قسطی
                                            </button>
                                        </li>
                                        <li class="nav-item shadow-sm" role="presentation">
                                            <button class="nav-link" id="pills-front-tab-<?= get_the_ID(); ?>"
                                                    data-bs-toggle="pill"
                                                    data-bs-target="#pills-front-<?= get_the_ID(); ?>" type="button"
                                                    role="tab"
                                                    aria-controls="pills-front-<?= get_the_ID(); ?>"
                                                    aria-selected="false">
                                                نقدی
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-part-<?= get_the_ID(); ?>"
                                             role="tabpanel"
                                             aria-labelledby="pills-part-tab-<?= get_the_ID(); ?>" tabindex="0">
                                            <?php get_template_part('template-parts/payment/part'); ?>
                                        </div>
                                        <div class="tab-pane fade" id="pills-front-<?= get_the_ID(); ?>" role="tabpanel"
                                             aria-labelledby="pills-front-tab-<?= get_the_ID(); ?>" tabindex="0">
                                            <!--                                        --><?php //get_template_part('template-parts/payment/front'); ?>
                                        </div>
                                    </div>
                                <?php } else {
                                    echo do_shortcode('[woocommerce_my_account]');
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

