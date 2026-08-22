<?= view('layout/header', $data ?? []) ?>

<div class="shop-page animate-to-top" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div class="shop-head" style="margin-bottom:20px;">
        <h1 style="font-size:24px;font-weight:700;"><?= esc($order['order_number']) ?></h1>
        <p style="color:#6b7280;font-size:13px;margin-top:4px;">Dibuat <?= date('d M Y H:i', strtotime($order['created_at'])) ?></p>
    </div>

    <?php if ($order['status'] === 'pending'): ?>
    <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:20px 24px;margin-bottom:20px;">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 8V12M12 16H12.01M10.29 3.86L1.82 18A2 2 0 0 0 3.54 21H16.46A2 2 0 0 0 18.18 18L9.71 3.86A2 2 0 0 0 6.29 3.86Z" stroke="#b45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <h2 style="font-size:16px;font-weight:700;color:#b45309;">Menunggu Pembayaran</h2>
        </div>
        <?php if ($order['payment_method'] === 'transfer'): ?>
        <p style="font-size:13px;color:#92400e;line-height:1.7;">Silakan transfer <strong>tepat</strong> sebesar <strong style="font-size:15px;">Rp <?= number_format($order['total'], 0, '.', ',') ?></strong> ke salah satu rekening berikut:</p>
        <div style="display:flex;flex-wrap:wrap;gap:12px;margin-top:12px;">
            <div style="background:#fff;border:1px solid #fde68a;border-radius:10px;padding:12px 16px;min-width:220px;">
                <div style="font-size:12px;font-weight:700;color:#92400e;">BCA</div>
                <div style="font-size:15px;font-weight:700;letter-spacing:.5px;margin-top:2px;">1234567890</div>
                <div style="font-size:12px;color:#64748b;margin-top:2px;">a.n. Jacquelle Beauty</div>
            </div>
            <div style="background:#fff;border:1px solid #fde68a;border-radius:10px;padding:12px 16px;min-width:220px;">
                <div style="font-size:12px;font-weight:700;color:#92400e;">Mandiri</div>
                <div style="font-size:15px;font-weight:700;letter-spacing:.5px;margin-top:2px;">9876543210</div>
                <div style="font-size:12px;color:#64748b;margin-top:2px;">a.n. Jacquelle Beauty</div>
            </div>
            <div style="background:#fff;border:1px solid #fde68a;border-radius:10px;padding:12px 16px;min-width:220px;">
                <div style="font-size:12px;font-weight:700;color:#92400e;">BNI</div>
                <div style="font-size:15px;font-weight:700;letter-spacing:.5px;margin-top:2px;">0123456789</div>
                <div style="font-size:12px;color:#64748b;margin-top:2px;">a.n. Jacquelle Beauty</div>
            </div>
        </div>
        <?php else: ?>
        <p style="font-size:13px;color:#92400e;line-height:1.7;">Pesanan Anda menggunakan <strong>COD (Bayar di Tempat)</strong>. Siapkan uang tunai sebesar <strong>Rp <?= number_format($order['total'], 0, '.', ',') ?></strong> saat paket tiba.</p>
        <?php endif; ?>
        <a href="https://wa.me/6281234567890?text=<?= rawurlencode('Halo, saya sudah bayar pesanan ' . $order['order_number'] . ' sebesar Rp ' . number_format($order['total'], 0, '.', ',') . '. Berikut bukti transfernya.') ?>" target="_blank" rel="noopener" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:8px;margin-top:14px;padding:11px 22px;font-size:14px;font-weight:700;text-decoration:none;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.75 2.64 15.49 3.54 17L2 22L7.14 20.5C8.59 21.31 10.27 21.78 12.04 21.78C17.5 21.78 21.95 17.33 21.95 11.87C21.95 6.41 17.5 2 12.04 2Z"/></svg>
            Konfirmasi Pembayaran via WhatsApp
        </a>
        <span style="font-size:12px;color:#a16207;margin-left:10px;">Pesanan otomatis dibatalkan jika tidak dibayar dalam 24 jam.</span>
    </div>
    <?php elseif ($order['status'] === 'paid'): ?>
    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:16px 20px;margin-bottom:20px;font-size:14px;color:#1d4ed8;font-weight:600;">
        Pembayaran diterima. Pesanan Anda sedang diproses.
    </div>
    <?php elseif ($order['status'] === 'shipped'): ?>
    <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:12px;padding:16px 20px;margin-bottom:20px;font-size:14px;color:#6d28d9;font-weight:600;">
        Pesanan Anda sedang dalam pengiriman.
    </div>
    <?php endif; ?>

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
