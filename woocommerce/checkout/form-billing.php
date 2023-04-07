<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-billing-fields">
    <?php if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>

        <h3><?php esc_html_e('Billing &amp; Shipping', 'woocommerce'); ?></h3>

    <?php else : ?>

        <h3><?php esc_html_e('Billing details', 'woocommerce'); ?></h3>

    <?php endif; ?>

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div class="woocommerce-billing-fields__field-wrapper row g-4">
        <?php
        $fields = $checkout->get_checkout_fields('billing');

        foreach ($fields as $key => $field) {
//            woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>

            <div class="mb-3 col-sm-6">
                <label class="form-label">
                    <?= $field['label'] ?>
                </label>

                <?php if ($key == 'billing_city') { ?>
                    <select name="billing_city"
                            id="billing_city"
                            class="state_select form-select p-1 rounded"
                            autocomplete="address-level2"
                            placeholder="یک شهر انتخاب کنید"></select>

                <?php } elseif ($key == 'billing_state') { ?>
                    <select name="billing_state"
                            id="billing_state"
                            class="state_select form-select"
                            autocomplete="address-level1"
                            data-placeholder="انتخاب کنید"
                            data-input-classes=""
                            data-label="استان">
                        <option value="">انتخاب کنید</option>
                        <option value="ABZ">البرز</option>
                        <option value="ADL">اردبیل</option>
                        <option value="EAZ">آذربایجان شرقی</option>
                        <option value="WAZ">آذربایجان غربی</option>
                        <option value="BHR">بوشهر</option>
                        <option value="CHB">چهارمحال و بختیاری</option>
                        <option value="FRS">فارس</option>
                        <option value="GIL">گیلان</option>
                        <option value="GLS">گلستان</option>
                        <option value="HDN">همدان</option>
                        <option value="HRZ">هرمزگان</option>
                        <option value="ILM">ایلام</option>
                        <option value="ESF">اصفهان</option>
                        <option value="KRN">کرمان</option>
                        <option value="KRH">کرمانشاه</option>
                        <option value="NKH">خراسان شمالی</option>
                        <option value="RKH">خراسان رضوی</option>
                        <option value="SKH">خراسان جنوبی</option>
                        <option value="KHZ">خوزستان</option>
                        <option value="KBD">کهگیلویه و بویراحمد</option>
                        <option value="KRD">کردستان</option>
                        <option value="LRS">لرستان</option>
                        <option value="MKZ">مرکزی</option>
                        <option value="MZN">مازندران</option>
                        <option value="GZN">قزوین</option>
                        <option value="QHM">قم</option>
                        <option value="SMN">سمنان</option>
                        <option value="SBN">سیستان و بلوچستان</option>
                        <option value="THR">تهران</option>
                        <option value="YZD">یزد</option>
                        <option value="ZJN">زنجان</option>
                    </select>
                <?php } else { ?>
                    <input class="form-control"
                           name="<?= $key ?>"
                           value="<?= $checkout->get_value($key)
                           ?>">
                <?php } ?>
            </div>
        <?php }

        ?>
    </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>
<div class="woocommerce-additional-fields">
    <?php do_action('woocommerce_before_order_notes', $checkout); ?>

    <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>

        <?php if (!WC()->cart->needs_shipping() || wc_ship_to_billing_address_only()) : ?>

            <h3><?php esc_html_e('Additional information', 'woocommerce'); ?></h3>

        <?php endif; ?>

        <div class="woocommerce-additional-fields__field-wrapper">
            <?php foreach ($checkout->get_checkout_fields('order') as $key => $field) : ?>
                <!--                --><?php //woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                <input class="form-control"
                       name="<?= $key ?>"
                       placeholder="<?= $field['placeholder'] ?>"
                       value="<?= $checkout->get_value($key)
                       ?>">
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <?php do_action('woocommerce_after_order_notes', $checkout); ?>
</div>
<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
    <div class="woocommerce-account-fields">
        <?php if (!$checkout->is_registration_required()) : ?>

            <p class="form-row form-row-wide create-account">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                           id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?>
                           type="checkbox"
                           name="createaccount"
                           value="1"/> <span><?php esc_html_e('Create an account?', 'woocommerce'); ?></span>
                </label>
            </p>

        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

        <?php if ($checkout->get_checkout_fields('account')) : ?>

            <div class="create-account">
                <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
                    <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>

        <?php endif; ?>

        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
    </div>
<?php endif; ?>
