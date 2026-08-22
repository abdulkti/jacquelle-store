<?= view('layout/header', $data ?? []) ?>

<div class="shop-page animate-to-top" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div class="shop-head" style="margin-bottom:20px;">
        <h1 style="font-size:24px;font-weight:700;"><?= esc($order['order_number']) ?></h1>
        <p style="color:#6b7280;font-size:13px;margin-top:4px;">Dibuat <?= date('d M Y H:i', strtotime($order['created_at'])) ?></p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">
        <div style="background:#fff;border:1px solid #e7eaec;border-radius:12px;overflow:hidden;">
            <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
                <span style="font-weight:700;font-size:15px;">Detail Pesanan</span>
                <?php
                $badge = ['pending' => '#fef3c7/#92400e', 'paid' => '#dbeafe/#1d4ed8', 'shipped' => '#ede9fe/#6d28d9', 'completed' => '#dcfce7/#15803d', 'cancelled' => '#fee2e2/#b91c1c'][$order['status']] ?? '#f1f5f9/#475569';
                [$bg, $fg] = explode('/', $badge);
                ?>
                <span style="background:<?= $bg ?>;color:<?= $fg ?>;padding:4px 12px;border-radius:99rem;font-size:12px;font-weight:700;text-transform:capitalize;"><?= esc($order['status']) ?></span>
            </div>
            <?php foreach ($items as $it): ?>
            <div style="display:flex;gap:14px;padding:14px 20px;border-bottom:1px solid #f1f5f9;align-items:center;">
                <img src="<?= esc(img_url($it['product_image'])) ?>" alt="" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;"><?= esc($it['product_name']) ?></div>
                    <?php if (! empty($it['variant_name'])): ?>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;">Varian: <?= esc($it['variant_name']) ?></div>
                    <?php endif; ?>
                    <div style="font-size:13px;color:#64748b;margin-top:2px;"><?= (int) $it['qty'] ?> × Rp <?= number_format($it['price'], 0, '.', ',') ?></div>
                </div>
                <div style="font-weight:700;font-size:14px;">Rp <?= number_format($it['price'] * $it['qty'], 0, '.', ',') ?></div>
            </div>
            <?php endforeach; ?>
            <div style="padding:16px 20px;">
                <div style="display:flex;justify-content:space-between;font-size:14px;color:#475569;margin-bottom:6px;"><span>Subtotal</span><span>Rp <?= number_format($order['subtotal'], 0, '.', ',') ?></span></div>
                <div style="display:flex;justify-content:space-between;font-size:14px;color:#475569;margin-bottom:6px;"><span>Ongkos Kirim</span><span>Rp <?= number_format($order['shipping_fee'], 0, '.', ',') ?></span></div>
                <div style="display:flex;justify-content:space-between;font-size:17px;font-weight:700;color:#121d3d;border-top:1px solid #f1f5f9;padding-top:12px;margin-top:8px;"><span>Total</span><span>Rp <?= number_format($order['total'], 0, '.', ',') ?></span></div>
                <div style="font-size:13px;color:#64748b;margin-top:8px;">Pembayaran: <strong><?= esc($order['payment_method']) ?></strong></div>
            </div>
        </div>

        <div style="background:#fff;border:1px solid #e7eaec;border-radius:12px;padding:20px;position:sticky;top:90px;">
            <h2 style="font-size:16px;font-weight:700;margin-bottom:12px;">Data Pengiriman</h2>
            <div style="font-size:14px;font-weight:600;"><?= esc($order['customer_name']) ?></div>
            <div style="font-size:13px;color:#6b7280;margin-top:4px;"><?= esc($order['customer_phone']) ?></div>
            <div style="font-size:13px;color:#475569;margin-top:10px;line-height:1.6;"><?= nl2br(esc($order['address'])) ?></div>
            <?php if (! empty($order['notes'])): ?>
            <div style="font-size:13px;color:#6b7280;margin-top:12px;border-top:1px solid #f1f5f9;padding-top:12px;">Catatan: <?= esc($order['notes']) ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= view('layout/footer', $data ?? []) ?>
