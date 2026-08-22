<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
    <h1 style="font-size:28px;font-weight:700;">Pesanan Masuk</h1>
</div>

<?php if (session('success')): ?>
<div class="adm-alert-success"><?= esc(session('success')) ?></div>
<?php endif; ?>
<?php if (session('error')): ?>
<div class="adm-alert-error"><?= esc(session('error')) ?></div>
<?php endif; ?>

<?php
$badgeStyles = [
    'pending'   => 'background:#fef3c7;color:#92400e;',
    'paid'      => 'background:#dbeafe;color:#1d4ed8;',
    'shipped'   => 'background:#ede9fe;color:#6d28d9;',
    'completed' => 'background:#dcfce7;color:#15803d;',
    'cancelled' => 'background:#fee2e2;color:#b91c1c;',
];
$statusLabels = [
    'pending'   => 'Menunggu Bayar',
    'paid'      => 'Sudah Dibayar',
    'shipped'   => 'Dikirim',
    'completed' => 'Selesai',
    'cancelled' => 'Dibatalkan',
];
?>
<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px;">
    <a href="/admin/orders" style="padding:8px 18px;border-radius:99rem;font-size:13px;font-weight:600;<?= empty($filter) ? 'background:#121d3d;color:#fff;' : 'background:#fff;border:1px solid #e7eaec;color:#475569;' ?>">Semua (<?= array_sum($stats) ?>)</a>
    <?php foreach ($statuses as $s): ?>
    <a href="/admin/orders?status=<?= $s ?>" style="padding:8px 18px;border-radius:99rem;font-size:13px;font-weight:600;<?= $filter === $s ? 'background:#121d3d;color:#fff;' : 'background:#fff;border:1px solid #e7eaec;color:#475569;' ?>"><?= $statusLabels[$s] ?> (<?= (int) $stats[$s] ?>)</a>
    <?php endforeach; ?>
</div>

<?php if (empty($orders)): ?>
<div class="adm-card" style="padding:48px;text-align:center;color:#64748b;">
    <p style="font-size:15px;">Belum ada pesanan<?= $filter ? ' dengan status ini' : '' ?>.</p>
</div>
<?php else: ?>
<div style="display:flex;flex-direction:column;gap:14px;">
    <?php foreach ($orders as $o): ?>
    <div class="adm-card" style="padding:18px 20px;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap;">
            <div style="display:flex;gap:14px;align-items:flex-start;">
                <?php if (! empty($o['first_img'])): ?>
                <img src="<?= esc(img_url($o['first_img'])) ?>" alt="" style="width:52px;height:52px;object-fit:cover;border-radius:10px;">
                <?php endif; ?>
                <div>
                    <div style="font-size:15px;font-weight:800;color:#121d3d;"><?= esc($o['order_number']) ?></div>
                    <div style="font-size:12.5px;color:#64748b;margin-top:2px;">
                        <?= date('d M Y H:i', strtotime($o['created_at'])) ?> ·
                        <?= (int) $o['items'] ?> produk ·
                        <?= esc($o['payment_method'] === 'cod' ? 'COD' : 'Transfer Bank') ?>
                    </div>
                    <div style="font-size:13px;margin-top:6px;">
                        <span style="font-weight:700;"><?= esc($o['customer_name']) ?></span>
                        <a href="https://wa.me/62<?= preg_replace('/^0/', '', (string) $o['customer_phone']) ?>" target="_blank" style="color:#15803d;font-size:12.5px;font-weight:600;margin-left:6px;"><?= esc($o['customer_phone']) ?> (WA ↗)</a>
                    </div>
                </div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:19px;font-weight:800;color:#121d3d;">Rp <?= number_format($o['total'], 0, '.', ',') ?></div>
                <span style="display:inline-block;margin-top:4px;padding:4px 12px;border-radius:99rem;font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.03em;<?= $badgeStyles[$o['status']] ?? '' ?>"><?= $statusLabels[$o['status']] ?? esc($o['status']) ?></span>
            </div>
        </div>
        <div style="border-top:1px solid #f1f5f9;margin-top:14px;padding-top:14px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
            <div style="font-size:13px;color:#475569;max-width:520px;">
                <strong style="color:#121d3d;">Kirim ke:</strong> <?= esc($o['address']) ?>
                <?php if (! empty($o['notes'])): ?><em style="color:#94a3b8;"> — "<?= esc($o['notes']) ?>"</em><?php endif; ?>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <a href="/orders/<?= (int) $o['id'] ?>" target="_blank" style="background:#f1f5f9;color:#475569;padding:8px 14px;border-radius:8px;font-size:12.5px;font-weight:600;">Detail</a>
                <form action="/admin/orders/status" method="post" style="display:flex;gap:8px;align-items:center;">
                    <input type="hidden" name="id" value="<?= (int) $o['id'] ?>">
                    <select name="status" style="padding:8px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:13px;font-weight:600;background:#fff;">
                        <?php foreach ($statuses as $s): ?>
                        <option value="<?= $s ?>" <?= $o['status'] === $s ? 'selected' : '' ?>><?= $statusLabels[$s] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" style="background:#121d3d;color:#fff;padding:8px 16px;border:none;border-radius:8px;font-size:12.5px;font-weight:700;cursor:pointer;">Simpan Status</button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
