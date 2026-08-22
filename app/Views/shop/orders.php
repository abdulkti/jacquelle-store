<?= view('layout/header', $data ?? []) ?>

<div class="shop-page animate-to-top" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div class="shop-head" style="margin-bottom:20px;">
        <h1 style="font-size:24px;font-weight:700;">Pesanan Saya</h1>
    </div>

    <?php if (! empty($notFound)): ?>
    <div class="products-empty" style="text-align:center;padding:60px 20px;">
        <p style="color:#6b7280;font-size:15px;">Pesanan tidak ditemukan.</p>
        <a href="/orders" class="btn btn-primary" style="margin-top:16px;">Lihat Semua Pesanan</a>
    </div>
    <?php elseif (empty($orders)): ?>
    <div class="products-empty" style="text-align:center;padding:60px 20px;">
        <div style="font-size:48px;margin-bottom:12px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" style="margin:0 auto;"><path d="M7 8V7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7V8M5 8H19V21H5V8Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </div>
        <p style="color:#6b7280;font-size:15px;">Belum ada pesanan. Yuk mulai belanja!</p>
        <a href="/products" class="btn btn-primary" style="margin-top:16px;">Mulai Belanja</a>
    </div>
    <?php else: ?>
    <div style="display:grid;gap:14px;">
        <?php foreach ($orders as $o): ?>
        <a href="/orders/<?= (int) $o['id'] ?>" style="background:#fff;border:1px solid #e7eaec;border-radius:12px;padding:18px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;text-decoration:none;color:inherit;">
            <div>
                <div style="font-weight:700;font-size:15px;"><?= esc($o['order_number']) ?></div>
                <div style="font-size:13px;color:#6b7280;margin-top:3px;"><?= date('d M Y H:i', strtotime($o['created_at'])) ?></div>
            </div>
            <div style="display:flex;align-items:center;gap:14px;">
                <span style="font-weight:700;color:#121d3d;">Rp <?= number_format($o['total'], 0, '.', ',') ?></span>
                <?php
                $badge = ['pending' => '#fef3c7/#92400e', 'paid' => '#dbeafe/#1d4ed8', 'shipped' => '#ede9fe/#6d28d9', 'completed' => '#dcfce7/#15803d', 'cancelled' => '#fee2e2/#b91c1c'][$o['status']] ?? '#f1f5f9/#475569';
                [$bg, $fg] = explode('/', $badge);
                ?>
                <span style="background:<?= $bg ?>;color:<?= $fg ?>;padding:4px 12px;border-radius:99rem;font-size:12px;font-weight:700;text-transform:capitalize;"><?= esc($o['status']) ?></span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?= view('layout/footer', $data ?? []) ?>
