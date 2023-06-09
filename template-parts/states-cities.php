<?php
$states_and_cities = array(
    "آذربایجان شرقی" => array("آذرشهر", "اسکو", "اهر", "بستان‌آباد", "بناب", "تبریز", "جلفا", "چاراویماق", "سراب", "شبستر", "عجب‌شیر", "کلیبر", "مراغه", "مرند", "ملکان", "میانه", "ورزقان", "هریس"),
    "آذربایجان غربی" => array("ارومیه", "اشنویه", "بوکان", "پیرانشهر", "تکاب", "چالدران", "خوی", "سردشت", "سلماس", "شاهین‌دژ", "ماکو", "مهاباد"),
    "اردبیل" => array("اردبیل", "بیله‌سوار", "پارس‌آباد", "خلخال", "کوثر", "گِرمی", "مِشگین‌شهر", "نَمین", "نیر"),
    "اصفهان" => array("آران وبیدگل", "اردستان", "اصفهان", "برخوار و میمه", "تیران وکرون", "چادگان", "خمینی‌شهر", "خوانسار", "سمیرم", "شاهین‌شهر و میمه", "شهرضا", "فریدن", "فریدون‌شهر", "فلاورجان", "کاشان", "گلپایگان", "لنجان", "مبارکه", "نائین", "نجف‌آباد", "نطنز"),
    "البرز" => array("کرج", "نظرآباد", "طالقان", "فردیس", "اشتهارد", "ساوجبلاغ", "نور", "شهر جدید هشتگرد", "کمال شهر", "هشتگرد"),
    "ایلام" => array("ایلام", "دهلران", "شیروان چرداول", "مهران", "آبدانان", "دره شهر", "ایوان", "موسیان", "ارکوازی(ملکشاهی)", "چوار"),
    "بوشهر" => array("بوشهر", "دیر", "برازجان", "جم", "دشتستان", "تنگستان", "گناوه", "دلوار", "خورموج(کوشکوییه)", "ریز"),
    "تهران" => array("تهران", "ورامین", "شهریار", "شمیرانات", "پاکدشت", "اسلامشهر", "فیروزکوه", "رباط کریم", "رودهن", "قرچک", "پردیس", "دماوند", "بومهن", "تجریش", "لواسان", "فشم", "نسیم شهر", "گلستان"),
    "چهارمحال و بختیاری" => array("شهرکرد", "بروجن", "لردگان", "فارسان", "کوهرنگ", "سامان", "شلمزار", "باباحیدر", "طاقانک", "سورشجان"),
    "خراسان جنوبی" => array("بیرجند", "درمیان", "سرایان", "فردوس", "نهبندان", "قائن", "سربیشه", "دیهوک", "اسدیه", "طبس مسینا"),
    "خراسان رضوی" => array("مشهد", "تربت حیدریه", "کاشمر", "سبزوار", "قوچان", "گناباد", "تایباد"),
    "خراسان شمالی" => array("شیروان و چرداول", "گرمه", "راز و جرگلان", "بجنورد"),
    "خوزستان" => array("اهواز", "خرمشهر", "ابادان", "شوش", "آبادان", "مسجد سلیمان", "بندر ماهشهر"),
    "زنجان" => array("زنجان", "ابهر", "خدابنده"),
    "سمنان" => array("سمنان", "دامغان", "شاهرود", "گرمسار"),
    "سیستان و بلوچستان" => array("زابل", "چابهار", "زاهدان", "ایرانشهر", "خاش", "میرجاوه"),
    "فارس" => array("شیراز", "مرودشت", "کازرون", "خرم بید", "فیروزآباد", "لارستان", "لامرد", "مهر"),
    "قزوین" => array("قزوین", "آبیک", "تاکستان"),
    "قم" => array("قم"),
    "کردستان" => array("سنندج", "بانه", "سقز", "کامیاران", "دهگلان", "دیواندره", "سروآباد"),
    "کرمان" => array("کرمان", "رفسنجان", "بافت", "سیرجان", "شهربابک", "بم", "جیرفت", "راور"),
    "کرمانشاه" => array("اسلام آباد غرب", "ثلاث باباجانی", "جوانرود", "دالاهو", "روانسر", "سرپل ذهاب", "سنقر", "صحنه", "قصرشیرین", "کرمانشاه", "کنگاور"),
    "کهگیلویه و بویراحمد" => array("بویراحمد", "بهمئی", "دنا", "کهگیلویه", "گچساران"),
    "گلستان" => array("آزادشهر", "گنبد کاووس", "مراوه تپه", "کردکوی", "کلاله", "بندرترکمن", "گمیش تپه", "رامیان"),
    "گیلان" => array("رشت", "آستارا", "آستانه اشرفیه", "املش", "بندرانزلی", "تالش", "رودبار", "رودسر", "شفت", "صومعه سرا", "طوالش", "فومن", "لاهیجان", "لنگرود", "ماسال"),
    "لرستان" => array("ازنا", "الیگودرز", "بروجرد", "پلدختر", "خرم آباد", "دورود", "دلفان", "کوهدشت"),
    "مازندران" => array("آمل", "بابل", "بابلسر", "بهشهر", "تنکابن", "جویبار", "چالوس", "رامسر", "ساری", "سوادکوه", "قائمشهر", "گلوگاه"),
    "مرکزی" => array("آشتیان", "اراک", "تفرش", "خمین", "دلیجان", "زرندیه", "ساوه", "شازند"),
    "هرمزگان" => array("ابوموسی", "بستک", "بشاگرد", "بندرعباس", "بندرلنگه", "جاسک", "حاجی‌آباد", "خمیر", "رودان", "قشم", "میناب"),
    "همدان" => array("اسدآباد", "بهار", "تویسرکان", "رزن", "کبودرآهنگ", "ملایر", "نهاوند", "همدان"),
    "یزد" => array("ابرکوه", "اردکان", "اشکذر", "بافق", "تفت", "خاتم", "صدوق", "طبس", "مهریز", "میبد", "یزد")

);

