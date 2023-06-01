<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
//do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<section class="container">
    <div class="row">
    <div class="col-12 col-lg-4 pb-3 pb-lg-4 overflow-scroll-y position-lg-sticky top-0 h-100">
        <?php get_template_part('template-parts/product/thumbnail-gallery'); ?>
        <table class="product-table col-11 mx-auto px-3 mt-3">
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
        <p class="pt-4 text-justify"><?= $product->post->post_excerpt; ?></p>
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
                <div class="form-body">
                    <?php get_template_part('template-parts/payment/part'); ?>
                </div>
                <div class="form_result">

                </div>
            </div>
            <div class="tab-pane fade" id="pills-front-<?= get_the_ID(); ?>" role="tabpanel"
                 aria-labelledby="pills-front-tab-<?= get_the_ID(); ?>" tabindex="1">
                <div class="form-body">
                    <?php get_template_part('template-parts/payment/front'); ?>
                </div>
                <div class="form_result-front">

                </div>
            </div>
        </div>
    </div>
    </div>
<!--    <div class="container-xl">-->
<!--        <div class="mb-2 fs-5">-->
<!--            پیشنهاد شگفت انگیز-->
<!--            <b>33:25:33</b>-->
<!--        </div>-->
<!---->
<!--        <div class="row g-4 mt-5">-->
<!--            <div class="col-12 col-lg-9 row">-->
<!--                <div class="col-lg-6">-->
<!--                    --><?php
//                    /**
//                     * Hook: woocommerce_before_single_product_summary.
//                     *
//                     * @hooked woocommerce_show_product_sale_flash - 10
//                     * @hooked woocommerce_show_product_images - 20
//                     */
//                    do_action('woocommerce_before_single_product_summary');
//                    ?>
<!--                </div>-->
<!---->
<!--                <div class="col-lg-6">-->
<!--                    --><?php
//                    /**
//                     * Hook: woocommerce_single_product_summary.
//                     *
//                     * @hooked woocommerce_template_single_title - 5
//                     * @hooked woocommerce_template_single_rating - 10
//                     * @hooked woocommerce_template_single_price - 10
//                     * @hooked woocommerce_template_single_excerpt - 20
//                     * @hooked woocommerce_template_single_add_to_cart - 30
//                     * @hooked woocommerce_template_single_meta - 40
//                     * @hooked woocommerce_template_single_sharing - 50
//                     * @hooked WC_Structured_Data::generate_product_data() - 60
//                     */
//                    do_action('woocommerce_single_product_summary');
//                    ?>
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-12 col-lg-3">-->
<!--                --><?php //wc_get_template_part( 'content', 'single-sidebar' ); ?>
<!--            </div>-->
<!---->
<!--        </div>-->
<!---->
<!--        --><?php
//        /**
//         * Hook: woocommerce_after_single_product_summary.
//         *
//         * @hooked woocommerce_output_product_data_tabs - 10
//         * @hooked woocommerce_upsell_display - 15
//         * @hooked woocommerce_output_related_products - 20
//         */
//        do_action('woocommerce_after_single_product_summary');
//        ?>
<!--    </div>-->
</section>

<?php //do_action('woocommerce_after_single_product'); ?>
