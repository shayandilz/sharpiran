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
// Attach the event handler to a parent element that exists in the DOM when the page loads
    $(document).on('change', '.category-filter', function () {
        var selectedCategories = [];

        // Check if "All Products" option is selected
        var isAllSelected = false;
        $('.category-filter:checked').each(function () {
            var category = $(this).val();
            if (category == 'all') {
                isAllSelected = true;
            } else {
                selectedCategories.push(category);
            }
        });

        // Filter the product list based on selected categories
        $('.product-card').each(function() {
            var productCategories = $(this).attr('data-categories');

            // Show all products if "All Products" is selected or no category is selected
            if (isAllSelected || selectedCategories.length === 0) {
                $(this).show();
            }
            // Filter products based on selected categories
            else if (productCategories) {
                var categories = productCategories.split(',');
                var matches = selectedCategories.filter(function(category) {
                    return categories.indexOf(category) !== -1;
                });

                if (matches.length > 0) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                $(this).hide();
            }
        });


    });


    $(window).scroll(function () { // check if scroll event happened
        if ($(document).scrollTop() > 30) { // check if user scrolled more than 50 from top of the browser window
            // $('.sticky__nav').addClass('position-fixed top-0 shadow-sm');
            $('.backTo_Top').removeClass('outro');
            $('.backTo_Top').addClass('intro');
        }
        else if ($(document).scrollTop() == 0) {
            // $('.sticky__nav').removeClass('position-fixed top-0 shadow-sm');
            $('.backTo_Top').addClass('outro');
            $('.backTo_Top').removeClass('intro');
        }
    })
});

require('./order');
require('./order-front');



