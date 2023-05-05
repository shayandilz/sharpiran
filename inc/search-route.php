<?php

function register_new_search()
{
    register_rest_route('search/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'GoldSearchResults'
    ));
}

function GoldSearchResults($data)
{
//    $termsTax = get_terms([
//        'taxonomy' => 'brand',
//        'name__like' => sanitize_text_field($data['term'])
//    ]);
//    $count = count($termsTax);

    $mainQuery = new WP_Query(array(
        'post_type' => array('product'),
        's' => sanitize_text_field($data['term'])
    ));
    $mainResults = array(
//        'blog' => array(),
        'product' => array(),
    );

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        global $product;
        if (get_post_type() == 'product') {
            $mainResults['product'][] = array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'img' => get_the_post_thumbnail_url(0, ''),
                'content' => get_the_content(),
                'price' => $product->get_regular_price()

            );
        }

    }

    return $mainResults;
}

add_action('rest_api_init', 'register_new_search');