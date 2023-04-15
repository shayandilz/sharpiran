<?php /* Template Name: Home */
get_header(); ?>


<?php if (have_posts()) {
    the_post(); ?>
    <div class="container-fluid min-vh-100">
        <div class="row justify-content-center align-items-center pb-3">
            <div class="col-11">
                <ul class="nav nav-tabs border-0 flex-nowrap overflow-tab justify-content-lg-center align-items-center py-3 gap-2"
                    id="myTab" role="tablist">
                    <?php
                    $i = 0;
                    $j = 0;

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
                            $category_id = $cat->term_id;
                            $thumbnail_id = get_term_meta($category_id, 'thumbnail_id', true);
                            $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'thumbnail');
                            ?>
                            <li class="nav-item" role="presentation">
                                <button class="category-tab animate__animated animate__bounceIn animate__delay-<?= $j;?>s border-0 <?= $thumbnail_id ? 'd-flex align-items-center' : '' ;?> nav-link <?php if ($i == 0) {
                                    $i = 1;
                                    echo 'active';
                                }
                                ?>" id="cat-<?= $category_id; ?>-tab" data-bs-toggle="tab"
                                        data-bs-target="#cat-<?= $category_id; ?>" type="button" role="tab"
                                        aria-controls="cat-<?= $category_id; ?>"
                                        aria-selected="true">
                                    <?php if ($thumbnail_id) { ?>
                                        <img class="w-100" title="<?php echo $cat->name; ?>"
                                             src="<?php echo $thumbnail_url; ?>" alt="<?php echo $cat->name; ?>">
                                    <?php } else {
                                        echo $cat->name;
                                    } ?>
                                </button>
                            </li>

                        <?php }
                        $j++;
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
                        ?>" id="cat-<?= $category_id; ?>" role="tabpanel"
                             aria-labelledby="cat-<?= $category_id; ?>-tab">
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
                            if ($loop->have_posts()) { ?>
                            <div class="row row-cols-lg-4 row-cols-md-3 row-cols-2">
                                <?php while ($loop->have_posts()) : $loop->the_post();
                                    get_template_part('template-parts/product_card');
                                endwhile;
                                } ?>
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
