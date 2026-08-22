<?= view('layout/header', $data ?? []) ?>

<div class="shop-page animate-to-top" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div class="shop-head" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <h1 style="font-size:24px;font-weight:700;">Keranjang Belanja <span style="font-size:14px;color:#6b7280;font-weight:400;">(<?= count($cart) ?> produk)</span></h1>
        <a href="/products" class="btn btn-outline" style="padding:8px 16px;font-size:13px;">Lanjut Belanja</a>
    </div>

    <?php if (empty($cart)): ?>
    <div class="products-empty" style="text-align:center;padding:60px 20px;">
        <div style="font-size:48px;margin-bottom:12px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" style="margin:0 auto;"><path d="M6 7H20L18.5 17H7.5L6 7ZM6 7L5 3H2" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <p style="color:#6b7280;font-size:15px;">Keranjang masih kosong. Yuk tambahkan produk favoritmu!</p>
        <a href="/products" class="btn btn-primary" style="margin-top:16px;">Mulai Belanja</a>
    </div>
    <?php else: ?>
    <div class="cart-layout" style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">
        <div class="cart-items" style="background:#fff;border:1px solid #e7eaec;border-radius:12px;overflow:hidden;">
            <?php foreach ($cart as $p): ?>
            <div class="cart-row" data-cart-key="<?= esc($p['cart_key']) ?>" style="display:flex;gap:16px;padding:16px;border-bottom:1px solid #f1f5f9;align-items:center;">
                <a href="/products/<?= (int) $p['id'] ?>/<?= rawurlencode($p['slug']) ?>" style="flex-shrink:0;">
                    <img src="<?= esc(img_url($p['image'])) ?>" alt="<?= esc($p['name']) ?>" style="width:88px;height:88px;object-fit:cover;border-radius:10px;">
                </a>
                <div style="flex:1;min-width:0;">
                    <a href="/products/<?= (int) $p['id'] ?>/<?= rawurlencode($p['slug']) ?>" style="color:inherit;text-decoration:none;">
                        <div style="font-weight:600;font-size:14px;line-height:1.4;"><?= esc($p['name']) ?></div>
                    </a>
                    <?php if (! empty($p['variant'])): ?>
                    <div style="font-size:13px;color:#64748b;margin-top:2px;">Varian: <?= esc($p['variant']) ?></div>
                    <?php endif; ?>
                    <div style="font-size:15px;font-weight:700;color:#121d3d;margin-top:6px;" class="cart-line-total" data-amount="<?= (int) ($p['price'] * $p['qty']) ?>">Rp <?= number_format($p['price'] * $p['qty'], 0, '.', ',') ?></div>
                    <?php if ((int) $p['old_price'] > (int) $p['price']): ?>
                    <div style="color:#94a3b8;font-size:12px;text-decoration:line-through;margin-top:2px;">Rp <?= number_format($p['old_price'], 0, '.', ',') ?></div>
                    <?php endif; ?>
                </div>
                <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                    <div class="qty-stepper" style="display:flex;align-items:center;border:1px solid #d8dee6;border-radius:8px;overflow:hidden;">
                        <button type="button" class="qty-minus" data-key="<?= esc($p['cart_key']) ?>" style="border:none;background:#f8fafc;padding:8px 12px;font-size:16px;cursor:pointer;">−</button>
                        <span class="qty-val" style="min-width:32px;text-align:center;font-weight:600;"><?= (int) $p['qty'] ?></span>
                        <button type="button" class="qty-plus" data-key="<?= esc($p['cart_key']) ?>" style="border:none;background:#f8fafc;padding:8px 12px;font-size:16px;cursor:pointer;">+</button>
                    </div>
                    <button type="button" class="cart-remove" data-key="<?= esc($p['cart_key']) ?>" style="border:none;background:none;color:#b91c1c;cursor:pointer;font-size:13px;font-weight:600;padding:8px;">Hapus</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary" style="background:#fff;border:1px solid #e7eaec;border-radius:12px;padding:20px;position:sticky;top:90px;">
            <h2 style="font-size:18px;font-weight:700;margin-bottom:16px;">Ringkasan Belanja</h2>
            <div style="display:flex;justify-content:space-between;font-size:14px;color:#475569;margin-bottom:8px;">
                <span>Subtotal</span><span id="sum-subtotal">Rp <?= number_format($subtotal, 0, '.', ',') ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:14px;color:#475569;margin-bottom:8px;">
                <span>Ongkos Kirim</span><span>Rp <?= number_format($shipping, 0, '.', ',') ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:17px;font-weight:700;color:#121d3d;border-top:1px solid #f1f5f9;padding-top:14px;margin-top:6px;">
                <span>Total</span><span id="sum-total">Rp <?= number_format($total, 0, '.', ',') ?></span>
            </div>
            <a href="/cart/checkout" class="btn btn-primary" style="display:block;text-align:center;margin-top:18px;padding:13px;font-size:15px;font-weight:700;">Checkout</a>
            <a href="/products" style="display:block;text-align:center;margin-top:10px;font-size:13px;color:#64748b;">Lanjut belanja</a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= view('layout/footer', $data ?? []) ?>
