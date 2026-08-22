<?= view('layout/header', $data ?? []) ?>

<div class="auth-page">
    <div class="auth-card animate-to-top">
        <a href="/" class="auth-logo">
            <img src="<?= base_url('assets/images/logo.webp') ?>" alt="Jacquelle" style="height:48px;width:auto;">
        </a>
        <h1 class="auth-title">Masuk</h1>
        <p class="auth-subtitle">Silakan masuk ke akun Jacquelle Anda</p>

        <?php if (! empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $e): ?><p><?= esc($e) ?></p><?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/login') ?>" method="post" class="auth-form">
            <?= csrf_field() ?>
            <input type="hidden" name="redirect" value="<?= esc(service('request')->getGet('redirect') ?? '') ?>">
            <label class="field">
                <span>Email</span>
                <input type="email" name="email" value="<?= esc(old('email')) ?>" placeholder="nama@email.com" required>
            </label>
            <label class="field">
                <span>Password</span>
                <input type="password" name="password" placeholder="••••••••" required>
            </label>
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>

        <p class="auth-switch">Belum punya akun? <a href="<?= base_url('auth/register') ?>">Daftar Sekarang</a></p>
        <a href="/" class="auth-back">&larr; Kembali ke Beranda</a>
    </div>
</div>

<?= view('layout/footer', $data ?? []) ?>
