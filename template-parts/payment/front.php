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
?>

<form action="" class="add-product-front border p-3" data-form-id="<?= get_the_ID(); ?>" data-id="front-<?= get_the_ID(); ?>"
      id="form-<?= get_the_ID(); ?>"
      method="post" enctype="multipart/form-data">
    <div class="row g-3 mb-3 row-cols-lg-3 justify-content-center">
        <div class="form-floating">
            <!--        First Name        -->
            <input disabled
                   placeholder="نام"
                   value="<?php echo $first_name; ?>"
                   firstName-id="<?= get_the_ID(); ?>"
                   required id="name-front-<?= get_the_ID(); ?>"
                   type="text"
                   name="account_first_name"
                   class="name form-control"/>
            <label for="name-front">نام</label>
        </div>
        <div class="form-floating">
            <!--        Last Name        -->
            <input disabled
                   placeholder="نام خانوادگی"
                   value="<?php echo $last_name; ?>"
                   lastName-id="<?= get_the_ID(); ?>"
                   required
                   id="lastname-front-<?= get_the_ID(); ?>"
                   type="text"
                   name="account_last_name"
                   class="name form-control"/>
            <label for="lastname-front">نام خانوادگی</label>
        </div>
        <div class="form-floating">
            <input placeholder="+989123456789"
                <?= $mobile_number ? 'disabled' : '' ?>
                   value="<?php echo $mobile_number; ?>"
                   phone-id="<?= get_the_ID(); ?>"
                   required
                   id="phone-front-<?= get_the_ID(); ?>"
                   type="tel"
                   name="phone"
                   class="phone form-control"/>
            <label for="phone-front">تلفن</label>
        </div>
        <div class="form-floating">
            <input placeholder="123456789"
                <?= $user_identity ? 'disabled' : '' ?>
                   value="<?php echo $user_identity ?: ''; ?>"
                   user-id="<?= get_the_ID(); ?>"
                   id="floatingID-<?= get_the_ID(); ?>"
                   type="text"
                   name="user_identity"
                   class="user_identity form-control"/>
            <label for="floatingID">شماره شناسنامه</label>
        </div>
        <div class="form-floating">
            <input placeholder="123456789"
                <?= $user_code ? 'disabled' : '' ?>
                   value="<?php echo $user_code ?: ''; ?>"
                   user-code="<?= get_the_ID(); ?>"
                   id="floatingCode-<?= get_the_ID(); ?>"
                   type="text"
                   name="user_code"
                   class="user_code form-control"/>
            <label for="floatingCode">کد ملی</label>
        </div>
        <div class="form-floating">
            <input class="form-control" type="number" data-product-id="<?= get_the_ID(); ?>" id="counter" value="1"
                   min="1">
            <label for="counter">تعداد</label>
        </div>
    </div>
    <div class="form-floating">
        <input required
               id="address floatingAddress"
               address-id="<?= get_the_ID(); ?>"
               type="text"
               value="<?= $billing_address_1 ?: ''; ?>"
               name="address"
               class="address form-control"/>
        <label for="floatingAddress">آدرس</label>
    </div>
    <div class="row g-3 mt-1">
        <?php
        get_template_part('template-parts/states-cities');
        ?>
    </div>
    <div class="col-12 mt-3">
        <?php if (is_user_logged_in()) { ?>
            <button class="btn btn-addToCard w-100" type="submit">ثبت سفارش</button>
        <?php } else {?>
            <a type="button" class="btn btn-addToCard w-100" data-bs-toggle="modal" data-bs-target="#loginModal"
               href="#">
                ورود و ثبت سفارش
            </a>
        <?php } ?>
    </div>
    <input type="text" value="<?= get_the_ID(); ?>" id="product_id"
           hidden>
    <input type="text" method-product-id="<?= get_the_ID(); ?>" value="نقدی" class="payment_method"
           hidden>
</form>
