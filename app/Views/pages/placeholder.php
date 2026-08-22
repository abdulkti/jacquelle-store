<?= view('layout/header', $data ?? []) ?>

<div class="placeholder-page animate-to-top">
    <div class="placeholder-icon">
        <?php if ($page === 'wishlist'): ?>
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"><path d="M12 21C12 21 3.5 16.5 3.5 9.7C3.5 6.6 5.9 4.2 8.9 4.2C10.6 4.2 12.1 5.1 13 6.4C13.9 5.1 15.4 4.2 17.1 4.2C20.1 4.2 22.5 6.6 22.5 9.7C22.5 16.5 14 21 12 21Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <?php elseif ($page === 'cart'): ?>
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"><path d="M6 7H20L18.5 17H7.5L6 7ZM6 7L5 3H2" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <?php else: ?>
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"><path d="M7 8V7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7V8M5 8H19V21H5V8Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"/></svg>
        <?php endif; ?>
    </div>
    <h1><?= esc($name) ?> Kosong</h1>
    <p>Belum ada <?= strtolower(esc($name)) ?>. Yuk mulai belanja produk Jacquelle favoritmu!</p>
    <a href="/" class="btn btn-primary">Belanja Sekarang</a>
</div>

<?= view('layout/footer', $data ?? []) ?>
