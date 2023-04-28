<section>
    <div class="swiper shop_swiper bg-red">

        <div class="swiper-wrapper">
            <?php while (have_rows('slider-home')):
                the_row(); ?>
                <div class="swiper-slide hero_slider"
                     style="background-image: url('<?= get_sub_field('hero-slide')['url']; ?>')">
                </div>
            <?php
            endwhile; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>