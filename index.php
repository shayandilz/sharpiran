<?php
/* Template Name: Blog Archive */
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package amaco
 */

get_header(); ?>

<section class="container py-5">
    <div class="row row-cols-1 row-cols-lg-3 justify-content-between g-4">
        <?php
        $j = 0;
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => '-1',
            'ignore_sticky_posts' => true
        );
        $loop = new WP_Query($args);
        if ($loop->have_posts()) : $i = 0;
            /* Start the Loop */
            while ($loop->have_posts()) :
                $loop->the_post();?>
                <article class="all-dark">
                    <a class="d-flex justify-content-between flex-wrap m-1 border border-1 p-3 align-items-center" href="<?php the_permalink();?>">
                        <img class=" col-12 object-fit img-thumbnail" src="<?php echo the_post_thumbnail_url(); ?>"
                             alt="<?php the_title(); ?>" style="height: 200px">
                        <div class=" col-12 pt-2">
                            <div class="ps-2 pt-2 pt-lg-0">
                                <h5 class="fw-bolder"> <?= get_the_title();?></h5>
                                <p><?= wp_trim_words(get_the_content() , 18);?></p>
                            </div>
                        </div>
                    </a>
                </article>
                <?php $j++;
            endwhile;
        endif;
        ?>
    </div>
    <?php
    wp_reset_postdata();?>
</section>
<?php get_footer(); ?>

