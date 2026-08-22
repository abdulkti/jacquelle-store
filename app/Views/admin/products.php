<?= view('layout/admin_header', $data ?? []) ?>

<div class="admin-page" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <h1 style="font-size:28px;font-weight:700;">Kelola Produk <span style="font-size:14px;color:#6b7280;font-weight:400;">(<?= (int) $count ?> produk)</span></h1>
        <a href="/admin/products/new" class="btn" style="padding:10px 20px;font-size:13px;font-weight:600;">+ Tambah Produk</a>
    </div>


    <?php if (session('success')): ?>
    <div style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
    <div style="background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div style="overflow-x:auto;background:#fff;border:1px solid #e7eaec;border-radius:12px;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;min-width:860px;">
            <thead>
                <tr style="text-align:left;border-bottom:1px solid #e7eaec;color:#6b7280;font-size:12px;text-transform:uppercase;">
                    <th style="padding:12px 16px;">ID</th>
                    <th style="padding:12px 16px;">Gambar</th>
                    <th style="padding:12px 16px;">Nama</th>
                    <th style="padding:12px 16px;">Kode</th>
                    <th style="padding:12px 16px;">Kategori</th>
                    <th style="padding:12px 16px;">Harga</th>
                    <th style="padding:12px 16px;">Diskon</th>
                    <th style="padding:12px 16px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:12px 16px;"><?= (int) $p['id'] ?></td>
                    <td style="padding:12px 16px;">
                        <img src="<?= esc(img_url($p['image'])) ?>" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;" loading="lazy">
                    </td>
                    <td style="padding:12px 16px;max-width:300px;font-weight:600;"><?= esc($p['name']) ?></td>
                    <td style="padding:12px 16px;color:#6b7280;"><?= esc($p['product_code'] ?? '-') ?></td>
                    <td style="padding:12px 16px;max-width:200px;color:#6b7280;"><?= esc(implode(', ', array_slice($p['cats'], 0, 2))) ?><?= count($p['cats']) > 2 ? ' +' . (count($p['cats']) - 2) : '' ?></td>
                    <td style="padding:12px 16px;">
                        <?php if ($p['sale_price']): ?>
                        <span style="text-decoration:line-through;color:rgba(0,0,0,.4);">Rp <?= number_format($p['old_price'], 0, '.', ',') ?></span><br>
                        <span style="font-weight:700;color:#121d3d;">Rp <?= number_format($p['price'], 0, '.', ',') ?></span>
                        <?php else: ?>
                        <span style="font-weight:600;">Rp <?= number_format($p['price'], 0, '.', ',') ?></span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:12px 16px;"><span class="discount-badge"><?= (int) $p['discount_percent'] ?>%</span></td>
                    <td style="padding:12px 16px;white-space:nowrap;">
                        <a href="/products/<?= (int) $p['id'] ?>/<?= rawurlencode($p['slug']) ?>" target="_blank" style="background:#f0fdf4;color:#15803d;padding:5px 12px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">Lihat</a>
                        <a href="/admin/products/edit/<?= (int) $p['id'] ?>" style="background:#eff6ff;color:#1d4ed8;padding:5px 12px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">Edit</a>
                        <form action="/admin/products/delete/<?= (int) $p['id'] ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus produk ini?');">
                            <button type="submit" style="background:#fef2f2;color:#b91c1c;padding:5px 12px;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layout/admin_footer') ?>
