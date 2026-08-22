<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px;border-bottom:1px solid #e7eaec;padding-bottom:12px;">
    <?php $tabs = [
        'dashboard'  => ['/admin', 'Dashboard'],
        'products'   => ['/admin/products', 'Produk'],
        'categories' => ['/admin/categories', 'Kategori'],
        'users'      => ['/admin/users', 'User'],
    ]; ?>
    <?php foreach ($tabs as $key => [$url, $label]): ?>
    <a href="<?= $url ?>" style="padding:8px 18px;border-radius:99rem;font-size:13px;font-weight:600;text-decoration:none;<?= ($tab ?? '') === $key ? 'background:#121d3d;color:#fff;' : 'background:#f1f5f9;color:#475569;' ?>"><?= $label ?></a>
    <?php endforeach; ?>
</div>
