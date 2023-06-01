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
        totalPayment.value = Math.ceil(totalPaymentValue.toFixed(0) / 1000) * 1000;
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
    let $form = $(this); // Store the reference to the form element
    $('.form-body').addClass('spinner-custom');
    let resultDiv = $('.form_result');
    let formDiv = $('.form-body');
// Get the selected payment value
    let paymentRange = $form.find('[range-id="' + $form.find('#product_id').val() + '"]').val();
    // Get the label corresponding to the selected payment value
    let paymentLabels = $('.payment-label');
    let selectedLabel = $(paymentLabels[paymentRange - 1]).text();



    // Validate file types
    let fileInput = $form.find('[type="file"]');
    let allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    let files = fileInput[0].files;
    let invalidFiles = Array.from(files).filter(file => !allowedTypes.includes(file.type));

    if (invalidFiles.length > 0) {
        // Display error message for invalid file types
        let errorMessage = 'Invalid file type(s). Only JPG, PNG, and PDF files are allowed.';
        resultDiv.html('<div class="alert alert-danger">' + errorMessage + '</div>');
        return;
    }

    $.ajax({
        url: ajax_url,
        type: "POST",
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', jsData.apiNonce);
        },
        data: new FormData(this),
        success: function (response) {

            // Remove HTML tags from the response
            let responseWithoutTags = response.replace(/<\/?[^>]+(>|$)/g, "");
            let filesParsed = JSON.parse(responseWithoutTags)
            let fileUrls = filesParsed.urls || [];
            // Use the extracted file URLs as needed
            let checkedFiles = fileUrls;

            // ... continue with your code ...

            if (checkedFiles.length === 0) {
                checkedFiles = [''];
            }
            let meta_data = checkedFiles.map((url, index) => ({
                key: `فایل چک ${index + 1}`,
                value: url
            }));
            if (meta_data.length === 0) {
                meta_data = [{ key: 'فایل چک 1', value: '' }];
            }

            const formId = $form.attr('data-id');
            let endpointOrder = jsData.root_url + '/wp-json/wc/v3/orders'
            let apiDataOrder = {
                status: 'processing',
                billing:
                    {
                        first_name: $form.find('[firstName-id="' + $form.find('#product_id').val() + '"]').val(),
                        last_name: $form.find('[lastName-id="' + $form.find('#product_id').val() + '"]').val(),
                        phone: $form.find('[phone-id="' + $form.find('#product_id').val() + '"]').val(),
                        address_1: $form.find('[address-id="' + $form.find('#product_id').val() + '"]').val(),
                        state: $form.find('[state-id="' + $form.find('#product_id').val() + '"]').attr('data-active-state'),
                        city: $form.find('[city-id="' + $form.find('#product_id').val() + '"]').attr('data-active-city'),

                    },

                meta_data: [
                    {
                        key: 'user_identity',
                        value: $form.find('[user-id="' + $form.find('#product_id').val() + '"]').val(),
                    },
                    {
                        key: 'user_code',
                        value: $form.find('[user-code="' + $form.find('#product_id').val() + '"]').val(),
                    },
                    {
                        key: 'روش های بازپرداخت',
                        value: selectedLabel


                    },
                    ...meta_data

                ],
                line_items: [
                    {
                        product_id: formId,
                        quantity: $form.find('[data-product-id="' + $form.find('#product_id').val() + '"]').val(),
                        meta_data: [
                            {
                                key: 'شیوه پرداخت',
                                value: $form.find('[method-product-id="' + $form.find('#product_id').val() + '"]').val(),
                            },
                            {
                                key: 'مبلغ',
                                value: $form.find('[price-id="' + $form.find('#product_id').val() + '"]').val()
                            },
                            {
                                key: 'تعداد اقساط',
                                value: selectedLabel
                            },
                            ...meta_data
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
                    $('.form-body').removeClass('spinner-custom');
                    formDiv.fadeOut()
                    if (result.status == 'processing') {
                        resultDiv.html(`
                    <div class="card order-card border-0">
                        <div class="card-body bg-primary rounded">
                            <div class="invoice-middle text-center">
                                <div class="alert alert-success fs-2 mb-3" role="alert">سفارش با موفقیت ایجاد شد</div>
                                    <div class="row justify-content-center align-items-center mb-0 gap-3">
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
                                        <a class="btn bg-red text-white" href="/my-account/view-order/${result.number}" target="_blank">مشاهده سفارش</a>
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

        }
    });


})