<?php $_wish = session()->get('wishlist'); $_wish = is_array($_wish) ? $_wish : []; ?>
<?php foreach ($items as $p): ?>
<div class="swiper-slide swiper-slide--space">
    <a href="<?= '/products/' . (int) $p['id'] . '/' . rawurlencode($p['slug']) ?>" class="product-card">
        <div class="product-image">
            <img src="<?= esc(img_url($p['image'])) ?>" alt="<?= esc($p['name']) ?>" loading="lazy">
            <div class="badge-left">
                <?php if ((int) ($p['discount_percent'] ?? 0) > 0): ?>
                <span class="discount-badge"><?= (int) $p['discount_percent'] ?>%</span>
                <?php endif; ?>
            </div>
            <div class="badge-right"></div>
            <button type="button" class="wishlist-btn <?= in_array((int) $p['id'], $_wish) ? 'active' : '' ?>" data-action="toggle" data-id="<?= (int) $p['id'] ?>" aria-label="Toggle Wishlist">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 21C12 21 3.5 16.5 3.5 9.7C3.5 6.6 5.9 4.2 8.9 4.2C10.6 4.2 12.1 5.1 13 6.4C13.9 5.1 15.4 4.2 17.1 4.2C20.1 4.2 22.5 6.6 22.5 9.7C22.5 16.5 14 21 12 21Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <?php if (empty($p['freebies']) === false): ?>
            <div class="freegift-badge">+ Barang Gratis</div>
            <?php endif; ?>
        </div>
        <div class="product-body">
            <div class="product-title"><?= esc($p['name']) ?></div>
            <div class="product-subtitle"></div>
            <div class="product-price">
                <?php if ((float) ($p['old_price'] ?? 0) > (float) ($p['price'] ?? 0)): ?>
                <div class="price-old">Rp <?= number_format($p['old_price'], 0, '.', ',') ?></div>
                <?php endif; ?>
                <div class="price-sale">Rp <?= number_format($p['price'], 0, '.', ',') ?></div>
            </div>
        </div>
    </a>
</div>
<?php endforeach; ?>
