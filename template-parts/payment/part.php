<?php
global $product;

//    if (is_numeric($product->get_price())) :
//        if (!$product->is_type('variable')) {
//            if ($product->get_sale_price() == true) { ?>
<!--                <span class="text-primary text-decoration-line-through me-1">-->
<!--                    --><?php //echo number_format($product->get_regular_price()); ?>
<!--                </span> --><?php //echo number_format($product->get_sale_price());
//            } else { ?>
<!--                <span class="text-primary fs-4">قیمت :-->
<!--            --><?php //echo number_format($product->get_regular_price()); ?>
<!--                </span> --><?php
//            }
//        } else {
//            echo number_format($product->get_variation_regular_price([$min_or_max = 'min'][$for_display = false])) .
//                ' تا '
//                . number_format($product->get_variation_regular_price([$min_or_max = 'max'][$for_display = false]));
//        }
//        ?>
<!---->
<!--        <span class="text-primary ms-1 fs-4">تومان</span>-->
<!--    <span class="col text-center text-lg-end p-lg-0 py-2 fs-5">این قسطی هست</span>-->
<!---->
<!--    --><?php //endif; ?>
<?php
// Define the upfront payment percentage and interest rate
$upfrontPaymentPercentage = 0.4;
$interestRate = 0.03;

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
<div class="d-flex flex-wrap g-3 align-items-center py-3 row-cols-2 row-cols-lg-3 justify-content-center justify-content-lg-start">
    <p class="d-grid align-items-center gap-1 mb-0">پیش پرداخت :
        <span class="mt-2 mt-lg-0 fs-4 badge bg-red mx-1">
        <?php echo number_format($upfrontPayment, 0); ?>
        </span>
    </p>
    <p class="d-grid align-items-center gap-1 mb-0">قسط ماهیانه :
        <span class="mt-2 mt-lg-0 fs-4 badge bg-red mx-1" >
        <?php echo number_format($monthlyPayment, 0); ?>
        </span>
    </p>
    <p class="d-grid align-items-center gap-1 mt-2 mt-lg-0 mb-0">مبلغ نهایی :
        <span class="mt-2 mt-lg-0 fs-4 badge bg-red mx-1">
        <?php echo number_format($lastAmount, 0); ?>
        </span>
    </p>
</div>


<form action="" class="add-product border p-3" data-id="<?= get_the_ID(); ?>"
      method="post" enctype="multipart/form-data">
    <div class="row g-3 mb-3">
        <div class="col-md-5 form-floating">
            <input disabled placeholder="نام" value="shayan" required id="name floatingName" type="text"
                   name="name" class="name form-control"/>
            <input type="text" value="<?= get_the_ID(); ?>" id="product_id"
                   hidden>
            <input type="text" method-product-id="<?= get_the_ID(); ?>" value="قسطی" class="payment_method"
                   hidden>
            <input type="text" price-id="<?= get_the_ID(); ?>" value="<?= $upfrontPayment; ?>" class="payment_method"
                   hidden>
            <label for="floatingName">نام مشتری</label>
        </div>
        <div class="col-md-5 form-floating">
            <input placeholder="+989123456789" required id="phone floatingPhone" type="tel" name="phone"
                   class="phone form-control"/>
            <label for="floatingPhone">تلفن</label>
        </div>
        <div class="col-md-2 form-floating">
            <input type="number" data-product-id="<?= get_the_ID(); ?>" name="number" required id="floatingNumber"
                   class="number form-control"/>
            <label class="form-label">تعداد</label>
        </div>
        <div class="col-md-12 form-floating">
            <input required id="address floatingAddress" type="text" name="address"
                   class="address form-control"/>
            <label for="floatingAddress">آدرس</label>
        </div>

        <div class="col-md-12 mt-3 ">
            <button class="btn btn-addToCard w-100" type="submit">پیش پرداخت
            </button>
        </div>
    </div>
</form>
