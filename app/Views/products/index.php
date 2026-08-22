<?= view('layout/header', $data ?? []) ?>

<?php
$_wish = session()->get('wishlist');
$_wish = is_array($_wish) ? $_wish : [];
$price = isset($price) ? $price : '';
$stock = isset($stock) ? $stock : '';
$type  = isset($type) ? $type : 'all';
$catId = isset($categoryId) ? (int) $categoryId : null;

$featuredCats = [
    35148 => ['New Arrivals', 'new-arrivals'],
    35149 => ['Best Seller', 'best-seller'],
    35150 => ['Gift For You', 'gift-for-you'],
    36893 => ['Zootopia', 'zootopia'],
    36413 => ['Quby', 'quby'],
];
$restCats = [];
foreach (($categories ?? []) as $c) {
    $id = (int) $c['id'];
    if (! isset($featuredCats[$id])) {
        $restCats[] = ['id' => $id, 'name' => $c['name'], 'slug' => $c['slug']];
    }
}
$typeUrl = function ($t) {
    $map = ['featured' => '/featured-products', 'discount' => '/discounts', 'bundle' => '/bundles'];
    return $map[$t] ?? '/products';
};
?>

<div class="products-page">
    <div class="products-layout">
        <aside class="products-sidebar" id="productsSidebar">
            <div class="sidebar-head">
                <h3>Filter</h3>
                <button type="button" class="icon-btn sidebar-close" id="sidebarClose" aria-label="Tutup Filter">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M6 6L18 18M18 6L6 18" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
            </div>

            <div class="filter-group">
                <div class="filter-title">Kategori</div>
                <?php foreach ($featuredCats as $fid => $fc): ?>
                <a href="<?= '/categories/' . $fid . '/' . $fc[1] ?>" class="filter-link <?= $catId === $fid ? 'active' : '' ?>"><?= esc($fc[0]) ?></a>
                <?php endforeach; ?>
                <?php if ($restCats): ?>
                <div class="filter-more-wrap">
                    <button type="button" class="filter-more-btn" id="catMoreBtn">Lihat lainnya
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M6 9L12 15L18 9" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <div class="filter-more-list" id="catMoreList">
                        <?php foreach ($restCats as $rc): ?>
                        <a href="<?= '/categories/' . (int) $rc['id'] . '/' . rawurlencode($rc['slug']) ?>" class="filter-link <?= $catId === (int) $rc['id'] ? 'active' : '' ?>"><?= esc($rc['name']) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="filter-group">
                <div class="filter-title">Tipe Produk</div>
                <a href="/products" class="filter-link <?= $type === 'all' ? 'active' : '' ?>">Semua Produk</a>
                <a href="/featured-products" class="filter-link <?= $type === 'featured' ? 'active' : '' ?>">Produk Unggulan</a>
                <a href="/discounts" class="filter-link <?= $type === 'discount' ? 'active' : '' ?>">Diskon</a>
                <a href="/bundles" class="filter-link <?= $type === 'bundle' ? 'active' : '' ?>">Produk Bundle</a>
            </div>

            <form method="get" action="<?= esc(current_url()) ?>" class="filter-form">
                <?php if (! empty($q)): ?><input type="hidden" name="q" value="<?= esc($q) ?>"><?php endif; ?>

                <div class="filter-group">
                    <div class="filter-title">Ketersediaan</div>
                    <label class="filter-option">
                        <input type="radio" name="stock" value="" <?= $stock === '' ? 'checked' : '' ?>>
                        <span>Semua</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="stock" value="available" <?= $stock === 'available' ? 'checked' : '' ?>>
                        <span>Ada Stok</span>
                    </label>
                </div>

                <div class="filter-group">
                    <div class="filter-title">Harga</div>
                    <label class="filter-option">
                        <input type="radio" name="price" value="" <?= $price === '' ? 'checked' : '' ?>>
                        <span>Semua Harga</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="price" value="below-72000" <?= $price === 'below-72000' ? 'checked' : '' ?>>
                        <span>Di bawah Rp 72,000</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="price" value="72000-140000" <?= $price === '72000-140000' ? 'checked' : '' ?>>
                        <span>Rp 72,000 - Rp 140,000</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="price" value="140000-210000" <?= $price === '140000-210000' ? 'checked' : '' ?>>
                        <span>Rp 140,000 - Rp 210,000</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="price" value="210000-999999999" <?= $price === '210000-999999999' ? 'checked' : '' ?>>
                        <span>Rp 210,000 +</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block filter-submit">Filter</button>
            </form>
        </aside>

        <div class="products-main">
            <div class="products-head animate-to-top">
                <div>
                    <h1><?= esc($heading ?? 'All Products') ?></h1>
                    <?php if (! empty($q)): ?>
                    <p>Hasil pencarian untuk "<?= esc($q) ?>"</p>
                    <?php else: ?>
                    <p><?= count($products) ?> produk</p>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-outline products-filter-btn" id="productsFilterBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M20 8.18V3a1 1 0 0 0-2 0v5.18a3 3 0 0 0 0 5.64V21a1 1 0 0 0 2 0v-7.18a3 3 0 0 0 0-5.64M19 12a1 1 0 1 1 1-1 1 1 0 0 1-1 1m-6 2.18V3a1 1 0 0 0-2 0v11.18a3 3 0 0 0 0 5.64V21a1 1 0 0 0 2 0v-1.18a3 3 0 0 0 0-5.64M12 18a1 1 0 1 1 1-1 1 1 0 0 1-1 1M6 6.18V3a1 1 0 0 0-2 0v3.18a3 3 0 0 0 0 5.64V21a1 1 0 0 0 2 0v-9.18a3 3 0 0 0 0-5.64M5 10a1 1 0 1 1 1-1 1 1 0 0 1-1 1" stroke="currentcolor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    Filter
                </button>
            </div>

            <?php if (! empty($categoryBanner)): ?>
            <section class="banner-section category-banner">
                <img class="banner-slide-img" src="<?= base_url($categoryBanner['image']) ?>" alt="<?= esc($categoryBanner['alt']) ?>">
            </section>
            <?php endif; ?>

            <?php if (empty($products)): ?>
                <div class="products-empty">
                    <p>Tidak ada produk ditemukan.</p>
                    <a href="<?= esc(current_url()) ?>" class="btn btn-primary">Lihat Semua Produk</a>
                </div>
            <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($products as $p): ?>
                    <a href="<?= '/products/' . (int) $p['id'] . '/' . rawurlencode($p['slug']) ?>" class="product-card">
                        <div class="product-image">
                            <img src="<?= esc(img_url($p['image'])) ?>" alt="<?= esc($p['name']) ?>" loading="lazy">
                            <div class="badge-right">
                                <?php if ((int) ($p['discount_percent'] ?? 0) > 0): ?>
                                <span class="discount-badge"><?= (int) $p['discount_percent'] ?>%</span>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="wishlist-btn <?= in_array((int) $p['id'], $_wish) ? 'active' : '' ?>" data-action="toggle" data-id="<?= (int) $p['id'] ?>" aria-label="Toggle Wishlist">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 21C12 21 3.5 16.5 3.5 9.7C3.5 6.6 5.9 4.2 8.9 4.2C10.6 4.2 12.1 5.1 13 6.4C13.9 5.1 15.4 4.2 17.1 4.2C20.1 4.2 22.5 6.6 22.5 9.7C22.5 16.5 14 21 12 21Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                        <div class="product-body">
                            <div class="product-title"><?= esc($p['name']) ?></div>
                            <div class="product-price">
                                <?php if ((float) ($p['old_price'] ?? 0) > (float) ($p['price'] ?? 0)): ?>
                                <div class="price-old">Rp <?= number_format($p['old_price'], 0, '.', ',') ?></div>
                                <?php endif; ?>
                                <div class="price-sale">Rp <?= number_format($p['price'], 0, '.', ',') ?></div>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<?= view('layout/footer', $data ?? []) ?>
