import $ from "jquery";

document.addEventListener('DOMContentLoaded', function () {

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
        totalPayment.value = Math.ceil(totalPaymentValue.toFixed(0)/1000) * 1000;
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
    $('.form-body').addClass('spinner-custom');

    let resultDiv = $('.form_result');
    let formDiv = $('.form-body')
    let fileUpload = $(this).find('[file-id="' + $(this).find('#product_id').val() + '"]').val();
    let checkedFile = fileUpload.match(/\b(http|https)?(:\/\/)?(\S*)\.(\w{2,4})(.*)/g)
    if (checkedFile === null) {
        checkedFile = ['']
    }
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
                value: $(this).find('[user-id="' + $(this).find('#product_id').val() + '"]').val(),
            },
            {
                key: 'user_code',
                value: $(this).find('[user-code="' + $(this).find('#product_id').val() + '"]').val(),
            },
            {
                key:'فایل چگ',
                value: checkedFile[0]
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
                    },
                    {
                        key:'فایل چگ',
                        value: checkedFile[0]
                    }
                ]
            },

        ],
        customer_id: jsData.user_id
    }
    $.ajax({
        url: endpointOrder + "?consumer_key=" + jsData.apiUser + "&consumer_secret=" + jsData.apiKey,
        type: "POST",
        data: JSON.stringify(apiDataOrder),
        contentType: "application/json",
        dataType: 'json',
        success: function (result) {
            console.log(result)
            $('.form-body').removeClass('spinner-custom');
            formDiv.fadeOut()
            if (result.status == 'processing') {
                resultDiv.html(`
                    <div class="card border-0">  
                        <div class="card-body bg-primary rounded">
                            <div class="invoice-middle">
                                <div class="alert alert-success" role="alert">سفارش با موفقیت ایجاد شد</div>
                                    <div class="row justify-content-center align-items-center mb-0">
                                        <div class="col-md-12 text-center mt-2 mt-sm-0">
                                        <div class="d-block">
                                            <div class="alert alert-primary alert-pills" role="alert">
                                                <span class="content ">کد سفارش </span>
                                                <span class="badge rounded-pill bg-red me-1 fs-5 px-3 py-2">${result.number}</span>
                                            </div>
                                    </div>
                                </div>
                               <div class="row justify-content-center align-items-center">
                                    <div class="col-md-12 text-center">
                                        <a href="/my-account/view-order/${result.number}" target="_blank">
                                        <button class="btn btn-secondary">
                                        مشاهده سفارش 
                                        </button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                `)
            } else {
                resultDiv.html(`
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="invoice-middle">
                                <div class="alert alert-danger" role="alert">ثبت سفارش با مشکل مواجه شده است.</div>
                            </div>
                        </div>
                    </div>
                `)
            }
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