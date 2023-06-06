<?php get_header();

while (have_posts()) :
    the_post();
    ?>
    <section class="container py-2">
        <div class="row align-items-center pb-4 justify-content-lg-between">
            <div class="col-12 col-lg-7">
                <h1><? the_title(); ?></h1>
            </div>
            <img class="col-12 col-lg-4 rounded-1"
                 src="<?= get_the_post_thumbnail_url(); ?>"
                 alt="<?= the_title(); ?>">
        </div>
        <div class="row justify-content-between">
            <article class="col-12 text-dark text-justify">
                <? the_content(); ?>
            </article>
        </div>

    </section>

<?php endwhile;
wp_reset_query();
get_footer(); ?>