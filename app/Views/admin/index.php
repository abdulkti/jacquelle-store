<?= view('layout/admin_header', $data ?? []) ?>

<div class="admin-page" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <h1 style="font-size:28px;font-weight:700;">Dashboard Admin</h1>
        <a href="/" class="btn btn-outline" style="padding:8px 16px;font-size:13px;">Lihat Toko</a>
    </div>


    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin-bottom:32px;">
        <?php $cards = [
            ['label' => 'Total Produk', 'value' => number_format($stats['products']), 'icon' => '🛍️'],
            ['label' => 'Pesanan Pending', 'value' => number_format($stats['pending_orders'] ?? 0), 'icon' => '🔔'],
            ['label' => 'Total User',   'value' => number_format($stats['users']),    'icon' => '👤'],
            ['label' => 'Total Kategori', 'value' => number_format($stats['categories']), 'icon' => '🏷️'],
        ]; ?>
        <?php foreach ($cards as $c): ?>
        <div style="background:#fff;border:1px solid #e7eaec;border-radius:12px;padding:20px 16px;box-shadow:0 2px 15px -3px rgba(18,29,61,.1);">
            <div style="font-size:26px;margin-bottom:8px;"><?= $c['icon'] ?></div>
            <div style="font-size:28px;font-weight:700;"><?= $c['value'] ?></div>
            <div style="color:#6b7280;font-size:13px;margin-top:2px;"><?= $c['label'] ?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <h2 style="font-size:20px;font-weight:700;margin-bottom:12px;">Produk Terbaru</h2>
    <div style="overflow-x:auto;background:#fff;border:1px solid #e7eaec;border-radius:12px;margin-bottom:32px;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;min-width:720px;">
            <thead>
                <tr style="text-align:left;border-bottom:1px solid #e7eaec;color:#6b7280;font-size:12px;text-transform:uppercase;">
                    <th style="padding:12px 16px;">ID</th>
                    <th style="padding:12px 16px;">Gambar</th>
                    <th style="padding:12px 16px;">Nama</th>
                    <th style="padding:12px 16px;">Harga</th>
                    <th style="padding:12px 16px;">Harga Jual</th>
                    <th style="padding:12px 16px;">Diskon</th>
                    <th style="padding:12px 16px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($products, 0, 10) as $p): ?>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:12px 16px;"><?= (int) $p['id'] ?></td>
                    <td style="padding:12px 16px;">
                        <img src="<?= esc(img_url($p['image'])) ?>" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;" loading="lazy">
                    </td>
                    <td style="padding:12px 16px;max-width:320px;"><?= esc($p['name']) ?></td>
                    <td style="padding:12px 16px;text-decoration:line-through;color:rgba(0,0,0,.5);">Rp <?= number_format($p['old_price'], 0, '.', ',') ?></td>
                    <td style="padding:12px 16px;font-weight:600;color:var(--p);">Rp <?= number_format($p['price'], 0, '.', ',') ?></td>
                    <td style="padding:12px 16px;"><span class="discount-badge"><?= (int) $p['discount_percent'] ?>%</span></td>
                    <td style="padding:12px 16px;white-space:nowrap;">
                        <a href="/products/<?= (int) $p['id'] ?>/<?= rawurlencode($p['slug']) ?>" target="_blank" style="background:#f0fdf4;color:#15803d;padding:5px 12px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">Lihat</a>
                        <a href="/admin/products/edit/<?= (int) $p['id'] ?>" style="background:#eff6ff;color:#1d4ed8;padding:5px 12px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2 style="font-size:20px;font-weight:700;margin-bottom:12px;">User Terdaftar</h2>
    <div style="overflow-x:auto;background:#fff;border:1px solid #e7eaec;border-radius:12px;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;min-width:560px;">
            <thead>
                <tr style="text-align:left;border-bottom:1px solid #e7eaec;color:#6b7280;font-size:12px;text-transform:uppercase;">
                    <th style="padding:12px 16px;">ID</th>
                    <th style="padding:12px 16px;">Nama</th>
                    <th style="padding:12px 16px;">Email</th>
                    <th style="padding:12px 16px;">Telepon</th>
                    <th style="padding:12px 16px;">Role</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:12px 16px;"><?= (int) $u['id'] ?></td>
                    <td style="padding:12px 16px;font-weight:600;"><?= esc($u['name']) ?></td>
                    <td style="padding:12px 16px;"><?= esc($u['email']) ?></td>
                    <td style="padding:12px 16px;"><?= esc($u['phone']) ?></td>
                    <td style="padding:12px 16px;">
                        <?php if ((int) $u['is_admin'] === 1): ?>
                        <span style="background:#fef2f2;color:#b91c1c;padding:3px 10px;border-radius:99rem;font-size:12px;font-weight:600;">Admin</span>
                        <?php else: ?>
                        <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:99rem;font-size:12px;font-weight:600;">Member</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layout/admin_footer') ?>
