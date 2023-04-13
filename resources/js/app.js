import {left} from "@popperjs/core";

require('./bootstrap');
import 'swiper/css';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import $ from 'jquery';


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

})

$(document).ready(function () {
    $('#contact-form').submit(function(event) {
        event.preventDefault();
        var email = $('#input_1_4').val();
        var phone = $('#input_1_3').val();

        $.ajax({
            url: 'submit-form.php',
            type: 'POST',
            data: { email: email, phone: phone },
            success: function() {
                alert('Form submitted successfully!');
                location.reload(); // add this line to refresh the page
            },
            error: function() {
                alert('Error submitting form.');
            }
        });
    });
    if ($(window).width() < 960 ) {
        $('.contact-us__form .form-floating').addClass('col-12');
    }
    else if ($(window).width() > 960 ) {
        $('.contact-us__form .form-floating').removeClass('col-12');
    };
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



