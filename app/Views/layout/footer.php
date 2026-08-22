</main>

<footer data-theme="footer" class="site-footer">
    <div class="footer-grid">
        <div class="footer-brand">
            <img src="<?= base_url('assets/images/logo.webp') ?>" alt="Jacquelle" style="height:44px;width:auto;">
            <p class="footer-desc">Beauty &amp; cosmetics brand dari Indonesia. Temukan produk kecantikan terbaik untuk menemani setiap momen cantikmu.</p>
        </div>
        <div class="footer-col">
            <h4>Kategori</h4>
            <ul>
                <li><a href="/categories/36418/eye">Eye</a></li>
                <li><a href="/categories/36419/face">Face</a></li>
                <li><a href="/categories/36420/lip">Lip</a></li>
                <li><a href="/categories/35164/beauty-tools">Beauty Tools</a></li>
                <li><a href="/categories/36980/real-body-%26-soul-">REAL Body &amp; Soul</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Menu</h4>
            <ul>
                <li><a href="/categories/35148/new-arrivals">New Arrivals</a></li>
                <li><a href="/categories/35149/best-seller">Best Seller</a></li>
                <li><a href="/categories/35150/for-you">Gift For You</a></li>
                <li><a href="/products">All Products</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Akun</h4>
            <ul>
                <?php if (session()->get('isLoggedIn')): ?>
                <li><a href="/account">Akun Saya</a></li>
                <li><a href="/orders">Pesanan</a></li>
                <li><a href="/auth/logout">Keluar</a></li>
                <?php else: ?>
                <li><a href="/auth/login">Masuk</a></li>
                <li><a href="/auth/register">Daftar Akun</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Hubungi Kami</h4>
            <ul>
                <li><a href="https://www.instagram.com/jacquelle_official" target="_blank" rel="noopener">Instagram</a></li>
                <li><a href="https://www.tiktok.com/@jacquelle_official" target="_blank" rel="noopener">TikTok</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© <?= date('Y') ?> Jacquelle. All rights reserved.</p>
        <p>Made with CodeIgniter 4</p>
    </div>
</footer>

<div class="floating-buttons" aria-label="Floating buttons">
    <button type="button" id="promoOpenBtn" class="floating-btn floating-btn-award" aria-label="Floating action button award" title="Lihat Promo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="m20.87 17.25l-2.71-4.68A6.9 6.9 0 0 0 19 9.25a7 7 0 0 0-14 0a6.9 6.9 0 0 0 .84 3.32l-2.71 4.68a1 1 0 0 0 .87 1.5h2.87l1.46 2.46a1 1 0 0 0 .18.22a1 1 0 0 0 .69.28h.14a1 1 0 0 0 .73-.49L12 17.9l1.93 3.35a1 1 0 0 0 .73.48h.14a1 1 0 0 0 .7-.28a.9.9 0 0 0 .17-.21l1.46-2.46H20a1 1 0 0 0 .87-.5a1 1 0 0 0 0-1.03M9.19 18.78l-.89-1.49a1 1 0 0 0-.85-.49H5.72l1.43-2.48a7 7 0 0 0 3.57 1.84ZM12 14.25a5 5 0 1 1 5-5a5 5 0 0 1-5 5m4.55 2.55a1 1 0 0 0-.85.49l-.89 1.49l-1.52-2.65a7.06 7.06 0 0 0 3.56-1.84l1.43 2.48Z"/></svg>
    </button>
    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="floating-btn floating-btn-chat" aria-label="Chat" title="Chat dengan kami">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="floating-btn-chat-icon"><path d="M16.6 14c-.2-.1-1.5-.7-1.7-.8s-.4-.1-.6.1s-.6.8-.8 1c-.1.2-.3.2-.5.1c-.7-.3-1.4-.7-2-1.2c-.5-.5-1-1.1-1.4-1.7c-.1-.2 0-.4.1-.5s.2-.3.4-.4c.1-.1.2-.3.2-.4c.1-.1.1-.3 0-.4S9.7 8.5 9.5 8c-.1-.7-.3-.7-.5-.7h-.5c-.2 0-.5.2-.6.3Q7 8.5 7 9.7c.1.9.4 1.8 1 2.6c1.1 1.6 2.5 2.9 4.2 3.7c.5.2.9.4 1.4.5c.5.2 1 .2 1.6.1c.7-.1 1.3-.6 1.7-1.2c.2-.4.2-.8.1-1.2zm2.5-9.1C15.2 1 8.9 1 5 4.9c-3.2 3.2-3.8 8.1-1.6 12L2 22l5.3-1.4c1.5.8 3.1 1.2 4.7 1.2c5.5 0 9.9-4.4 9.9-9.9c.1-2.6-1-5.1-2.8-7m-2.7 14c-1.3.8-2.8 1.3-4.4 1.3c-1.5 0-2.9-.4-4.2-1.1l-.3-.2l-3.1.8l.8-3l-.2-.3c-2.4-4-1.2-9 2.7-11.5S16.6 3.7 19 7.5c2.4 3.9 1.3 9-2.6 11.4"/></svg>
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?= base_url('assets/js/jacquelle.js?v=' . (filemtime(ROOTPATH . 'public/assets/js/jacquelle.js') ?: 1)) ?>"></script>
</body>
</html>
