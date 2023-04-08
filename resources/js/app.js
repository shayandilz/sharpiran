import {left} from "@popperjs/core";

require('./bootstrap');
import 'swiper/css';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import $ from 'jquery';


document.addEventListener('DOMContentLoaded', function () {



    // JavaScript code to update payment amounts based on range meter selection
    let totalAmount = document.getElementById('totalAmount').value;

    // JavaScript code to update payment amounts and total amount based on range meter selection
    const rangeMeter = document.getElementById('payment-range');

    const upfrontPayment = document.getElementById('upfront-payment');
    const interestPayment = document.getElementById('interest-payment');
    const totalPayment = document.getElementById('total-payment');
    const lastPayment = document.getElementById('last-payment');

    const calculatePayments = (totalAmount, paymentPlan) => {
        let upfrontPaymentValue = Math.round(totalAmount * 0.4);
        let leftPayment = 0;
        let interestPaymentValue = 0;
        let totalPaymentValue = 0;
        let last = 0

        switch (paymentPlan) {
            case 1:
                interestPaymentValue = Math.round(totalAmount * 0.1);
                leftPayment = totalAmount - upfrontPaymentValue;

                totalPaymentValue = interestPaymentValue + leftPayment;
                last = upfrontPaymentValue + totalPaymentValue;

                break;
            case 2:
                interestPaymentValue = Math.round(totalAmount * 0.25);
                leftPayment = totalAmount - upfrontPaymentValue;

                totalPaymentValue = (leftPayment / 2) + (interestPaymentValue / 2);
                last = upfrontPaymentValue + (totalPaymentValue * 2);
                break;
            case 3:
                interestPaymentValue = Math.round(totalAmount * 0.4);
                leftPayment = totalAmount - upfrontPaymentValue;

                totalPaymentValue = (leftPayment / 3) + (interestPaymentValue / 3);
                last = upfrontPaymentValue + (totalPaymentValue * 3);
                break;
        }

        upfrontPayment.value = upfrontPaymentValue;
        interestPayment.value = interestPaymentValue;
        totalPayment.value = Math.round(totalPaymentValue);
        lastPayment.value = last;
    };

    rangeMeter.addEventListener('input', () => {
        const paymentPlan = parseInt(rangeMeter.value);
        calculatePayments(totalAmount, paymentPlan);
    });

// Initialize the payment amounts and total amount with the default payment plan
    calculatePayments(totalAmount, 1);




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

})

$(document).ready(function () {
    $(window).scroll(function () { // check if scroll event happened
        if ($(document).scrollTop() > 30) { // check if user scrolled more than 50 from top of the browser window
            $('.sticky__nav').addClass('position-fixed top-0 shadow-sm');
            $('.backTo_Top').removeClass('outro');
            $('.backTo_Top').addClass('intro');
        }
        else if ($(document).scrollTop() < 30) {
            $('.sticky__nav').removeClass('position-fixed top-0 shadow-sm');
            $('.backTo_Top').addClass('outro');
            $('.backTo_Top').removeClass('intro');
        }
    })
      let ajax_url = jsData.api_root
    $(document).on('submit', '.add-product', function (e) {
        e.preventDefault();
        const formId = $(this).attr('data-id');
        let endpointOrder = jsData.root_url + '/wp-json/wc/v3/orders'
        let apiDataOrder = {
            status: 'processing',
            billing:
                {
                    first_name: $(this).find('[firstName-id="' + $(this).find('#product_id').val() + '"]').val(),
                    last_name: $(this).find('[lastName-id="' + $(this).find('#product_id').val() + '"]').val(),
                    phone: $(this).find('[phone-id="' + $(this).find('#product_id').val() + '"]').val(),
                    address_1: $(this).find('[address-id="' + $(this).find('#product_id').val() + '"]').val(),
                    state: $(this).find('[state-id="' + $(this).find('#product_id').val() + '"]').attr('data-active-state'),
                    city: $(this).find('[city-id="' + $(this).find('#product_id').val() + '"]').attr('data-active-city'),

                },
            meta_data: [
                {
                    key: 'user_identity',
                    value : $(this).find('[user-id="' + $(this).find('#product_id').val() + '"]').val(),
                },
                {
                    key: 'user_code',
                    value : $(this).find('[user-code="' + $(this).find('#product_id').val() + '"]').val(),
                }
            ],
            line_items: [
                {
                    product_id: formId,
                    quantity: $(this).find('[data-product-id="' + $(this).find('#product_id').val() + '"]').val(),
                    meta_data: [
                        {
                            key: 'شیوه پرداخت',
                            value: $(this).find('[method-product-id="' + $(this).find('#product_id').val() + '"]').val(),
                        },
                        {
                            key: 'مبلغ',
                            value: $(this).find('[price-id="' + $(this).find('#product_id').val() + '"]').val()
                        }
                    ]
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
                $(this).trigger('reset');

                // Update user billing address
                let updateData = {
                    billing: {
                        address_1: apiDataOrder.billing.address_1,
                        phone: apiDataOrder.billing.phone,
                        city: apiDataOrder.billing.city,
                        state: apiDataOrder.billing.state
                    },
                    meta_data: [
                        {
                            key: 'user_identity',
                            value: apiDataOrder.meta_data[0].value
                        },
                        {
                            key: 'user_code',
                            value: apiDataOrder.meta_data[1].value
                        }
                    ]
                };
                $.ajax({
                    url: jsData.root_url + '/wp-json/wc/v3/customers/' + jsData.user_id + '?consumer_key=' + jsData.apiUser + '&consumer_secret=' + jsData.apiKey,
                    type: "PUT",
                    data: JSON.stringify(updateData),
                    contentType: "application/json",
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.responseText);
                    }
                });
            }.bind(this),
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.responseText);

                // ...handle error...
            }
        })
    })


});



