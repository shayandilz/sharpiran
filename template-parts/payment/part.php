<?php
global $product;

$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();

$first_name = $current_user->first_name;
$last_name = $current_user->last_name;
$mobile_number = get_user_meta($current_user_id, 'mobile_number', true);
$billing_address_1 = get_user_meta($current_user_id, 'billing_address_1', true);
$user_identity = get_user_meta($current_user_id, 'user_identity', true);
$user_code = get_user_meta($current_user_id, 'user_code', true);


// Define the upfront payment percentage and interest rate
$upfrontPaymentPercentage = 0.4;
$interestRate = 0.1;

// Get the total amount due from the customer
$totalAmountDue = $product->get_regular_price(); // Replace with your own value or retrieve from user input

// Calculate the upfront payment and remaining balance
$upfrontPayment = ceil($totalAmountDue * $upfrontPaymentPercentage * 100) / 100;
$remainingBalance = $totalAmountDue - $upfrontPayment;

// Calculate the monthly payment amount based on the remaining balance and number of months
$numberOfMonths = 2;
$monthlyInterestRate = $interestRate / 12;
$monthlyPayment = ceil(($remainingBalance * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $numberOfMonths)) / (pow(1 + $monthlyInterestRate, $numberOfMonths) - 1) * 1000) / 1000;

// Calculate the total amount paid by the customer, including interest
$totalAmountPaid = ceil($upfrontPayment + ($monthlyPayment * $numberOfMonths * 1.03) * 100) / 100;
$lastAmount = $upfrontPayment + $totalAmountPaid;
?>
<form action="" class="add-product border p-3" data-form-id="<?= get_the_ID(); ?>" data-id="<?= get_the_ID(); ?>" id="form-<?= get_the_ID(); ?>"
      method="post" enctype="multipart/form-data">
    <div class="row g-3 mb-3">
        <!-- HTML code for the range meter -->
        <!-- HTML code for the range meter and payment details -->
        <div class="form-group">
            <label for="payment-range">روش های بازپرداخت</label>
            <input type="range" class="form-range" id="payment-range" value="0" min="1" max="3" step="1">
            <div id="payment-labels" class="d-flex justify-content-between fs-5">
                <div class="badge rounded-circle bg-red payment-label">۱</div>
                <div class="badge rounded-circle bg-red payment-label">۲</div>
                <div class="badge rounded-circle bg-red payment-label">۳</div>
            </div>
            <div id="payment-label" class="mt-2"></div>
        </div>

        <div class="d-flex flex-wrap flex-lg-nowrap gap-lg-3 gap-2 align-items-center justify-content-evenly">
            <div class="mb-3 shadow-sm col-lg col-12">
                <label for="upfront-payment" class="form-label">پیش پرداخت</label>
                <input type="text" price-id="<?= get_the_ID(); ?>" class="form-control bg-red text-white text-center fs-5"
                       id="upfront-payment" value readonly>
            </div>
            <div class="mb-3 shadow-sm col-lg col-12">
                <label for="interest-payment" class="form-label">سود اقساط</label>
                <input type="text" class="form-control bg-red text-white text-center fs-5"
                       id="interest-payment" value readonly>
            </div>
            <div class="mb-3 shadow-sm col-lg col-12">
                <label for="total-payment" class="form-label">مبلغ قسط</label>
                <input type="text" class="form-control bg-red text-white text-center fs-5"
                       id="total-payment" value readonly>
            </div>
        </div>
        <div class="mb-3">
            <label for="total-payment" class="form-label fw-bolder fs-4">مبلغ نهایی</label>
            <input type="text" class="form-control bg-red text-white text-center fs-5"
                   id="last-payment" value readonly>
        </div>

        <input type="text" value="<?= $totalAmountDue; ?>" id="totalAmount" hidden>
        <div class="col-md-4 form-floating">
            <!--        First Name        -->
            <input disabled
                   placeholder="نام"
                   value="<?php echo $first_name; ?>"
                   firstName-id="<?= get_the_ID(); ?>"
                   required id="name floatingName"
                   type="text"
                   name="account_first_name"
                   class="name form-control"/>
            <label for="floatingName">نام</label>
        </div>
        <div class="col-md-4 form-floating">
            <!--        Last Name        -->
            <input disabled
                   placeholder="نام خانوادگی"
                   value="<?php echo $last_name; ?>"
                   lastName-id="<?= get_the_ID(); ?>"
                   required
                   id="lastname floatinglastName"
                   type="text"
                   name="account_last_name"
                   class="name form-control"/>
            <label for="floatingName">نام خانوادگی</label>
        </div>
        <div class="col-md-4 form-floating">
            <input placeholder="+989123456789"
                <?= $mobile_number ? 'disabled' : '' ?>
                   value="<?php echo $mobile_number; ?>"
                   phone-id="<?= get_the_ID(); ?>"
                   required
                   id="phone floatingPhone"
                   type="tel"
                   name="phone"
                   class="phone form-control"/>
            <label for="floatingPhone">تلفن</label>
        </div>
        <div class="col-md-4 form-floating">
            <input placeholder="123456789"
                <?= $user_identity ? 'disabled' : '' ?>
                   value="<?php echo $user_identity ?: ''; ?>"
                   user-id="<?= get_the_ID(); ?>"
                   id="floatingID"
                   type="text"
                   name="user_identity"
                   class="user_identity form-control"/>
            <label for="floatingID">شماره شناسنامه</label>
        </div>
        <div class="col-md-4 form-floating">
            <input placeholder="123456789"
                <?= $user_code ? 'disabled' : '' ?>
                   value="<?php echo $user_code ?: ''; ?>"
                   user-code="<?= get_the_ID(); ?>"
                   id="floatingCode"
                   type="text"
                   name="user_code"
                   class="user_code form-control"/>
            <label for="floatingCode">کد ملی</label>
        </div>
        <div class="form-floating col-md-4">
            <input class="form-control" type="number" data-product-id="<?= get_the_ID(); ?>" id="counter" value="1" min="1">
            <label for="counter">تعداد</label>
        </div>
        <div class="col-md-12 form-floating">
            <input required
                   id="address floatingAddress"
                   address-id="<?= get_the_ID(); ?>"
                   type="text"
                   value="<?= $billing_address_1 ?: ''; ?>"
                   name="address"
                   class="address form-control"/>
            <label for="floatingAddress">آدرس</label>
        </div>
        <?php
        get_template_part('template-parts/states-cities');
        ?>
<!--        <div class="col-md-12 input-group">-->
<!--            <input type="file" class="form-control bg-red text-white" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">-->
<!--        </div>-->
        <div class="col-md-12">
            <label class="form-label">آپلود چک</label>
            <input file-id="<?= get_the_ID(); ?>" id="file" name="file" type="file" class="form-control file-pdf"/>
        </div>
        <input name="security" value="<?php echo wp_create_nonce("uploadingFile"); ?>" type="hidden">

        <!--	// set action name-->
        <input name="action" value="upload_file" type="hidden"/>
        <div class="col-md-12 mt-3 ">
            <button class="btn btn-addToCard w-100" type="submit">پیش پرداخت
            </button>
        </div>
    </div>
    <input type="text" value="<?= get_the_ID(); ?>" id="product_id"
           hidden>
    <input type="text" method-product-id="<?= get_the_ID(); ?>" value="قسطی" class="payment_method"
           hidden>
</form>