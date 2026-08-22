<?= view('layout/header', $data ?? []) ?>

<div class="shop-page animate-to-top" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div class="shop-head" style="margin-bottom:20px;">
        <h1 style="font-size:24px;font-weight:700;">Checkout</h1>
        <p style="color:#6b7280;font-size:13px;margin-top:4px;">Lengkapi data pengiriman untuk menyelesaikan pesanan.</p>
    </div>

    <?php if (! empty($errors)): ?>
    <div style="background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;">
        <?php foreach ($errors as $e): ?><div>• <?= esc(is_array($e) ? implode(', ', $e) : $e) ?></div><?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">
        <form action="/cart/checkout" method="post" style="background:#fff;border:1px solid #e7eaec;border-radius:12px;padding:24px;">
            <h2 style="font-size:16px;font-weight:700;margin-bottom:16px;">Data Pengiriman</h2>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Nama Lengkap *</label>
                    <input type="text" name="name" required value="<?= esc(old('name') ?: session()->get('name')) ?>" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">No. WhatsApp *</label>
                    <input type="text" name="phone" required value="<?= esc(old('phone') ?: session()->get('phone')) ?>" placeholder="08xxxxxxxxxx" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
                </div>
            </div>
            <div style="margin-top:14px;">
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Alamat Lengkap *</label>
                <textarea name="address" required rows="3" placeholder="Nama jalan, No. rumah, RT/RW, kelurahan, kecamatan, kota, provinsi, kode pos" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;"><?= esc(old('address')) ?></textarea>
            </div>
            <div style="margin-top:14px;">
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Metode Pembayaran</label>
                <select name="payment_method" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
                    <option value="transfer">Transfer Bank</option>
                    <option value="cod">COD</option>
                </select>
            </div>
            <div style="margin-top:14px;">
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Catatan (opsional)</label>
                <textarea name="notes" rows="2" placeholder="Catatan untuk penjual..." style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;"><?= esc(old('notes')) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top:20px;padding:13px 28px;font-size:15px;font-weight:700;border:none;cursor:pointer;">Buat Pesanan</button>
        </form>

        <div style="background:#fff;border:1px solid #e7eaec;border-radius:12px;padding:20px;position:sticky;top:90px;">
            <h2 style="font-size:16px;font-weight:700;margin-bottom:12px;">Ringkasan Pesanan</h2>
            <?php foreach ($cart as $p): ?>
            <div style="display:flex;gap:10px;margin-bottom:12px;align-items:center;">
                <img src="<?= esc(img_url($p['image'])) ?>" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= esc($p['name']) ?></div>
                    <?php if (! empty($p['variant'])): ?>
                    <div style="font-size:11px;color:#64748b;">Varian: <?= esc($p['variant']) ?></div>
                    <?php endif; ?>
                    <div style="font-size:12px;color:#64748b;"><?= (int) $p['qty'] ?> × Rp <?= number_format($p['price'], 0, '.', ',') ?></div>
                </div>
                <div style="font-size:13px;font-weight:700;">Rp <?= number_format($p['price'] * $p['qty'], 0, '.', ',') ?></div>
            </div>
            <?php endforeach; ?>
            <div style="display:flex;justify-content:space-between;font-size:14px;color:#475569;border-top:1px solid #f1f5f9;padding-top:12px;margin-top:6px;">
                <span>Subtotal</span><span>Rp <?= number_format($subtotal, 0, '.', ',') ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:14px;color:#475569;margin-top:6px;">
                <span>Ongkos Kirim</span><span>Rp <?= number_format($shipping, 0, '.', ',') ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:17px;font-weight:700;color:#121d3d;border-top:1px solid #f1f5f9;padding-top:12px;margin-top:8px;">
                <span>Total</span><span>Rp <?= number_format($total, 0, '.', ',') ?></span>
            </div>
        </div>
    </div>
</div>

<?= view('layout/footer', $data ?? []) ?>
