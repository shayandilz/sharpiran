<?php get_header();

while (have_posts()) :
    the_post();
    ?>
    <section class="container py-2">
        <div class="row justify-content-between">
            <article class="col-12 text-dark text-justify">
                <? the_content(); ?>
            </article>
        </div>

    </section>

<?php endwhile;
wp_reset_query();
get_footer(); ?>