?>
<div class="col-md-6 form-floating">
    <select state-id="<?= get_the_ID(); ?>" name="state" class="form-control state-dropdown" id="state">
        <?php
        // Loop through the states and create an option for each one
        foreach ($states_and_cities as $state => $cities) {
            echo "<option value='$state'>$state</option>";
        }
        ?>
    </select>
    <label for="state">استان:</label>
</div>

<div class="col-md-6 form-floating">
    <select city-id="<?= get_the_ID(); ?>" class="form-control city-dropdown" name="city" id="city"></select>
    <label for="city">شهر:</label>
</div>


<script>
    jQuery(document).ready(function () {
// Get a reference to the state and city dropdowns
        jQuery('.add-product , .add-product-front').each(function () {
            var $form = jQuery(this);

            // Get a reference to the state and city dropdowns within the form
            var $state = $form.find('.state-dropdown');
            var $city = $form.find('.city-dropdown');

            // ...rest of the code here...
            $state.on('change', function () {
                // Get the selected state
                var state = $state.val();
                // Set the active state as an HTML attribute
                $state.attr('data-active-state', state);

                // Get the list of cities for the selected state
                var cities = <?php echo json_encode($states_and_cities); ?>[state];

                // Clear the city dropdown and add the cities for the selected state
                $city.empty();
                jQuery.each(cities, function (index, city) {
                    $city.append(jQuery('<option></option>').val(city).html(city));
                });

                // Set the default value for the city dropdown
                $city.val(cities[0]);
                // Set the active city as an HTML attribute
                $city.attr('data-active-city', cities[0]);
            });

// When the city dropdown changes, update the active city attribute
            $city.on('change', function () {
                var city = $city.val();
                $city.attr('data-active-city', city);
            });

// Trigger the change event on the state dropdown when the page loads
            $state.trigger('change');
        });

// When the state dropdown changes, update the city dropdown



    });

</script>
