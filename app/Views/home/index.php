<?= view('layout/header', $data ?? []) ?>

<div class="p-container">
    <!-- HERO -->
    <section class="hero-section animate-fade-in">
        <div class="swiper hero-swiper" style="--swiper-pagination-color:black;--swiper-navigation-color:rgba(255, 255, 255, 0.4);--swiper-navigation-sides-offset:8px;--swiper-navigation-size:24px;">
            <div class="swiper-wrapper">
                <?php foreach ($heroBanners as $banner): ?>
                <div class="swiper-slide">
                    <a href="<?= esc($banner['link']) ?>" class="hero-slide-link">
                        <div class="hero-image-wrap">
                            <img class="hero-image" src="<?= base_url($banner['image']) ?>" alt="Banner Jacquelle" fetchpriority="high">
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- NEW PRODUCTS -->
    <section class="rich-section" style="--animation-order:0;">
        <div class="rich-inner animate-to-top">
            <h2 class="section-heading">NEW PRODUCTS</h2>
        </div>
    </section>

    <!-- NEW PRODUCTS CAROUSEL -->
    <section class="product-section" style="--animation-order:1;">
        <div class="p-swiper animate-to-top">
            <span class="swiper-arrow swiper-arrow-prev" id="newPrev">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M15 6L9 12L15 18" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="swiper product-swiper">
                <div class="swiper-wrapper">
                    <?php $items = $products; ?>
                    <?php require __DIR__ . '/_product_card.php'; ?>
                </div>
            </div>
            <span class="swiper-arrow swiper-arrow-next" id="newNext">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M9 6L15 12L9 18" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        </div>
    </section>

    <!-- VIDEO SLIDESHOW -->
    <section class="video-section animate-to-top" style="--animation-order:4;margin-bottom:12px;">
        <div class="swiper video-swiper">
            <div class="swiper-wrapper">
                <?php for ($i = 0; $i < 20; $i++): ?>
                <div class="swiper-slide">
                    <div class="video-card">
                        <video class="video-el" muted loop playsinline preload="metadata" src="<?= base_url($slides[$i % count($slides)]) ?>"></video>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- BANNER 1 -->
    <section class="banner-section animate-to-top">
        <a href="/categories/41446/toy-story-5" class="banner-slide-link">
            <img class="banner-slide-img" src="<?= base_url('assets/images/banner_toy_story.webp') ?>" alt="Banner Toy Story 5">
        </a>
    </section>

    <!-- SECTION 2 CAROUSEL (Toy Story 5) -->
    <section class="product-section product-section--wide" style="--animation-order:5;">
        <div class="p-swiper animate-to-top">
            <span class="swiper-arrow swiper-arrow-prev" id="sec2Prev">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M15 6L9 12L15 18" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="swiper product-swiper-2">
                <div class="swiper-wrapper">
                    <?php $items = $section2; ?>
                    <?php require __DIR__ . '/_product_card.php'; ?>
                </div>
            </div>
            <span class="swiper-arrow swiper-arrow-next" id="sec2Next">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M9 6L15 12L9 18" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        </div>
    </section>

    <!-- BANNER 2 -->
    <section class="banner-section animate-to-top">
        <a href="/categories" class="banner-slide-link">
            <img class="banner-slide-img" src="<?= base_url('assets/images/banner_disney.webp') ?>" alt="Banner Disney Edition">
        </a>
    </section>

    <!-- SECTION 3 CAROUSEL (Disney editions) -->
    <section class="product-section" style="--animation-order:6;">
        <div class="p-swiper animate-to-top">
            <span class="swiper-arrow swiper-arrow-prev" id="sec3Prev">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M15 6L9 12L15 18" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="swiper product-swiper-3">
                <div class="swiper-wrapper">
                    <?php $items = $section3; ?>
                    <?php require __DIR__ . '/_product_card.php'; ?>
                </div>
            </div>
            <span class="swiper-arrow swiper-arrow-next" id="sec3Next">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M9 6L15 12L9 18" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        </div>
    </section>

    <!-- BANNER 3 -->
    <section class="banner-section animate-to-top">
        <a href="/categories" class="banner-slide-link">
            <img class="banner-slide-img" src="<?= base_url('assets/images/banner_makeup.webp') ?>" alt="Banner Makeup">
        </a>
    </section>

    <!-- SECTION 4 CAROUSEL (General products) -->
    <section class="product-section" style="--animation-order:7;">
        <div class="p-swiper animate-to-top">
            <span class="swiper-arrow swiper-arrow-prev" id="sec4Prev">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M15 6L9 12L15 18" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="swiper product-swiper-4">
                <div class="swiper-wrapper">
                    <?php $items = $section4; ?>
                    <?php require __DIR__ . '/_product_card.php'; ?>
                </div>
            </div>
            <span class="swiper-arrow swiper-arrow-next" id="sec4Next">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M9 6L15 12L9 18" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        </div>
    </section>
</div>

<?= view('layout/footer', $data ?? []) ?>
