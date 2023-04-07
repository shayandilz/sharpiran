<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if (!defined('ABSPATH')) {
    exit;
}
global $product;
/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)) : $index = 0 ?>

    <div class="my-5 border rounded p-lg-4">
        <div class="row">
            <div class="col-12">
                <ul class="nav col-lg-5 nav-tabs border-0 bg-info justify-content-center
                justify-content-lg-start mb-4 rounded" id="myTab" role="tablist">

                    <?php foreach ($product_tabs as $key => $product_tab) : ?>
                        <li class="nav-item p-3 rounded" role="presentation">
                            <button class="tab-shop text-secondary border-0 p-3 lh-1 rounded fs-5
                            small-sm-down fw-bold lazy <?= $index == 0 ? 'active' : '' ?>"
                                    id="cat-<?php echo esc_attr($key); ?>-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#cat-<?php echo esc_attr($key); ?>"
                                    type="button"
                                    role="tab"
                                    aria-controls="cat-<?php echo esc_attr($key); ?>"
                                    aria-selected="true">
                                <?= $product_tab['title'] ?>
                            </button>
                        </li>
                        <?php $index++;
                    endforeach; ?>
                </ul>
                <?php $index = 0 ?>

                <div class="tab-content px-3" id="myTabContent">
                    <?php foreach ($product_tabs as $key => $product_tab) : ?>
                        <div class="tab-pane fade <?= $index == 0 ? 'show active' : '' ?>"
                             id="cat-<?php echo esc_attr($key); ?>"
                             role="tabpanel"
                             aria-labelledby="cat-<?php echo esc_attr($key); ?>-tab">
                            <?php
                            if (isset($product_tab['callback'])) {
                                call_user_func($product_tab['callback'], $key, $product_tab);
                            }
                            ?>
                        </div>
                        <?php $index++;
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4 border-top border-bottom">
        <div class="hstack justify-content-center gap-md-5 gap-3">
            <p class="m-0">
                <?php do_action('woocommerce_product_meta_start'); ?>
                <?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>

                    <span class="sku_wrapper fw-bold me-1"><?php esc_html_e('SKU:', 'woocommerce'); ?></span>
                    <span class="sku"><?php
                        echo ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span>

                <?php endif; ?>
                <?php do_action('woocommerce_product_meta_end'); ?>
            </p>

        </div>
    </div>

<?php endif; ?>
