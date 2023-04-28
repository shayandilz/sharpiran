import $ from "jquery";

document.addEventListener('DOMContentLoaded', function () {
    let ajax_url = jsData.api_root
    $(document).on('submit', '.add-product-front', function (el) {
        el.preventDefault();
        $('.form-body').addClass('spinner-custom');

        let resultDiv = $('.form_result-front');
        let formDiv = $('.form-body');
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
    })
})