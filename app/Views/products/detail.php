<?= view('layout/header', $data ?? []) ?>

<div class="product-detail animate-to-top">
    <div class="detail-grid">
        <div class="detail-image">
            <div class="detail-gallery">
                <img id="mainDetailImg" src="<?= esc(img_url($product['image'])) ?>" alt="<?= esc($product['name']) ?>">
            </div>
            <?php if (! empty($product['gallery']) && count($product['gallery']) > 1): ?>
            <div class="detail-thumbs">
                <?php $mainImg = img_url($product['image']); ?>
                <button type="button" class="thumb active" data-src="<?= esc($mainImg) ?>" aria-label="Gambar utama">
                    <img src="<?= esc($mainImg) ?>" alt="" loading="lazy">
                </button>
                <?php foreach ($product['gallery'] as $gi => $g): ?>
                <button type="button" class="thumb" data-src="<?= esc(img_url($g)) ?>" aria-label="Gambar <?= $gi + 1 ?>">
                    <img src="<?= esc(img_url($g)) ?>" alt="" loading="lazy">
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="detail-info">
            <?php if (! empty($categories)): ?>
            <div class="detail-labels">
                <?php foreach ($categories as $c): ?>
                <a class="detail-chip" href="<?= '/categories/' . (int) $c['id'] . '/' . rawurlencode($c['slug']) ?>"><?= esc($c['name']) ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <h1><?= esc($product['name']) ?></h1>

            <div class="detail-price">
                <div class="detail-price-left">
                    <?php
                    $_vlist = $product['variants'] ?? [];
                    $_first = is_array($_vlist) && isset($_vlist[0]) && is_array($_vlist[0]) ? $_vlist[0] : [];
                    $_shown  = (int) (($_first['price'] ?? null) ?: $product['price']);
                    $_shownOld = (int) (($_first['old_price'] ?? null) ?: ($product['old_price'] ?? 0));
                    ?>
                    <span class="price-sale" data-var-price="<?= esc($_shown) ?>">Rp <?= number_format($_shown, 0, '.', ',') ?></span>
                    <?php if ($_shownOld > $_shown): ?>
                    <span class="price-old" data-var-oldprice="<?= esc($_shownOld) ?>">Rp <?= number_format($_shownOld, 0, '.', ',') ?></span>
                    <?php endif; ?>
                </div>
                <?php $_wish = session()->get('wishlist'); $_wish = is_array($_wish) ? $_wish : []; ?>
                <button type="button" class="wishlist-btn detail-wishlist <?= in_array((int) $product['id'], $_wish) ? 'active' : '' ?>" data-action="toggle" data-id="<?= (int) $product['id'] ?>" aria-label="Wishlist">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M4.45067 13.9082L11.4033 20.4395C11.6428 20.6644 11.7625 20.7769 11.9037 20.8046C11.9673 20.8171 12.0327 20.8171 12.0963 20.8046C12.2375 20.7769 12.3572 20.6644 12.5967 20.4395L19.5493 13.9082C21.5055 12.0706 21.743 9.0466 20.0978 6.92607L19.7885 6.52734C17.8203 3.99058 13.8696 4.41601 12.4867 7.31365C12.2913 7.72296 11.7087 7.72296 11.5133 7.31365C10.1304 4.41601 6.17972 3.99058 4.21154 6.52735L3.90219 6.92607C2.25695 9.0466 2.4945 12.0706 4.45067 13.9082Z" stroke="currentcolor"></path></svg>
                </button>
            </div>

            <?php if (! empty($product['variants'])): ?>
            <div class="detail-variations">
                <div class="detail-variations-title"><?= esc($product['variant_title'] ?? 'Variant') ?></div>
                <div class="detail-variations-list">
                    <?php foreach ($product['variants'] as $vi => $v): ?>
                    <button type="button" class="detail-swatch <?= $vi === 0 ? 'active' : '' ?>" data-src="<?= esc(img_url($v['image'])) ?>" data-name="<?= esc($v['name']) ?>" data-price="<?= (int) ($v['price'] ?: $product['price']) ?>" data-oldprice="<?= (int) ($v['old_price'] ?: $product['old_price'] ?? 0) ?>">
                        <img src="<?= esc(img_url($v['image'])) ?>" alt="<?= esc($v['name']) ?>" loading="lazy">
                        <span><?= esc($v['name']) ?></span>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="detail-divider"></div>
            <?php endif; ?>

            <div class="qty-stepper">
                <button type="button" onclick="var i=document.getElementById('qtyInput');i.value=Math.max(1,parseInt(i.value,10)-1)" aria-label="Kurangi jumlah">−</button>
                <input type="number" id="qtyInput" value="1" min="1" aria-label="Jumlah">
                <button type="button" onclick="var i=document.getElementById('qtyInput');i.value=parseInt(i.value,10)+1" aria-label="Tambah jumlah">+</button>
            </div>

            <div class="detail-buttons">
                <button type="button" class="add-cart-btn" data-id="<?= (int) $product['id'] ?>">Tambah Ke Keranjang</button>
                <button type="button" class="buy-now-btn" data-id="<?= (int) $product['id'] ?>">Beli Sekarang</button>
            </div>

            <?php if (! empty($product['description'])): ?>
            <div class="detail-desc"><?= $product['description'] ?></div>
            <?php endif; ?>

            <div class="detail-shipping">
                <div class="detail-shipping-row"><span>Pengiriman</span><span>Dihitung saat checkout</span></div>
                <div class="detail-shipping-row"><span>Status</span><span>Tersedia</span></div>
            </div>

            <a class="detail-chat" href="https://wa.me/6281234567890" target="_blank" rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M16.6 14c-.2-.1-1.5-.7-1.7-.8s-.4-.1-.6.1s-.6.8-.8 1c-.1.2-.3.2-.5.1c-.7-.3-1.4-.7-2-1.2c-.5-.5-1-1.1-1.4-1.7c-.1-.2 0-.4.1-.5s.2-.3.4-.4c.1-.1.2-.3.2-.4c.1-.1.1-.3 0-.4S9.7 8.5 9.5 8c-.1-.7-.3-.7-.5-.7h-.5c-.2 0-.5.2-.6.3Q7 8.5 7 9.7c.1.9.4 1.8 1 2.6c1.1 1.6 2.5 2.9 4.2 3.7c.5.2.9.4 1.4.5c.5.2 1 .2 1.6.1c.7-.1 1.3-.6 1.7-1.2c.2-.4.2-.8.1-1.2zm2.5-9.1C15.2 1 8.9 1 5 4.9c-3.2 3.2-3.8 8.1-1.6 12L2 22l5.3-1.4c1.5.8 3.1 1.2 4.7 1.2c5.5 0 9.9-4.4 9.9-9.9c.1-2.6-1-5.1-2.8-7m-2.7 14c-1.3.8-2.8 1.3-4.4 1.3c-1.5 0-2.9-.4-4.2-1.1l-.3-.2l-3.1.8l.8-3l-.2-.3c-2.4-4-1.2-9 2.7-11.5S16.6 3.7 19 7.5c2.4 3.9 1.3 9-2.6 11.4"/></svg>
                Pesan ke Jacquelle?
            </a>
        </div>
    </div>

    <?php if (! empty($related)): ?>
    <div class="related-section">
        <h2 class="section-heading">Produk Lainnya</h2>
        <div class="products-grid">
            <?php foreach ($related as $r): ?>
            <a href="<?= '/products/' . (int) $r['id'] . '/' . rawurlencode($r['slug']) ?>" class="product-card">
                <div class="product-image">
                    <img src="<?= esc(img_url($r['image'])) ?>" alt="<?= esc($r['name']) ?>" loading="lazy">
                    <div class="badge-right">
                        <?php if ((int) ($r['discount_percent'] ?? 0) > 0): ?>
                        <span class="discount-badge"><?= (int) $r['discount_percent'] ?>%</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="product-body">
                    <div class="product-title"><?= esc($r['name']) ?></div>
                    <div class="product-price">
                        <?php if ((float) ($r['old_price'] ?? 0) > (float) ($r['price'] ?? 0)): ?>
                        <div class="price-old">Rp <?= number_format($r['old_price'], 0, '.', ',') ?></div>
                        <?php endif; ?>
                        <div class="price-sale">Rp <?= number_format($r['price'], 0, '.', ',') ?></div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
(function () {
    try {
        var product = {
            id: <?= (int) $product['id'] ?>,
            name: <?= json_encode($product['name']) ?>,
            slug: <?= json_encode($product['slug']) ?>,
            image: <?= json_encode(img_url($product['image'])) ?>,
            price: <?= (int) ($product['price'] ?? 0) ?>,
            oldPrice: <?= (int) ($product['old_price'] ?? 0) ?>
        };
        var arr = JSON.parse(localStorage.getItem('jacquelle_recent_viewed') || '[]');
        arr = arr.filter(function (p) { return p.id !== product.id; });
        arr.unshift(product);
        if (arr.length > 6) arr = arr.slice(0, 6);
        localStorage.setItem('jacquelle_recent_viewed', JSON.stringify(arr));
    } catch (e) {}
})();
</script>

<?= view('layout/footer', $data ?? []) ?>
