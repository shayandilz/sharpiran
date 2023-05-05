<?php get_header();
// Modify search query to only search for products
$search_query = new WP_Query(array(
    'post_type' => 'product',
    's' => get_search_query()
));
?>
<div class="container py-5">
    <div class="w-100 mb-5 mx-auto">
        <form class="w-100 pb-3"
              method="get"
              action="<?php echo esc_url(home_url('/')); ?>">
            <div class="input-group">
                <input id="search-form" type="search" name="s" class="s form-control pe-4 bg-light"
                       placeholder="جستجو"
                       aria-label="Search">
                <button type="submit" class=" bg-red search-submit text-white btn px-3">
                    <i class="bi bi-search fs-5 small-sm-down"></i>
                </button>
            </div>
        </form>
        <div class="d-block d-lg-flex align-items-center">
            نتیجه جستجو برای :
            <h1 class="fw-bold ms-3"> <?= the_search_query(); ?> </h1>
        </div>

    </div>
    <?php
    if (have_posts()) { ?>
        <div class="row my-2 row-cols-lg-3 justify-content-lg-between row-cols-1">
            <?php while (have_posts()) {
                the_post();
                get_template_part('template-parts/product_card');
            } ?>
        </div>
        <?php
        $links = paginate_links(array(
            'type' => 'array',
            'prev_next' => true,

        ));
        if ($links) : ?>
            <nav aria-label="age navigation example">
                <?php echo '<ul class="pagination justify-content-center align-items-center gap-3">';
                // get_previous_posts_link will return a string or void if no link is set.
                if ($prev_posts_link = get_previous_posts_link(__('قبلی'))) :
                    echo '<li class="prev-list-item page-item me-4 bg-primary py-2 px-3 rounded text-white">';
                    echo $prev_posts_link;
                    echo '</li>';
                endif;
                echo '<li class="page-item me-4 ">';
                echo join('</li><li class="page-item me-4">', $links);
                echo '</li>';

                // get_next_posts_link will return a string or void if no link is set.
                if ($next_posts_link = get_next_posts_link(__('بعدی'))) :
                    echo '<li class="next-list-item page-item me-4 bg-primary py-2 px-3 rounded text-white">';
                    echo $next_posts_link;
                    echo '</li>';
                endif;
                echo '</ul>';
                ?>
            </nav>
        <?php endif;
    } else {
        echo '<h2 class="headline headline--small-plus">نتیجه ای یافت نشد</h2>';
    }
    ?>

</div>


<?php get_footer(); ?>
