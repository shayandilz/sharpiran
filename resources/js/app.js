import {left} from "@popperjs/core";

require('./bootstrap');
import 'swiper/css';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import $ from 'jquery';

import Search from "./search";

const search = new Search();

document.addEventListener('DOMContentLoaded', function () {
    let btn = $('#myBtn');
    btn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, '300');
    });

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


    //toggle header on time
    const toggleScrollClass = function () {
        if (window.scrollY > 24) {
            document.body.classList.add('scrolled');
        } else {
            document.body.classList.remove('scrolled');
        }
    }
    toggleScrollClass();

    //check scroll to take actions on it
    window.addEventListener('scroll', function () {
        toggleScrollClass();
    });
    const swiper = new Swiper('.product-gallery', {
        // Optional parameters
        loop: true,
        effect: 'slide',
        slidesPerView: 1,
        spaceBetween: 0,
        direction: 'horizontal',
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 10000,
        },
        disableOnInteraction: false,
    })
    const swiper2 = new Swiper('.shop_swiper', {
        // Optional parameters
        loop: true,
        effect: 'slide',
        speed: 1000,
        autoplay: {
            delay: 5000,
        },
        slidesPerView: 1,
        spaceBetween: 0,
        // disableOnInteraction: false,
    });

})

$(document).ready(function () {
// Handle category checkbox change event
    $('.category-filter').on('change', function () {
        var selectedCategories = [];

        // Check if "All Products" option is selected
        var isAllSelected = false;
        $('.category-filter:checked').each(function () {
            var category = $(this).val();
            if (category === 'all') {
                isAllSelected = true;
            } else {
                selectedCategories.push(category);
            }
        });

        // If "All Products" is selected, clear other selected categories
        if (isAllSelected) {
            selectedCategories = [];
        }

        // AJAX request to update the product list
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'update_product_list',
                categories: selectedCategories
            },
            beforeSend: function () {
                // Show loading indicator or perform any pre-request tasks
                $('.product-cards').addClass('loading');
            },
            success: function (response) {
                // Update the product list
                $('.product-cards .row').html(response.productListHtml);
                $('.product-cards').removeClass('loading');
                // Show message if response is empty
                if (response.productListHtml.trim() === '') {
                    $('.product-cards .row').html('<h4 class="text-center w-100 py-3">محصولی یافت نشد</h4>');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $(window).scroll(function () { // check if scroll event happened
        if ($(document).scrollTop() > 30) { // check if user scrolled more than 50 from top of the browser window
            $('.sticky__nav').addClass('position-fixed top-0 shadow-sm');
            $('.backTo_Top').removeClass('outro');
            $('.backTo_Top').addClass('intro');
        }
        else if ($(document).scrollTop() == 0) {
            $('.sticky__nav').removeClass('position-fixed top-0 shadow-sm');
            $('.backTo_Top').addClass('outro');
            $('.backTo_Top').removeClass('intro');
        }
    })
});

require('./order');
require('./order-front');



