require('./bootstrap');
import 'swiper/css';
import WOW from 'wow.js';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import $ from 'jquery';


const wow = new WOW(
    {
        boxClass: 'wow',      // animated element css class (default is wow)
        animateClass: 'animated', // animation css class (default is animated)
        offset: 0,          // distance to the element when triggering the animation (default is 0)
        // duration: 1.5,
        mobile: true,       // trigger animations on mobile devices (default is true)
        live: true,       // act on asynchronously loaded content (default is true)
        scrollContainer: null,    // optional scroll container selector, otherwise use window,
        resetAnimation: true,     // reset animation on end (default is true)
    }
);
wow.init();


document.addEventListener('DOMContentLoaded', function () {

    let btn = $('#myBtn');
    btn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '300');
    });

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    require('./gsap');


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

    const swiper = new Swiper('.swiper1', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        // autoplay: true,
        grabCursor: true,
        pagination:false,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        disableOnInteraction: false,
    });
    const swiper2 = new Swiper('.swiper2', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
        centeredSlides: true,
        roundLengths: false,
        grabCursor: true,
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
        },
        disableOnInteraction: false,
    });
    const swiper3 = new Swiper('.swiper3', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        spaceBetween: 30,
        slidesPerView: "auto",
        centeredSlides: true,
        roundLengths: false,
        grabCursor: true,
        disableOnInteraction: false,
    });


})

$(document).ready(function () {

    let ajax_url = jsData.api_root
    $(document).on('submit','.add-product', function (e) {
        e.preventDefault();
        let endpointOrder = jsData.root_url + '/wp-json/wc/v3/orders'
        let apiDataOrder = {
            status: 'processing',
            billing:
                {
                    first_name: $('#name').val(),
                    phone: $('#phone').val(),
                    address_1: $('#address').val()

                },
            line_items: [
                {
                    product_id: $('#product_id').val(),
                    quantity: $('.number').val(),
                },
            ],
            customer_id: jsData.user_id
        }
        console.log(apiDataOrder)
        $.ajax({
            url: endpointOrder + "?consumer_key=" + jsData.apiUser + "&consumer_secret=" + jsData.apiKey,
            type: "POST",
            data: JSON.stringify(apiDataOrder),
            contentType: "application/json",
            dataType: 'json',
            success: function (result) {
                console.log(result)


            }
        })
    })


});



