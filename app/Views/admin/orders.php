<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:24px;">
    <div>
        <h1 style="font-size:26px;font-weight:800;color:#121d3d;">Pesanan</h1>
        <p style="font-size:13px;color:#94a3b8;margin-top:3px;">Kelola pesanan yang masuk dari toko.</p>
    </div>
</div>

<?php if (session('success')): ?>
<div class="adm-alert-success"><?= esc(session('success')) ?></div>
<?php endif; ?>
<?php if (session('error')): ?>
<div class="adm-alert-error"><?= esc(session('error')) ?></div>
<?php endif; ?>

<?php
$statusLabels = [
    'pending'   => 'Menunggu Bayar',
    'paid'      => 'Sudah Dibayar',
    'shipped'   => 'Dikirim',
    'completed' => 'Selesai',
    'cancelled' => 'Dibatalkan',
];
?>
<div class="ord-tabs" style="margin-bottom:22px;">
    <a href="/admin/orders" class="ord-tab <?= empty($filter) ? 'active' : '' ?>">Semua<em><?= array_sum($stats) ?></em></a>
    <?php foreach ($statuses as $s): ?>
    <a href="/admin/orders?status=<?= $s ?>" class="ord-tab <?= $filter === $s ? 'active' : '' ?>"><?= $statusLabels[$s] ?><em><?= (int) $stats[$s] ?></em></a>
    <?php endforeach; ?>
</div>

<?php if (empty($orders)): ?>
<div class="ord-empty">
    Belum ada pesanan<?= $filter ? ' dengan status ini' : '' ?>.
</div>
<?php else: ?>
<div style="display:flex;flex-direction:column;gap:14px;">
    <?php foreach ($orders as $o): ?>
    <div class="ord-card">
        <div class="ord-head">
            <span class="ord-num"><?= esc($o['order_number']) ?></span>
            <span class="ord-date"><?= date('d M Y · H:i', strtotime($o['created_at'])) ?></span>
        </div>

        <div class="ord-body">
            <div>
                <div class="ord-label">Pelanggan</div>
                <div class="ord-name"><?= esc($o['customer_name']) ?></div>
                <a class="ord-wa" href="https://wa.me/62<?= preg_replace('/^0/', '', (string) $o['customer_phone']) ?>" target="_blank" rel="noopener">
                    <?= esc($o['customer_phone']) ?> · WhatsApp ↗
                </a>
            </div>
            <div>
                <div class="ord-label">Pengiriman</div>
                <div class="ord-addr" title="<?= esc($o['address']) ?>">
                    <?= esc($o['address']) ?><?php if (! empty($o['notes'])): ?> — <em>"<?= esc($o['notes']) ?>"</em><?php endif; ?>
                </div>
            </div>
            <div>
                <div class="ord-label">Total</div>
                <div class="ord-total">Rp <?= number_format($o['total'], 0, '.', ',') ?></div>
                <div class="ord-text"><?= (int) $o['items'] ?> produk · <?= esc($o['payment_method'] === 'cod' ? 'COD' : 'Transfer Bank') ?></div>
            </div>
        </div>

        <div class="ord-foot">
            <span class="ord-status st-<?= esc($o['status']) ?>">
                <span class="ord-dot"></span><?= $statusLabels[$o['status']] ?? esc($o['status']) ?>
            </span>
            <div class="ord-actions">
                <a href="/orders/<?= (int) $o['id'] ?>" target="_blank" class="ord-btn ord-btn-ghost">Detail ↗</a>
                <form action="/admin/orders/status" method="post" style="display:flex;gap:8px;">
                    <input type="hidden" name="id" value="<?= (int) $o['id'] ?>">
                    <select name="status" class="ord-select">
                        <?php foreach ($statuses as $s): ?>
                        <option value="<?= $s ?>" <?= $o['status'] === $s ? 'selected' : '' ?>><?= $statusLabels[$s] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="ord-btn ord-btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
