import $ from "jquery";

document.addEventListener('DOMContentLoaded', function (){

    const calculatePayments = (form, paymentPlan, counter) => {
        let totalAmount = form.querySelector('#totalAmount').value * counter;
        let upfrontPayment = form.querySelector('#upfront-payment');
        let interestPayment = form.querySelector('#interest-payment');
        let totalPayment = form.querySelector('#total-payment');
        let lastPayment = form.querySelector('#last-payment');

        let upfrontPaymentValue = Math.round(totalAmount * 0.4);
        let leftPayment = 0;
        let interestPaymentValue = 0;
        let totalPaymentValue = 0;
        let last = 0;

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

    document.querySelectorAll('.add-product').forEach(function (form) {
        let paymentRange = form.querySelector('#payment-range');
        let counterInput = form.querySelector('#counter');

        if (paymentRange && counterInput) {
            paymentRange.addEventListener('input', function () {
                const paymentPlan = parseInt(paymentRange.value);
                const counter = parseInt(counterInput.value);
                calculatePayments(form, paymentPlan, counter);
            });

            counterInput.addEventListener('input', function () {
                const paymentPlan = parseInt(paymentRange.value);
                const counter = parseInt(counterInput.value);
                calculatePayments(form, paymentPlan, counter);
            });

            calculatePayments(form, 1, 1);
        }
    });


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