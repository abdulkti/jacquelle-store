<?php
$isLoggedIn = session()->get('isLoggedIn');
$userName   = session()->get('name');
$flashSuccess = session()->getFlashdata('success');
$flashError   = session()->getFlashdata('error');
$flashWarn    = session()->getFlashdata('warn');
$_cart = session()->get('cart');
$cartCount = is_array($_cart) ? array_sum($_cart) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#64748b">
<title><?= esc($title ?? 'Jacquelle') ?></title>
<link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('assets/images/favicon.webp') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/jacquelle.css?v=' . (filemtime(ROOTPATH . 'public/assets/css/jacquelle.css') ?: 1)) ?>">
</head>
<body>

<div class="toast-wrap">
<?php if ($flashSuccess): ?>
    <div class="toast toast-success"><?= esc($flashSuccess) ?></div>
<?php endif; ?>
<?php if ($flashError): ?>
    <div class="toast toast-error"><?= esc($flashError) ?></div>
<?php endif; ?>
<?php if ($flashWarn): ?>
    <div class="toast toast-warn"><?= esc($flashWarn) ?></div>
<?php endif; ?>
</div>

<header class="app-bar" data-theme="appbar" role="banner">
    <a class="announcement-bar" href="/categories/35149/best-seller">
        <span class="announcement-text">Free Ongkir 9K with Min Purchase of 100K on All Jacquelle Products</span>
    </a>
    <div class="appbar-row">
        <button class="icon-btn" id="btnMenu" aria-label="Menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 6H21M3 12H21M3 18H21" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/></svg>
        </button>
        <button class="icon-btn appbar-search-btn" id="btnSearch" aria-label="Search">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21 21L15.8033 15.8033M17.8 10.4C17.8 14.4868 14.5868 17.7 10.5 17.7C6.41325 17.7 3.2 14.4868 3.2 10.4C3.2 6.31325 6.41325 3.1 10.5 3.1C14.5868 3.1 17.8 6.31325 17.8 10.4Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/></svg>
            <span class="appbar-search-text">Cari</span>
        </button>
        <a class="logo-wrap" href="/" aria-label="Jacquelle Home">
            <img src="<?= base_url('assets/images/logo.webp') ?>" alt="Logo Jacquelle" style="max-width:100%;height:44px;width:auto;">
        </a>
        <a class="icon-btn" href="/wishlist" aria-label="Wishlist">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 21C12 21 3.5 16.5 3.5 9.7C3.5 6.6 5.9 4.2 8.9 4.2C10.6 4.2 12.1 5.1 13 6.4C13.9 5.1 15.4 4.2 17.1 4.2C20.1 4.2 22.5 6.6 22.5 9.7C22.5 16.5 14 21 12 21Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
        <a class="icon-btn" href="/cart" aria-label="Cart">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M6 7H20L18.5 17H7.5L6 7ZM6 7L5 3H2" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="21" r="1.2" fill="currentcolor"/><circle cx="16" cy="21" r="1.2" fill="currentcolor"/></svg>
            <?php if ($cartCount > 0): ?><span class="cart-badge" id="cartBadge"><?= $cartCount ?></span><?php endif; ?>
        </a>
        <a class="icon-btn" href="<?= $isLoggedIn ? '/account' : '/auth/login' ?>" aria-label="Akun">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 12C14.4853 12 16.5 9.98528 16.5 7.5C16.5 5.01472 14.4853 3 12 3C9.51472 3 7.5 5.01472 7.5 7.5C7.5 9.98528 9.51472 12 12 12ZM12 12C16.4183 12 20 15.5817 20 20M12 12C7.58172 12 4 15.5817 4 20" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/></svg>
        </a>
    </div>

    <nav class="top-nav" aria-label="Navigasi utama">
        <div class="top-nav-inner">
            <a class="top-nav-link" href="/categories/35148/new-arrivals">New Arrivals</a>
            <a class="top-nav-link" href="/categories/35149/best-seller">Best Seller</a>
            <a class="top-nav-link" href="/categories/35150/for-you">Gift For You</a>
            <div class="top-nav-dropdown">
                <button class="top-nav-link top-nav-toggle" type="button">Limited Collaboration
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M6 9L12 15L18 9" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div class="top-nav-menu">
                    <a href="/categories/41446/toy-story-5">Toy Story 5</a>
                    <a href="/categories/40030/devil-wears-prada">Devil Wears Prada</a>
                    <a href="/categories/36893/zootopia">Zootopia</a>
                    <a href="/categories/36413/quby">Quby</a>
                    <a href="/categories/36415/disney-animals">Disney</a>
                </div>
            </div>
            <div class="top-nav-dropdown">
                <button class="top-nav-link top-nav-toggle" type="button">Categories
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M6 9L12 15L18 9" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div class="top-nav-menu">
                    <a href="/categories/36418/eye">Eye</a>
                    <a href="/categories/36419/face">Face</a>
                    <a href="/categories/36420/lip">Lip</a>
                    <a href="/categories/35164/beauty-tools">Beauty Tools</a>
                    <a href="/categories/36980/real-body-%26-soul-">REAL Body &amp; Soul</a>
                </div>
            </div>
            <a class="top-nav-link" href="/products">All Products</a>
            <?php if (session()->get('is_admin') == 1): ?>
            <a class="top-nav-link" href="/admin" style="font-weight:700;">Admin</a>
            <?php endif; ?>
            <a class="top-nav-link shake-shack" href="/categories/42471/get-3-for-81k!" style="color:#eb0000;">GET 3 FOR 81K!</a>
        </div>
    </nav>
</header>

