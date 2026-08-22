<?= view('layout/admin_header', $data ?? []) ?>

<div class="admin-page" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <h1 style="font-size:28px;font-weight:700;">Kelola Kategori <span style="font-size:14px;color:#6b7280;font-weight:400;">(<?= count($categories) ?> kategori)</span></h1>
        <a href="/admin/categories/new" class="btn" style="padding:10px 20px;font-size:13px;font-weight:600;">+ Tambah Kategori</a>
    </div>


    <?php if (session('success')): ?>
    <div style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
    <div style="background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div style="overflow-x:auto;background:#fff;border:1px solid #e7eaec;border-radius:12px;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;min-width:600px;">
            <thead>
                <tr style="text-align:left;border-bottom:1px solid #e7eaec;color:#6b7280;font-size:12px;text-transform:uppercase;">
                    <th style="padding:12px 16px;">ID</th>
                    <th style="padding:12px 16px;">Nama</th>
                    <th style="padding:12px 16px;">Slug</th>
                    <th style="padding:12px 16px;">Produk</th>
                    <th style="padding:12px 16px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $c): ?>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:12px 16px;"><?= (int) $c['id'] ?></td>
                    <td style="padding:12px 16px;font-weight:600;"><?= esc($c['name'] ?: '(tanpa nama)') ?></td>
                    <td style="padding:12px 16px;color:#6b7280;"><?= esc($c['slug']) ?></td>
                    <td style="padding:12px 16px;"><?= (int) $c['products'] ?></td>
                    <td style="padding:12px 16px;white-space:nowrap;">
                        <a href="/admin/categories/edit/<?= (int) $c['id'] ?>" style="background:#eff6ff;color:#1d4ed8;padding:5px 12px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">Edit</a>
                        <form action="/admin/categories/delete/<?= (int) $c['id'] ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus kategori ini? Produk tidak ikut terhapus.');">
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
