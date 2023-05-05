<?php
/* Template Name: Blog Archive */
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package amaco
 */

get_header();
?>
    <section class="container py-5">
        <?php the_content();?>
    </section>


<?php
get_footer();

