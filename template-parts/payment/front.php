<?php
global $product;

//if (is_numeric($product->get_price())) :
//    if (!$product->is_type('variable')) {
//        if ($product->get_sale_price() == true) { ?>
<!--            <span class="text-primary text-decoration-line-through me-1">-->
<!--                    --><?php //echo number_format($product->get_regular_price()); ?>
<!--                </span> --><?php //echo number_format($product->get_sale_price());
//        } else { ?>
<!--            <span class="text-primary fs-4">قیمت :-->
<!--            --><?php //echo number_format($product->get_regular_price()); ?>
<!--                </span> --><?php
//        }
//    } else {
//        echo number_format($product->get_variation_regular_price([$min_or_max = 'min'][$for_display = false])) .
//            ' تا '
//            . number_format($product->get_variation_regular_price([$min_or_max = 'max'][$for_display = false]));
//    }
//    ?>
<!---->
<!--    <span class="text-primary ms-1">تومان</span>-->
<?php //endif; ?>

<form action="" class="add-product border p-3" data-id="<?= get_the_ID(); ?>"
      method="post" enctype="multipart/form-data">
    <div class="row g-3 mb-3">
        <div class="col-md-5 form-floating">
            <input disabled value="shayan" required id="name" type="text"
                   name="name" class="name form-control"/>
            <input type="text" value="<?= get_the_ID(); ?>" id="product_id"
                   hidden>
            <input type="text" method-product-id="<?= get_the_ID(); ?>" value="نقدی" class="payment_method"
                   hidden>
            <input type="text" price-id="<?= get_the_ID(); ?>" value="<?php echo number_format($product->get_regular_price()); ?>" class="payment_method"
                   hidden>
            <label class="floatingName">نام مشتری</label>
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
            <button class="btn btn-addToCard w-100" type="submit">پرداخت
            </button>
        </div>
    </div>
</form>
