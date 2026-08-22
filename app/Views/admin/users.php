<?= view('layout/header', $data ?? []) ?>

<div class="admin-page" style="max-width:1280px;margin:0 auto;padding:24px 16px;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <h1 style="font-size:28px;font-weight:700;">Kelola User <span style="font-size:14px;color:#6b7280;font-weight:400;">(<?= count($users) ?> user)</span></h1>
    </div>

    <?= view('admin/_nav', ['tab' => $tab ?? 'users']) ?>

    <?php if (session('success')): ?>
    <div style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
    <div style="background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div style="overflow-x:auto;background:#fff;border:1px solid #e7eaec;border-radius:12px;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;min-width:700px;">
            <thead>
                <tr style="text-align:left;border-bottom:1px solid #e7eaec;color:#6b7280;font-size:12px;text-transform:uppercase;">
                    <th style="padding:12px 16px;">ID</th>
                    <th style="padding:12px 16px;">Nama</th>
                    <th style="padding:12px 16px;">Email</th>
                    <th style="padding:12px 16px;">Role</th>
                    <th style="padding:12px 16px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:12px 16px;"><?= (int) $u['id'] ?></td>
                    <td style="padding:12px 16px;font-weight:600;"><?= esc($u['name']) ?></td>
                    <td style="padding:12px 16px;"><?= esc($u['email']) ?></td>
                    <td style="padding:12px 16px;">
                        <?php if ((int) $u['is_admin'] === 1): ?>
                        <span style="background:#fef2f2;color:#b91c1c;padding:3px 10px;border-radius:99rem;font-size:12px;font-weight:600;">Admin</span>
                        <?php else: ?>
                        <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:99rem;font-size:12px;font-weight:600;">Member</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:12px 16px;">
                        <details style="display:inline-block;">
                            <summary style="cursor:pointer;background:#eff6ff;color:#1d4ed8;padding:5px 12px;border-radius:8px;font-size:12px;font-weight:600;list-style:none;">Edit</summary>
                            <form action="/admin/users/save" method="post" style="position:absolute;z-index:10;background:#fff;border:1px solid #e7eaec;border-radius:12px;padding:16px;margin-top:8px;box-shadow:0 10px 30px rgba(0,0,0,.15);min-width:280px;">
                                <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                                <div style="margin-bottom:10px;">
                                    <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Nama</label>
                                    <input type="text" name="name" value="<?= esc($u['name']) ?>" style="width:100%;padding:8px 10px;border:1px solid #d8dee6;border-radius:6px;font-size:13px;">
                                </div>
                                <div style="margin-bottom:10px;">
                                    <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Telepon</label>
                                    <input type="text" name="phone" value="<?= esc($u['phone'] ?? '') ?>" style="width:100%;padding:8px 10px;border:1px solid #d8dee6;border-radius:6px;font-size:13px;">
                                </div>
                                <div style="margin-bottom:10px;">
                                    <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Password baru (kosongkan jika tidak diganti)</label>
                                    <input type="password" name="password" style="width:100%;padding:8px 10px;border:1px solid #d8dee6;border-radius:6px;font-size:13px;">
                                </div>
                                <div style="margin-bottom:14px;">
                                    <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Role</label>
                                    <select name="is_admin" style="width:100%;padding:8px 10px;border:1px solid #d8dee6;border-radius:6px;font-size:13px;">
                                        <option value="0" <?= (int) $u['is_admin'] === 0 ? 'selected' : '' ?>>Member</option>
                                        <option value="1" <?= (int) $u['is_admin'] === 1 ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                </div>
                                <button type="submit" style="background:#121d3d;color:#fff;padding:8px 18px;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">Simpan</button>
                            </form>
                        </details>
                        <?php if ((int) $u['id'] !== (int) session()->get('id')): ?>
                        <form action="/admin/users/delete/<?= (int) $u['id'] ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus user ini?');">
                            <button type="submit" style="background:#fef2f2;color:#b91c1c;padding:5px 12px;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">Hapus</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layout/footer', $data ?? []) ?>
