<?php /* Template Name: Home */
get_header(); ?>


<?php if (have_posts()) {
    the_post(); ?>
    <?php get_template_part('template-parts/homePage/hero'); ?>
    <div class="container min-vh-100 mt-2">
        <div class="row justify-content-center align-items-start py-3">
            <div class="col-lg-3">
                <h3 class="text-red fw-bold fs-5">دسته بندی محصولات</h3>
                <ul class="category-list justify-content-center pt-2 gap-3 align-items-center list-unstyled shadow-sm p-3 rounded">
                    <?php
                    $taxonomy = 'product_cat';
                    $orderby = 'name';
                    $show_count = 0;      // 1 for yes, 0 for no
                    $pad_counts = 0;      // 1 for yes, 0 for no
                    $hierarchical = 1;    // 1 for yes, 0 for no
                    $title = '';

                    $args = array(
                        'taxonomy' => $taxonomy,
                        'orderby' => $orderby,
                        'show_count' => $show_count,
                        'pad_counts' => $pad_counts,
                        'hierarchical' => $hierarchical,
                        'title_li' => $title,
                        'hide_empty' => 0 // Show empty categories as well
                    );

                    $all_categories = get_categories($args);

                    // Add an option to display all products
                    echo '<li>';
                    echo '<label>';
                    echo '<input type="checkbox" class="category-filter" value="all" checked > همه محصولات';
                    echo '</label>';
                    echo '</li>';

                    function display_categories($categories, $parent_id = 0)
                    {
                        foreach ($categories as $category) {
                            if ($category->parent == $parent_id) {
                                $category_id = $category->term_id;
                                $thumbnail_id = get_term_meta($category_id, 'thumbnail_id', true);
                                $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'thumbnail');
                                $category_name = $category->name;
                                $has_children = $category->category_count > 0;

                                // Output category name with checkbox
                                echo '<li>';
                                echo '<label>';
                                echo '<input type="checkbox" class="category-filter" value="' . $category_id . '"> ';
                                echo $category_name;
                                if ($thumbnail_url) {
                                    echo '<img class="img-thumbnail mx-1" width="40" height="40" src="' . $thumbnail_url . '">';
                                }
                                echo '</label>';

                                if ($has_children) {
                                    // Get child categories
                                    $child_categories = get_categories(array(
                                        'taxonomy' => 'product_cat',
                                        'parent' => $category_id,
                                        'hide_empty' => 0
                                    ));

                                    if (!empty($child_categories)) {
                                        echo '<ul class="ps-3 list-unstyled">';
                                        display_categories($child_categories, $category_id);
                                        echo '</ul>';
                                    }
                                }

                                echo '</li>';
                            }
                        }
                    }

                    display_categories($all_categories);
                    ?>
                </ul>

            </div>
            <div class="col-lg-9 product-cards">
                <div class="row row-cols-lg-3 row-cols-1" id="product-container">
                    <?php
                    // Filter variables
                    $selected_categories = isset($_GET['category']) ? explode(',', $_GET['category']) : array();

                    // Check if 'all' is selected
                    if (in_array('all', $selected_categories)) {
                        $selected_categories = array(); // Clear the array to show all products
                    }

                    // Display product cards
                    $product_args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'operator' => 'IN',
                                'field' => 'term_id',
                                'terms' => $selected_categories
                            )
                        )
                    );

                    // Modify the query to show all products if no category is selected
                    if (empty($selected_categories)) {
                        unset($product_args['tax_query']);
                    }

                    $product_loop = new WP_Query($product_args);
                    if ($product_loop->have_posts()) {
                        while ($product_loop->have_posts()) : $product_loop->the_post();
                            // Retrieve the category IDs for the current product
                            $category_ids = wp_get_post_terms(get_the_ID(), 'product_cat', array('fields' => 'ids'));
                            // Output the product card here
                            get_template_part('template-parts/product_card', '', array('category_ids' => $category_ids));
                        endwhile;
                        wp_reset_postdata();
                    }
                    ?>
                </div>

            </div>

        </div>
    </div>
<?php }
get_footer();
