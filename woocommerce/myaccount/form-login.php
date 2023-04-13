<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>

<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

<div class="u-columns col2-set" id="customer_login">

    <div class="u-column1 col-1">

        <?php endif; ?>
        <div class="container px-0">
            <div class="row justify-content-center">
                <div class="<?= !is_front_page() ? 'col-lg-6': '';?> col-12">
                    <ul class="nav nav-pills my-3 justify-content-center mb-lg-3" id="myTab" role="tablist">
                        <li class="nav-item shadow-sm" role="presentation">
                            <button class="nav-link nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true">
                                ورود
                            </button>
                        </li>
                        <li class="nav-item shadow-sm" role="presentation">
                            <button class="nav-link nav-link" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">
                                عضویت
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content pt-4 border" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="">
                                <h2 class="text-center"><?php esc_html_e('Login', 'woocommerce'); ?></h2>

                                <form class="woocommerce-form woocommerce-form-login login rounded border-0" method="post">

                                    <?php do_action('woocommerce_login_form_start'); ?>

                                    <p class="input-group woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide rounded-3">
                                        <label class="input-group-text bg-red text-white col-12 col-lg-4" for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>
                                            &nbsp;<span
                                                    class="required">*</span></label>
                                        <input type="text" class="form-control woocommerce-Input woocommerce-Input--text col-12 col-lg-8"
                                               name="username"
                                               id="username" autocomplete="username"
                                               value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                                    </p>
                                    <p class="input-group  woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                        <label class="input-group-text bg-red text-white col-12 col-lg-4" for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span
                                                    class="required">*</span></label>
                                        <input class="woocommerce-Input form-control woocommerce-Input--text col-12 col-lg-8" type="password"
                                               name="password"
                                               id="password" autocomplete="current-password"/>
                                    </p>

                                    <?php do_action('woocommerce_login_form'); ?>

                                    <p class="form-row">
                                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                                            <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                                                   name="rememberme"
                                                   type="checkbox" id="rememberme" value="forever"/>
                                            <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                                        </label>
                                        <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                                        <button type="submit"
                                                class="btn bg-red text-white woocommerce-button button rounded woocommerce-form-login__submit<?php echo
                                                esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
                                                name="login"
                                                value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
                                    </p>
                                    <p class="woocommerce-LostPassword lost_password">
                                        <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
                                    </p>

                                    <?php do_action('woocommerce_login_form_end'); ?>

                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="">

                                <h2 class="text-center"><?php esc_html_e('Register', 'woocommerce'); ?></h2>

                                <form method="post"
                                      class="woocommerce-form woocommerce-form-register register border-0" <?php do_action('woocommerce_register_form_tag'); ?> >

                                    <?php do_action('woocommerce_register_form_start'); ?>

                                    <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide input-group">
                                            <label class="input-group-text bg-red text-white col-12 col-lg-4"" for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?>
                                                &nbsp;<span
                                                        class="required">*</span></label>
                                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control col-12 col-lg-8"
                                                   name="username" id="reg_username" autocomplete="username"
                                                   value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                                        </p>

                                    <?php endif; ?>

                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide input-group flex-lg-nowrap">
                                        <label class="input-group-text bg-red text-white col-12 col-lg-4" for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?>
                                            &nbsp;<span
                                                    class="required">*</span></label>
                                        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control col-12 col-lg-8"
                                               name="email"
                                               id="reg_email" autocomplete="email"
                                               value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                                    </p>

                                    <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                            <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?>
                                                &nbsp;<span
                                                        class="required">*</span></label>
                                            <input type="password"
                                                   class="woocommerce-Input woocommerce-Input--text input-text"
                                                   name="password" id="reg_password" autocomplete="new-password"/>
                                        </p>

                                    <?php else : ?>

                                        <p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>

                                    <?php endif; ?>

                                    <?php do_action('woocommerce_register_form'); ?>

                                    <p class="woocommerce-form-row form-row">
                                        <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                                        <button type="submit"
                                                class="woocommerce-Button btn bg-red text-white woocommerce-button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> woocommerce-form-register__submit"
                                                name="register"
                                                value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
                                    </p>

                                    <?php do_action('woocommerce_register_form_end'); ?>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

    </div>
</div>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>
