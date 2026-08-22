<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Admin - Jacquelle') ?></title>
    <link rel="icon" href="<?= base_url('assets/images/favicon.webp') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css?v=' . (filemtime(ROOTPATH . 'public/assets/css/admin.css') ?: 1)) ?>">
</head>
<body class="adm-body">
<div class="adm-shell">
    <aside class="adm-sidebar">
        <a class="adm-brand" href="/admin">Jacquelle<span>Panel Admin</span></a>
        <?php $tab = $tab ?? ''; ?>
        <nav class="adm-nav">
            <a href="/admin" class="<?= $tab === '' || $tab === 'dashboard' ? 'active' : '' ?>">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="9" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="14" y="3" width="7" height="5" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="14" y="12" width="7" height="9" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="3" y="16" width="7" height="5" rx="1.5" stroke="currentColor" stroke-width="2"/></svg>
                Dashboard
            </a>
            <a href="/admin/products" class="<?= $tab === 'products' ? 'active' : '' ?>">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M21 8L12 3L3 8V16L12 21L21 16V8Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M3 8L12 13L21 8M12 13V21" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                Produk
            </a>
            <a href="/admin/categories" class="<?= $tab === 'categories' ? 'active' : '' ?>">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M20.59 13.41L11 3.83A2 2 0 0 0 9.59 3.24H4A1 1 0 0 0 3 4.24V9.83A2 2 0 0 0 3.59 11.24L13.17 20.83A2 2 0 0 0 16 20.83L20.59 16.24A2 2 0 0 0 20.59 13.41Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><circle cx="7.5" cy="7.5" r="1.5" fill="currentColor"/></svg>
                Kategori
            </a>
            <a href="/admin/users" class="<?= $tab === 'users' ? 'active' : '' ?>">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="4" stroke="currentColor" stroke-width="2"/><path d="M2 21C2 17.13 5.13 14 9 14C12.87 14 16 17.13 16 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M16 4C17.93 4.55 19.36 6.3 19.36 8.44C19.36 10.58 17.93 12.33 16 12.88" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                User
            </a>
        </nav>
        <div class="adm-side-bottom">
            <a href="/" target="_blank" class="adm-view-site">
                <span>Lihat Website</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M14 5H19V10M19 5L9 15M10 19H6C4.9 19 4 18.1 4 17V7C4 5.9 4.9 5 6 5H10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <a href="/auth/logout" class="adm-logout">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M9 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3H9M16 17L21 12L16 7M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Keluar
            </a>
        </div>
    </aside>
    <main class="adm-main">
        <header class="adm-topbar">
            <div class="adm-topbar-left">
                <strong>Jacquelle</strong> / Panel Admin
            </div>
            <div class="adm-topbar-actions">
                <a href="/" target="_blank" class="adm-btn-site">
                    Lihat Website
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M14 5H19V10M19 5L9 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <span class="adm-admin-chip"><?= esc(session()->get('name') ?: 'Admin') ?></span>
            </div>
        </header>
        <div class="adm-content">
