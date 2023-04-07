<?php
/**
 * Checkout Order Receipt Template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/order-receipt.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<section>
    <div class="container-xl">
        <div class="row justify-content-center g-0">
            <div class="col-md-auto col-12">
                <ul class="order_details p-0">
                    <li class="fs-6 order">
                        <?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
                        <strong class="mt-2 fs-5 lh-lg"><?php echo esc_html( $order->get_order_number() ); ?></strong>
                    </li>
                    <li class="fs-6 date">
                        <?php esc_html_e( 'Date:', 'woocommerce' ); ?>
                        <strong class="mt-2 fs-5 lh-lg"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong>
                    </li>
                    <li class="fs-6 total">
                        <?php esc_html_e( 'Total:', 'woocommerce' ); ?>
                        <strong class="mt-2 fs-5 lh-lg"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong>
                    </li>
                    <?php if ( $order->get_payment_method_title() ) : ?>
                        <li class="fs-6 method">
                            <?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
                            <strong class="mt-2 fs-5 lh-lg"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                        </li>
                    <?php endif; ?>
                </ul>


                <?php do_action( 'woocommerce_receipt_' . $order->get_payment_method(), $order->get_id() ); ?>
            </div>
        </div>
    </div>
</section>
<div class="clear"></div>
