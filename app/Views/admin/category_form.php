<?= view('layout/header', $data ?? []) ?>

<div class="admin-page" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <h1 style="font-size:28px;font-weight:700;"><?= $category ? 'Edit Kategori' : 'Tambah Kategori' ?></h1>
        <a href="/admin/categories" class="btn btn-outline" style="padding:8px 16px;font-size:13px;">← Kembali</a>
    </div>

    <?= view('admin/_nav', ['tab' => $tab ?? 'categories']) ?>

    <?php if (session('error')): ?>
    <div style="background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <form action="/admin/categories/save" method="post" style="background:#fff;border:1px solid #e7eaec;border-radius:12px;padding:24px;max-width:560px;">
        <input type="hidden" name="id" value="<?= (int) ($category['id'] ?? 0) ?>">

        <div style="margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Nama Kategori *</label>
            <input type="text" name="name" required value="<?= esc(old('name') ?: ($category['name'] ?? '')) ?>" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
        </div>

        <div style="margin-bottom:20px;">
            <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Slug (kosongkan = otomatis)</label>
            <input type="text" name="slug" value="<?= esc(old('slug') ?: ($category['slug'] ?? '')) ?>" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
        </div>

        <button type="submit" class="btn" style="padding:11px 28px;font-size:14px;font-weight:600;border:none;cursor:pointer;">Simpan Kategori</button>
    </form>
</div>

<?= view('layout/footer', $data ?? []) ?>
