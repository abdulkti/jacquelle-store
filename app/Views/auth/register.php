<?= view('layout/header', $data ?? []) ?>

<div class="auth-page">
    <div class="auth-card animate-to-top">
        <a href="/" class="auth-logo">
            <img src="<?= base_url('assets/images/logo.webp') ?>" alt="Jacquelle" style="height:48px;width:auto;">
        </a>
        <h1 class="auth-title">Daftar Akun</h1>
        <p class="auth-subtitle">Buat akun baru untuk mulai berbelanja</p>

        <?php if (! empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $e): ?><p><?= esc($e) ?></p><?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/register') ?>" method="post" class="auth-form">
            <?= csrf_field() ?>
            <label class="field">
                <span>Nama Lengkap</span>
                <input type="text" name="name" value="<?= esc(old('name')) ?>" placeholder="Nama Anda" required>
            </label>
            <label class="field">
                <span>Email</span>
                <input type="email" name="email" value="<?= esc(old('email')) ?>" placeholder="nama@email.com" required>
            </label>
            <label class="field">
                <span>No. HP (opsional)</span>
                <input type="text" name="phone" value="<?= esc(old('phone')) ?>" placeholder="08xxxxxxxxxx">
            </label>
            <label class="field">
                <span>Password</span>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required>
            </label>
            <label class="field">
                <span>Ulangi Password</span>
                <input type="password" name="passconf" placeholder="Ulangi password" required>
            </label>
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </form>

        <p class="auth-switch">Sudah punya akun? <a href="<?= base_url('auth/login') ?>">Masuk</a></p>
        <a href="/" class="auth-back">&larr; Kembali ke Beranda</a>
    </div>
</div>

<?= view('layout/footer', $data ?? []) ?>
