<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

//do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}

?>

<form name="checkout"
      method="post"
      class="container-xl checkout woocommerce-checkout"
      action="<?php echo esc_url(
          wc_get_checkout_url()); ?>"
      enctype="multipart/form-data">

    <?php if ($checkout->get_checkout_fields()) : ?>

        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

        <div class="row g-4 justify-content-center"
             id="customer_details">
            <div class="col-lg">
                <div class="py-2">
                    <div class="mb-5">
                        <?php do_action('woocommerce_checkout_billing'); ?>
                    </div>
                    <div class="vstack gap-4">
                        <?php
                        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) { ?>
                            <div class="card">
                                <div class="row align-items-center g-4 justify-content-lg-evenly
                                justify-content-center">
                                    <?php
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                        ?>
                                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                                            <div class="col-10 col-lg-4 hstack gap-lg-4 flex-nowrap align-items-center justify-content-center">
                                                <td>
                                                    <?php
                                                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                                    if (!$product_permalink) {
                                                        echo $thumbnail; // PHPCS: XSS ok.
                                                    } else {
                                                        printf('<a class="p-4 product-thumbnail " href="%s">%s</a>',
                                                            esc_url($product_permalink),
                                                            $thumbnail); // PHPCS: XSS ok.
                                                    }
                                                    ?>
                                                </td>

                                                <td class="product-name me-auto"
                                                    data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                                    <?php
                                                    if (!$product_permalink) {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                                    } else {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name',
                                                            sprintf('<a class="fs-3 m-0 small-sm-down" href="%s">%s</a>', esc_url
                                                            ($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                                    }

                                                    do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                                    // Meta data.
                                                    echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                                    // Backorder notification.
                                                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                                    }
                                                    ?>
                                                </td>
                                            </div>

                                            <div class="col-10 col-lg-4">
                                                <div class="row g-4 justify-content-lg-between justify-content-center flex-wrap py-2 py-lg-0">
                                                    <div class="col">
                                                        <td class="product-quantity"
                                                            data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                                            <?php
                                                            if ($_product->is_sold_individually()) {
                                                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                                            } else {
                                                                $product_quantity = woocommerce_quantity_input(
                                                                    array(
                                                                        'input_name' => "cart[{$cart_item_key}][qty]",
                                                                        'input_value' => $cart_item['quantity'],
                                                                        'max_value' => $_product->get_max_purchase_quantity(),
                                                                        'min_value' => '0',
                                                                        'product_name' => $_product->get_name(),
                                                                    ),
                                                                    $_product,
                                                                    false
                                                                );
                                                            }

                                                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                                            ?>
                                                        </td>
                                                    </div>
                                                    <div class="col d-flex align-items-center text-end">
                                                        <div class=" m-0 text-nowrap">
                                                            <td class="product-price"
                                                                data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                                                <?php
                                                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                                                ?>
                                                            </td>
                                                        </div>
                                                        <div>
                                                            <td class="product-remove ">
                                                                <?php
                                                                echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                                    'woocommerce_cart_item_remove_link',
                                                                    sprintf(
                                                                        '<a href="%s" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="bi bi-trash fs-5"></i></a>',
                                                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                                        esc_html__('Remove this item', 'woocommerce'),
                                                                        esc_attr($product_id),
                                                                        esc_attr($_product->get_sku())
                                                                    ),
                                                                    $cart_item_key
                                                                );
                                                                ?>
                                                            </td>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-8">
                <div id="order_review"
                     class="woocommerce-checkout-review-order mb-5 card bg-white">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>
            </div>
        </div>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>

    <?php endif; ?>

    <?php do_action('woocommerce_checkout_after_order_review'); ?>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
