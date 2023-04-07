<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if (!defined('ABSPATH')) {
    exit;
}

?>

<section class="container" id="breadcrumb">
    <div class="container-xl mb-2">
        <div class="hstack align-items-center justify-content-start align-items-center flex-wrap gap-4 py-3">
<!--            <h1 class="fs-4 smaller-sm-down m-0">-->
<!--                --><?//= woocommerce_page_title() ?>
<!--            </h1>-->

            <?php
            if (!empty($breadcrumb)) {

                echo '<nav aria-label="breadcrumb">
      <ul class="breadcrumb list-unstyled d-flex mb-0">';

                foreach ($breadcrumb as $key => $crumb) {

//                    echo $before;

                    if (!empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
                        echo '<li class="breadcrumb-item"><a class="text-dark mx-2 fw-bold opacity-50" href="' . esc_url
                            ($crumb[1]) . '">' .
                            esc_html
                            ($crumb[0]) . '</a></li>' . '>';
                    } else {
                        echo ' <li class="breadcrumb-item fw-bold active text-primary mx-2" aria-current="page">' .
                            esc_html
                            ($crumb[0]) . '</li>';
                    }

//                    echo $after;

//                    if ( sizeof( $breadcrumb ) !== $key + 1 ) {
//                        echo $delimiter;
//                    }
                }

                echo '  </ul>
</nav>';

            }
            ?>
        </div>
    </div>
</section>