<nav class="drawer" id="drawer">
    <div class="drawer-backdrop" id="drawerBackdrop"></div>
    <div class="drawer-panel">
        <div class="drawer-head">
            <img src="<?= base_url('assets/images/logo.webp') ?>" alt="Jacquelle" style="height:40px;width:auto;">
            <button class="icon-btn" id="btnDrawerClose" aria-label="Tutup">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M6 6L18 18M18 6L6 18" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
        </div>
        <div class="drawer-user">
        <?php if ($isLoggedIn): ?>
            <a href="/account">Halo, <?= esc($userName) ?></a>
            <a href="/auth/logout">Keluar</a>
        <?php else: ?>
            <a href="/auth/login">Masuk</a>
            <a href="/auth/register">Daftar Akun</a>
        <?php endif; ?>
        </div>
        <ul class="drawer-menu">
            <li><a href="/categories/35148/new-arrivals">New Arrivals</a></li>
            <li><a href="/categories/35149/best-seller">Best Seller</a></li>
            <li><a href="/categories/35150/for-you">Gift For You</a></li>
            <li>
                <button class="drawer-toggle" data-toggle="collab">Limited Collaboration
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M6 9L12 15L18 9" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <ul class="drawer-sub" data-sub="collab">
                    <li><a href="/categories/41446/toy-story-5">Toy Story 5</a></li>
                    <li><a href="/categories/40030/devil-wears-prada">Devil Wears Prada</a></li>
                    <li><a href="/categories/36893/zootopia">Zootopia</a></li>
                    <li><a href="/categories/36413/quby">Quby</a></li>
                    <li><a href="/categories/36415/disney-animals">Disney</a></li>
                </ul>
            </li>
            <li>
                <button class="drawer-toggle" data-toggle="cat">Categories
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M6 9L12 15L18 9" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <ul class="drawer-sub" data-sub="cat">
                    <li><a href="/categories/36418/eye">Eye</a></li>
                    <li><a href="/categories/36419/face">Face</a></li>
                    <li><a href="/categories/36420/lip">Lip</a></li>
                    <li><a href="/categories/35164/beauty-tools">Beauty Tools</a></li>
                    <li><a href="/categories/36980/real-body-%26-soul-">REAL Body &amp; Soul</a></li>
                </ul>
            </li>
            <li><a href="/products">All Products</a></li>
            <li><a href="/categories/42471/get-3-for-81k!" class="shake-shack" style="color:#eb0000;">GET 3 FOR 81K!</a></li>
        </ul>
    </div>
</nav>

<div class="search-dialog" id="searchDialog">
    <div class="search-backdrop" id="searchBackdrop"></div>
    <div class="search-panel">
        <div class="search-row">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M21 21L15.8033 15.8033M17.8 10.4C17.8 14.4868 14.5868 17.7 10.5 17.7C6.41325 17.7 3.2 14.4868 3.2 10.4C3.2 6.31325 6.41325 3.1 10.5 3.1C14.5868 3.1 17.8 6.31325 17.8 10.4Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/></svg>
            <form action="/products" method="get" class="search-form-wrap">
                <input type="text" name="q" id="searchInput" placeholder="Cari produk..." autocomplete="off">
            </form>
            <button type="button" class="search-close" id="btnSearchClose">Tutup</button>
        </div>

        <div class="search-body" id="searchBody">
            <!-- Pencarian Terbaru -->
            <div class="search-section" id="recentSection" style="display:none;">
                <div class="search-section-head">
                    <span class="search-section-title">Pencarian Terbaru</span>
                    <button class="search-clear-all" id="clearRecent">Hapus semua</button>
                </div>
                <div class="search-tags" id="recentTags"></div>
            </div>

            <!-- Pencarian Populer -->
            <div class="search-section">
                <div class="search-section-head">
                    <span class="search-section-title">Pencarian Populer</span>
                </div>
                <div class="search-tags" id="popularTags">
                    <a href="/products?q=lilac+bru" class="search-tag">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/></svg>
                        lilac bru
                    </a>
                    <a href="/products?q=blush" class="search-tag">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/></svg>
                        blush
                    </a>
                    <a href="/products?q=hrm+by+house+of+jacquelle" class="search-tag">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/></svg>
                        hrm by house of jacquelle
                    </a>
                    <a href="/products?q=acne+patch" class="search-tag">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/></svg>
                        acne patch
                    </a>
                    <a href="/products?q=blush+on" class="search-tag">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/></svg>
                        blush on
                    </a>
                    <a href="/products?q=concealer" class="search-tag">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/></svg>
                        concealer
                    </a>
                    <a href="/products?q=curved+brush" class="search-tag">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/></svg>
                        curved brush
                    </a>
                    <a href="/products?q=der+teufel" class="search-tag">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/></svg>
                        der teufel
                    </a>
                </div>
            </div>

            <!-- Baru Dilihat -->
            <div class="search-section" id="viewedSection" style="display:none;">
                <div class="search-section-head">
                    <span class="search-section-title">Baru Dilihat</span>
                </div>
                <div class="search-viewed-list" id="viewedList"></div>
            </div>
        </div>
    </div>
</div>

<!-- POPUP PROMO MODAL -->
<div class="promo-popup" id="promoPopup">
    <div class="promo-popup-backdrop" id="promoBackdrop"></div>
    <div class="promo-popup-panel">
        <button class="promo-popup-close" id="promoClose" aria-label="Tutup">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </button>
        <div class="promo-popup-content">
            <a href="/categories/41446/toy-story-5" id="promoLink" aria-label="Lihat promo Toy Story 5">
                <img src="<?= base_url('assets/images/popup-jacquelle.webp') ?>" alt="Popup Promo" class="promo-popup-img">
            </a>
        </div>
    </div>
</div>

<main class="p-main">
