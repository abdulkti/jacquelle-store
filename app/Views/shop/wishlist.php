<?= view('layout/header', $data ?? []) ?>

<div class="shop-page animate-to-top" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div class="shop-head" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <h1 style="font-size:24px;font-weight:700;">Wishlist <span style="font-size:14px;color:#6b7280;font-weight:400;">(<?= count($products) ?> produk)</span></h1>
        <a href="/products" class="btn btn-outline" style="padding:8px 16px;font-size:13px;">Lihat Semua Produk</a>
    </div>

    <?php if (empty($products)): ?>
    <div class="products-empty" style="text-align:center;padding:60px 20px;">
        <div style="font-size:48px;margin-bottom:12px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" style="margin:0 auto;"><path d="M12 21C12 21 3.5 16.5 3.5 9.7C3.5 6.6 5.9 4.2 8.9 4.2C10.6 4.2 12.1 5.1 13 6.4C13.9 5.1 15.4 4.2 17.1 4.2C20.1 4.2 22.5 6.6 22.5 9.7C22.5 16.5 14 21 12 21Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <p style="color:#6b7280;font-size:15px;">Wishlist masih kosong. Ketuk ikon hati pada produk favoritmu!</p>
        <a href="/products" class="btn btn-primary" style="margin-top:16px;">Mulai Belanja</a>
    </div>
    <?php else: ?>
    <div class="products-grid">
        <?php foreach ($products as $p): ?>
        <a href="/products/<?= (int) $p['id'] ?>/<?= rawurlencode($p['slug']) ?>" class="product-card" data-wish-id="<?= (int) $p['id'] ?>">
            <div class="product-image">
                <img src="<?= esc(img_url($p['image'])) ?>" alt="<?= esc($p['name']) ?>" loading="lazy">
                <div class="badge-right">
                    <?php if ((int) ($p['discount_percent'] ?? 0) > 0): ?>
                    <span class="discount-badge"><?= (int) $p['discount_percent'] ?>%</span>
                    <?php endif; ?>
                </div>
                <button type="button" class="wishlist-btn active wish-remove" data-id="<?= (int) $p['id'] ?>" data-action="remove" aria-label="Hapus dari Wishlist">
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
                <button type="button" class="btn btn-primary wish-move-cart" data-id="<?= (int) $p['id'] ?>" style="width:100%;margin-top:10px;font-size:13px;padding:9px 12px;border:none;cursor:pointer;">Masukkan ke Keranjang</button>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?= view('layout/footer', $data ?? []) ?>
