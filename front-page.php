<?php /* Template Name: Home */
get_header(); ?>


<?php if (have_posts()) {
    the_post(); ?>
    <div class="container-fluid min-vh-100">
        <div class="row justify-content-center align-items-center pb-3">
            <div class="col-11 col-lg-8">
                <ul class="nav nav-tabs flex-nowrap overflow-tab" id="myTab" role="tablist">
                    <?php
                    $i = 0;

                    $taxonomy = 'product_cat';
                    $orderby = 'name';
                    $show_count = 0;      // 1 for yes, 0 for no
                    $pad_counts = 0;      // 1 for yes, 0 for no
                    $hierarchical = 1;      // 1 for yes, 0 for no
                    $title = '';

                    $args = array(
                        'taxonomy' => $taxonomy,
                        'orderby' => $orderby,
                        'show_count' => $show_count,
                        'pad_counts' => $pad_counts,
                        'hierarchical' => $hierarchical,
                        'title_li' => $title,
                        'hide_empty' => 1
                    );
                    $all_categories = get_categories($args);
                    foreach ($all_categories as $cat) {
                        if ($cat->category_parent == 0) {
                            $category_id = $cat->term_id; ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php if ($i == 0) {
                                    $i = 1;
                                    echo 'active';
                                }
                                ?>" id="cat-<?= $category_id; ?>-tab" data-bs-toggle="tab"
                                        data-bs-target="#cat-<?= $category_id; ?>" type="button" role="tab"
                                        aria-controls="cat-<?= $category_id; ?>"
                                        aria-selected="true">
                                    <?= $cat->name; ?>
                                </button>
                            </li>

                        <?php }
                    }
                    ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <?php
                    foreach ($all_categories as $key => $cats) {
                        $category_id = $cats->term_id;
                        ?>
                        <div class="tab-pane fade <?php if ($key == 0) {
                            echo 'show active';
                        }
                        ?>" id="cat-<?= $category_id; ?>" role="tabpanel" aria-labelledby="cat-<?= $category_id; ?>-tab">
                            <?php

                            $args = array(
                                'post_type' => 'product',
                                'post_status' => 'publish',
                                'ignore_sticky_posts' => 1,
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'term_id',
                                        'terms' => $category_id,
                                        'operator' => 'IN'
                                    )
                                )
                            );
                            $loop = new WP_Query($args);
                            if ($loop->have_posts()) {?>
                                <div class="row row-cols-lg-3 row-cols-1">
                                <?php while ($loop->have_posts()) : $loop->the_post();
                                    get_template_part('template-parts/product_card');
                                endwhile;
                            }?>
                                </div>
                            <?php wp_reset_postdata();

                            ?>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
<?php }
get_footer();
