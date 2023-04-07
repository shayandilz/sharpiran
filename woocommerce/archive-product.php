<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */

?>

    <!--    {{--  about and order banner  --}}-->
    <section id="archivePage">
        <div class="container-xl">
            <div class="row">
                <!--                {{-- filters sidebar for lg up --}}-->
                <div class="col-lg-3 d-lg-block d-none">
                    <?php
                    get_template_part('template-parts/sidebar')
                    ?>
                </div>

                <div class="col-lg-9 pt-5">
                    <div class="row g-4 row-cols-xl-4 row-cols-lg-3 row-cols-md-4 row-cols-2" id="ajaxFilter">

                        <!--                            <a href="--><?php //the_permalink(); ?><!--">-->
                        <?php if (have_posts()) {
                            while (have_posts()) : the_post(); ?>
                                <div class="col">
                                    <?php wc_get_template_part('content', 'single-card'); ?>
                                </div>
                            <?php endwhile;
                        } else {
                            echo __('هیچ محصولی یافت نشد');
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                    <?php get_template_part('template-parts/pagination') ?>
                </div>
            </div>
        </div>
    </section>
<?php


get_footer( 'shop' );
