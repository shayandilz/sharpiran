<?php
// include the WooCommerce API library
require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

// set up the WooCommerce API client
$woocommerce = new Client(
    'http://tech.local', // your store URL
    'ck_1cd80595e1d0e1d7859ddfd0fe0e7d6d5479ebfb', // your consumer key
    'cs_a8cc4d5f113d7b6cd74265c3d75106519a530341', // your consumer secret
    [
        'wp_api' => true, // enable the WP REST API integration
        'version' => 'wc/v3' // WooCommerce API version
    ]
);

// process the form data if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // retrieve the form data
    $product_id = $_POST['product_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $company = $_POST['company'];
    $address_1 = $_POST['address_1'];
    $address_2 = $_POST['address_2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postcode = $_POST['postcode'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $quantity = $_POST['quantity'];
    $payment_method = $_POST['payment_method'];
    $customer_note = $_POST['customer_note'];

    // create the order using the WooCommerce API
    $data = [
        'payment_method' => $payment_method,
        'payment_method_title' => $payment_method,
        'set_paid' => true,
        'billing' => [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'company' => $company,
            'address_1' => $address_1,
            'address_2' => $address_2,
            'city' => $city,
            'state' => $state,
            'postcode' => $postcode,
            'country' => $country,
            'email' => $email,
            'phone' => $phone
        ],
        'shipping' => [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'company' => $company,
            'address_1' => $address_1,
            'address_2' => $address_2,
            'city' => $city,
            'state' => $state,
            'postcode' => $postcode,
            'country' => $country
        ],
        'line_items' => [
            [
                'product_id' => $product_id,
                'quantity' => $quantity
            ]
        ],
        'customer_note' => $customer_note
    ];

    $woocommerce->post('orders', $data);

    // redirect the user to a confirmation page
//    header('Location: confirmation.php');
    exit;
}
