<?php

global $product;

if (is_numeric($product->get_price())) :
    if (!$product->is_type('variable')) {
        if ($product->get_sale_price() == true) { ?>
            <span class="text-primary text-decoration-line-through me-1">
                    <?php echo number_format($product->get_regular_price()); ?>
                </span> <?php echo number_format($product->get_sale_price());
        } else {
            echo number_format($product->get_regular_price());
        }
    } else {
        echo number_format($product->get_variation_regular_price([$min_or_max = 'min'][$for_display = false])) .
            ' تا '
            . number_format($product->get_variation_regular_price([$min_or_max = 'max'][$for_display = false]));
    }
    ?>

    <span class="text-primary ms-1">تومان</span>
    این قسطی هست
<?php endif; ?>

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

?>
<h3>پیش پرداخت<span class="badge bg-red">
        <?php echo number_format($upfrontPayment, 0); ?>
    </span>
</h3>
<h3>قسط ماهیانه<span class="badge bg-red">
        <?php echo number_format($monthlyPayment, 0); ?>
    </span>
</h3>
<h3>مبلغ کل پرداختی<span class="badge bg-red">
        <?php echo number_format($totalAmountPaid, 0); ?>
    </span>
</h3>

<form action="" class="add-product" data-id="<?= get_the_ID(); ?>"
      method="post" enctype="multipart/form-data">
    <div class="row g-3 mb-3">
        <div class="col-md-6 form-floating">
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
        <div class="col-md-6 form-floating">
            <input placeholder="+989123456789" required id="phone floatingInput" type="tel" name="phone"
                   class="phone form-control"/>
            <label for="floatingInput">تلفن</label>
        </div>
        <div class="col-md-6 ">
            <label class="form-label">آدرس</label>
            <input required id="address" type="text" name="address"
                   class="address form-control"/>
        </div>
        <div class="col-md-6">
            <label class="form-label">تعداد</label>
            <input type="number" data-product-id="<?= get_the_ID(); ?>" name="number" required
                   class="number form-control"/>
        </div>
        <div class="col-md-12 mt-3 ">
            <button class="btn btn-primary w-100" type="submit">سفارش
            </button>
        </div>
    </div>
</form>
