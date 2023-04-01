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
<?php endif; ?>

<form action="" class="add-product" data-id="<?= get_the_ID(); ?>"
      method="post" enctype="multipart/form-data">
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label">نام مشتری</label>
            <input disabled value="shayan" required id="name" type="text"
                   name="name" class="name form-control"/>
            <input type="text" value="<?= get_the_ID(); ?>" id="product_id"
                   hidden>
            <input type="text" method-product-id="<?= get_the_ID(); ?>" value="نقدی" class="payment_method"
                   hidden>
            <input type="text" price-id="<?= get_the_ID(); ?>" value="<?php echo number_format($product->get_regular_price()); ?>" class="payment_method"
                   hidden>
        </div>
        <div class="col-md-6">
            <label class="form-label">تلفن</label>
            <input required id="phone" type="tel" name="phone"
                   class="phone form-control"/>
        </div>
        <div class="col-md-6">
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
            <button class="btn btn-primary w-100" type="submit">پرداخت
            </button>
        </div>
    </div>
</form>
