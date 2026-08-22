<?= view('layout/header', $data ?? []) ?>

<div class="admin-page" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <h1 style="font-size:28px;font-weight:700;"><?= $product ? 'Edit Produk' : 'Tambah Produk' ?></h1>
        <a href="/admin/products" class="btn btn-outline" style="padding:8px 16px;font-size:13px;">← Kembali</a>
    </div>

    <?= view('admin/_nav', ['tab' => $tab ?? 'products']) ?>

    <?php if (! empty($errors)): ?>
    <div style="background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;">
        <?php foreach ($errors as $e): ?><div>• <?= esc(is_array($e) ? implode(', ', $e) : $e) ?></div><?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if (session('error')): ?>
    <div style="background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <form action="/admin/products/save" method="post" enctype="multipart/form-data" style="background:#fff;border:1px solid #e7eaec;border-radius:12px;padding:24px;">
        <input type="hidden" name="id" value="<?= (int) ($product['id'] ?? 0) ?>">

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;">
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Nama Produk *</label>
                <input type="text" name="name" required value="<?= esc(old('name') ?: ($product['name'] ?? '')) ?>" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Kode Produk</label>
                <input type="text" name="product_code" value="<?= esc(old('product_code') ?: ($product['product_code'] ?? '')) ?>" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Slug (kosongkan = otomatis)</label>
                <input type="text" name="slug" value="<?= esc(old('slug') ?: ($product['slug'] ?? '')) ?>" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Harga *</label>
                <input type="number" name="price" required min="0" value="<?= esc(old('price') ?: ($product['price'] ?? '')) ?>" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Harga Jual / Coret (opsional)</label>
                <input type="number" name="sale_price" min="0" value="<?= esc(old('sale_price') !== null && old('sale_price') !== '' ? old('sale_price') : ($product['sale_price'] ?? '')) ?>" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Diskon % (opsional)</label>
                <input type="number" name="discount_percent" min="0" max="100" value="<?= esc(old('discount_percent') !== null && old('discount_percent') !== '' ? old('discount_percent') : ($product['discount_percent'] ?? 0)) ?>" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;">
            </div>
        </div>

        <div style="margin-top:16px;">
            <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Kategori</label>
            <div style="display:flex;flex-wrap:wrap;gap:10px;max-height:180px;overflow-y:auto;border:1px solid #e7eaec;border-radius:8px;padding:12px;">
                <?php foreach ($categories as $c): ?>
                <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer;background:#f8fafc;padding:6px 12px;border-radius:8px;">
                    <input type="checkbox" name="categories[]" value="<?= (int) $c['id'] ?>" <?= $product && in_array($c['id'], $product['cats']) ? 'checked' : '' ?>>
                    <?= esc($c['name']) ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="margin-top:16px;display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;">
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Gambar Produk</label>
                <input type="file" name="image" accept="image/webp,image/jpeg,image/png" style="width:100%;padding:8px;border:1px solid #d8dee6;border-radius:8px;font-size:13px;">
                <?php if ($product && $product['image']): ?>
                <div style="margin-top:8px;">
                    <img src="<?= esc(img_url($product['image'])) ?>" alt="" style="width:72px;height:72px;object-fit:cover;border-radius:8px;">
                </div>
                <?php endif; ?>
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Judul Varian</label>
                <input type="text" name="variant_title" value="<?= esc(old('variant_title') !== null ? old('variant_title') : ($product['variant_title'] ?? '')) ?>" placeholder="contoh: Warna / Shade / Variasi / Ukuran" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:13px;">
                <div style="font-size:12px;color:#64748b;margin-top:6px;">Judul yang tampil di atas pilihan varian (kosongkan jika tidak ada varian).</div>
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Varian Warna</label>
                <?php
                $variantsText = old('variants') ?: '';
                if ($variantsText === '' && $product && ! empty($product['variants'])) {
                    $vlines = [];
                    foreach (json_decode($product['variants'], true) ?: [] as $v) {
                        $vimg = $v['image'] ?? '';
                        $vline = $v['name'] ?? '';
                        $vline .= $vimg !== '' ? '|' . $vimg : '';
                        $vprice = (int) ($v['price'] ?? 0);
                        $vold = (int) ($v['old_price'] ?? 0);
                        if ($vprice > 0) {
                            $vline .= '|' . $vprice . ($vold > $vprice ? '|' . $vold : '');
                        }
                        $vlines[] = $vline;
                    }
                    $variantsText = implode("\n", $vlines);
                }
                ?>
                <textarea name="variants" rows="4" placeholder="Nama Varian|assets/images/products/xxx.webp|harga|harga_asli&#10;contoh: Black|assets/images/products/black.webp|49000|149000" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:13px;font-family:monospace;"><?= esc($variantsText) ?></textarea>
                <div style="font-size:12px;color:#64748b;margin-top:6px;">Satu varian per baris, format: <b>Nama|path-gambar|harga|harga-asli(opsional)</b> — harga opsional, kosongkan jika sama dengan harga produk</div>
            </div>
        </div>

        <div style="margin-top:16px;">
            <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Deskripsi</label>
            <textarea name="description" rows="5" style="width:100%;padding:10px 12px;border:1px solid #d8dee6;border-radius:8px;font-size:14px;"><?= esc(old('description') ?: ($product['description'] ?? '')) ?></textarea>
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn" style="padding:11px 28px;font-size:14px;font-weight:600;border:none;cursor:pointer;">Simpan Produk</button>
        </div>
    </form>
</div>

<?= view('layout/footer', $data ?? []) ?>
