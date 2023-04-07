<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

    <?php do_action('woocommerce_before_add_to_cart_form'); ?>

    <form class="cart"
          action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
          method="post" enctype='multipart/form-data'>


        <div class="row g-4 align-items-center flex-sm-nowrap">
            <div class="col-sm-auto col-4">
                <div id="quantity-input-box" data-min="<?= $product->get_min_purchase_quantity() ?>"
                     data-max="<?= $product->get_max_purchase_quantity() ?>">
                    <div class="hstack gap-4">
                        <div class="gap-2 d-flex justify-content-evenly align-items-center">
                            <button type="button" class="btn px-1 text-dark py-0 lh-1 bg-info fw-bold btn-icon fs-3"
                                    id="decrease-product-btn">
                                <i class="bi bi-dash"></i>
                            </button>
                            <span id="product-count" class="fs-5 text-center px-2">
                                     <?= isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity() ?>
                            </span>
                            <button type="button" class="btn px-1 text-dark py-0 lh-1 bg-info fw-bold btn-icon fs-3"
                                    id="increase-product-btn">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <input id="product-quantity" type="hidden" name="quantity"
                               value="<?= isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity() ?>">
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-sm col-8">


                <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
                        class="btn bg-danger rounded text-white w-100 fs-5 fw-bold py-2 single_add_to_cart_button">
                    <?php echo esc_html($product->single_add_to_cart_text()); ?>
                </button>
                <?php do_action('woocommerce_after_add_to_cart_button'); ?>
            </div>

            <!--            <div class="col-sm-auto col-12 text-lg-end text-center ms-auto mb-3">-->
            <!--                <p class="m-0">-->
            <!--                    <span class="fw-bold fs-3">-->
            <!--                        --><? //= number_format($product->get_price()) ?>
            <!--                    </span>-->
            <!--                    <span class="small ms-1">-->
            <!--                        --><? //= get_woocommerce_currency_symbol() ?>
            <!--                    </span>-->
            <!--                </p>-->
            <!---->
            <!--                <p class="fs-5 m-0">-->
            <!--                    <span class="text-decoration-line-through me-2">-->
            <!--                        --><?php
            //                        $regular_price = (float)$product->get_regular_price(); // Regular price
            //                        $sale_price = (float)$product->get_price(); // Active price (the "Sale price" when on-sale)
            //                        ?>
            <!--                        --><? //= number_format($product->get_regular_price()) ?>
            <!--                    </span>-->
            <!--                    <span class="badge bg-secondary text-dark fs-5">-->
            <!--                        %-->
            <!--                        --><? //= $saving_percentage = round(100 - ($sale_price / $regular_price * 100), 1) ?>
            <!--                    </span>-->
            <!--                </p>-->
            <!--            </div>-->

        </div>
    </form>


    <?php do_action('woocommerce_after_add_to_cart_form'); ?>
    <!--    <div class="hstack gap-4 mt-4 flex-wrap">-->
    <!--        --><?php //echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
    <!--        {{-- <a href="#">--}}-->
    <!--            {{-- <i class="bi bi-arrow-down-up fw-bold me-1"></i>--}}-->
    <!--            {{-- افزودن به لیست مقایسه--}}-->
    <!--            {{-- </a>--}}-->

    <!--        <a href="#">-->
    <!--            <i class="bi bi-info-circle fw-bold me-1"></i>-->
    <!--            راهنمای اندازه-->
    <!--        </a>-->
    <!--    </div>-->
<?php endif; ?>
