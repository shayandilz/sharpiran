<?php get_header();

while (have_posts()) :
    the_post();
    ?>
    <section class="container pt-2 pb-5">
        <div class="row mx-0 align-items-start py-4 bg-red text-white px-lg-4 my-4 rounded-1 justify-content-lg-between justify-content-center gap-lg-4">
            <img class="col-11 col-lg-4 img-fluid p-0 rounded-1"
                 src="<?= get_the_post_thumbnail_url(); ?>"
                 alt="<?= the_title(); ?>">
            <div class="col-11 col-lg pt-5">
                <h1 class="text-lg-start text-center"><? the_title(); ?></h1>
                <p class="pe-lg-5 pt-4 text-justify"><span class="fs-4">❞ </span><?php echo get_the_excerpt();?> <span class="fs-4">❝</span></p>
            </div>
        </div>
        <div class="row justify-content-center">
            <article class="col-11 col-lg-12 text-dark text-justify">
                <? the_content(); ?>
            </article>
        </div>

    </section>

<?php endwhile;
wp_reset_query();
get_footer(); ?>
