/* ============================================================
   Jacquelle - JS (Swiper + scroll-reveal animations)
   ============================================================ */
(function () {
    'use strict';

    document.body.classList.add('anim-ready');

    /* ---------- Toasts auto-dismiss ---------- */
    document.querySelectorAll('.toast').forEach(function (t) {
        setTimeout(function () {
            t.style.opacity = '0';
            t.style.transition = 'opacity .4s ease-out';
            setTimeout(function () { t.remove(); }, 400);
        }, 4000);
    });

    /* ---------- Floating buttons ---------- */
    var awardBtn = document.querySelector('.floating-btn-award');
    if (awardBtn) {
        awardBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ---------- Scroll reveal animations ---------- */
    var revealEls = document.querySelectorAll('.animate-fade-in, .animate-to-top, .animate-to-bottom, .animate-to-left, .animate-to-right, .animate-zoom-in');
    if ('IntersectionObserver' in window && revealEls.length) {
        var revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add(entry.target.classList.contains('animate-to-top') ? 'animate-to-top--active'
                        : entry.target.classList.contains('animate-to-bottom') ? 'animate-to-bottom--active'
                        : entry.target.classList.contains('animate-to-left') ? 'animate-to-left--active'
                        : entry.target.classList.contains('animate-to-right') ? 'animate-to-right--active'
                        : entry.target.classList.contains('animate-zoom-in') ? 'animate-zoom-in--active'
                        : 'animate-fade-in--active');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.05 });
        revealEls.forEach(function (el) { revealObserver.observe(el); });
        setTimeout(function () {
            document.querySelectorAll('.animate-fade-in:not(.animate-fade-in--active), .animate-to-top:not(.animate-to-top--active), .animate-to-bottom:not(.animate-to-bottom--active), .animate-to-left:not(.animate-to-left--active), .animate-to-right:not(.animate-to-right--active), .animate-zoom-in:not(.animate-zoom-in--active)').forEach(function (el) {
                var r = el.getBoundingClientRect();
                if (r.top < window.innerHeight && r.bottom > 0) {
                    el.classList.add(el.classList.contains('animate-to-top') ? 'animate-to-top--active'
                        : el.classList.contains('animate-to-bottom') ? 'animate-to-bottom--active'
                        : el.classList.contains('animate-to-left') ? 'animate-to-left--active'
                        : el.classList.contains('animate-to-right') ? 'animate-to-right--active'
                        : el.classList.contains('animate-zoom-in') ? 'animate-zoom-in--active'
                        : 'animate-fade-in--active');
                }
            });
        }, 2000);
    } else {
        revealEls.forEach(function (el) {
            el.classList.add(el.classList.contains('animate-to-top') ? 'animate-to-top--active'
                : el.classList.contains('animate-to-bottom') ? 'animate-to-bottom--active'
                : el.classList.contains('animate-to-left') ? 'animate-to-left--active'
                : el.classList.contains('animate-to-right') ? 'animate-to-right--active'
                : el.classList.contains('animate-zoom-in') ? 'animate-zoom-in--active'
                : 'animate-fade-in--active');
        });
    }

    /* ---------- Swiper ---------- */
    function initSwiper(sel, opts) {
        var el = document.querySelector(sel);
        if (el && window.Swiper) {
            return new Swiper(el, opts);
        }
        return null;
    }

    /* Hero slideshow */
    initSwiper('.hero-swiper', {
        loop: false,
        speed: 700,
        autoplay: { delay: 6000, disableOnInteraction: false },
        pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
        navigation: {
            nextEl: '.hero-swiper .swiper-button-next',
            prevEl: '.hero-swiper .swiper-button-prev'
        }
    });

    /* Product carousels */
    var productSwiper = initSwiper('.product-swiper', {
        slidesPerView: 2, spaceBetween: 0, speed: 500,
        navigation: { nextEl: '#newNext', prevEl: '#newPrev' },
        breakpoints: { 600: { slidesPerView: 3, spaceBetween: 0 }, 1024: { slidesPerView: 5, spaceBetween: 0 } }
    });

    var swiperConfig2 = {
        slidesPerView: 2, spaceBetween: 0, speed: 500,
        breakpoints: { 600: { slidesPerView: 3, spaceBetween: 0 }, 1024: { slidesPerView: 5, spaceBetween: 0 } }
    };
    initSwiper('.product-swiper-2', Object.assign({}, swiperConfig2, {
        navigation: { nextEl: '#sec2Next', prevEl: '#sec2Prev' },
        slidesOffsetBefore: 0,
        breakpoints: {
            600: { slidesPerView: 3, spaceBetween: 0, slidesOffsetBefore: 0 },
            1024: { slidesPerView: 5, spaceBetween: 0, slidesOffsetBefore: 126 }
        }
    }));
    initSwiper('.product-swiper-3', Object.assign({}, swiperConfig2, { navigation: { nextEl: '#sec3Next', prevEl: '#sec3Prev' } }));
    initSwiper('.product-swiper-4', Object.assign({}, swiperConfig2, { navigation: { nextEl: '#sec4Next', prevEl: '#sec4Prev' } }));

    /* Video slideshow */
    var videoSwiper = initSwiper('.video-swiper', {
        slidesPerView: 3,
        spaceBetween: 8,
        speed: 500,
        autoplay: { delay: 3000, disableOnInteraction: false },
        loop: true,
        on: {
            slideChangeTransitionStart: function () {
                var active = this.slides[this.activeIndex];
                var v = active ? active.querySelector('video') : null;
                if (v && v.tagName === 'VIDEO') { v.currentTime = 0; v.play().catch(function () {}); }
            }
        },
        breakpoints: {
            600: { slidesPerView: 5, spaceBetween: 8 },
            1024: { slidesPerView: 8, spaceBetween: 8 }
        }
    });

    /* fade video section in after init */
    var videoSection = document.querySelector('.video-section');
    if (videoSection) { setTimeout(function () { videoSection.classList.add('visible'); }, 100); }

    /* play/pause videos when visible */
    if ('IntersectionObserver' in window) {
        var vobs = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                var v = e.target.querySelector('video');
                if (!v) return;
                if (e.isIntersecting) { v.play().catch(function () {}); }
                else { v.pause(); }
            });
        }, { threshold: 0.3 });
        document.querySelectorAll('.swiper-slide').forEach(function (s) {
            if (s.querySelector('video')) vobs.observe(s);
        });
    }

    /* ---------- Drawer ---------- */
    var drawer = document.getElementById('drawer');
    var btnMenu = document.getElementById('btnMenu');
    var btnClose = document.getElementById('btnDrawerClose');
    var backdrop = document.getElementById('drawerBackdrop');

    function openDrawer() { if (drawer) drawer.classList.add('open'); }
    function closeDrawer() { if (drawer) drawer.classList.remove('open'); }

    if (btnMenu) btnMenu.addEventListener('click', openDrawer);
    if (btnClose) btnClose.addEventListener('click', closeDrawer);
    if (backdrop) backdrop.addEventListener('click', closeDrawer);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { closeDrawer(); closeSearch(); closeProductsSidebar(); } });

    /* drawer submenu toggles */
    document.querySelectorAll('.drawer-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var key = btn.getAttribute('data-toggle');
            var sub = document.querySelector('[data-sub="' + key + '"]');
            var isOpen = sub && sub.classList.contains('open');
            document.querySelectorAll('.drawer-sub').forEach(function (s) { s.classList.remove('open'); });
            document.querySelectorAll('.drawer-toggle').forEach(function (b) { b.classList.remove('open'); });
            if (!isOpen && sub) { sub.classList.add('open'); btn.classList.add('open'); }
        });
    });

    /* products filter (mobile) */
    var productsSidebar = document.getElementById('productsSidebar');
    var productsBackdrop = document.getElementById('sidebarBackdrop');
    var btnProductsFilter = document.getElementById('productsFilterBtn');
    var btnSidebarClose = document.getElementById('sidebarClose');

    function openProductsSidebar() {
        if (productsSidebar) productsSidebar.classList.add('open');
        if (productsBackdrop) productsBackdrop.classList.add('show');
    }
    function closeProductsSidebar() {
        if (productsSidebar) productsSidebar.classList.remove('open');
        if (productsBackdrop) productsBackdrop.classList.remove('show');
    }
    if (btnProductsFilter) btnProductsFilter.addEventListener('click', openProductsSidebar);
    if (btnSidebarClose) btnSidebarClose.addEventListener('click', closeProductsSidebar);
    if (productsBackdrop) productsBackdrop.addEventListener('click', closeProductsSidebar);

    /* category "Lihat lainnya" toggle */
    var catMoreBtn = document.getElementById('catMoreBtn');
    var catMoreList = document.getElementById('catMoreList');
    if (catMoreBtn && catMoreList) {
        catMoreBtn.addEventListener('click', function () {
            var open = catMoreList.classList.toggle('open');
            catMoreBtn.classList.toggle('open', open);
        });
    }

    /* ---------- Search dialog ---------- */
    var searchDialog = document.getElementById('searchDialog');
    var btnSearch = document.getElementById('btnSearch');
    var btnSearchClose = document.getElementById('btnSearchClose');
    var searchBackdrop = document.getElementById('searchBackdrop');
    var searchInput = document.getElementById('searchInput');
    var recentSection = document.getElementById('recentSection');
    var recentTags = document.getElementById('recentTags');
    var clearRecent = document.getElementById('clearRecent');
    var viewedSection = document.getElementById('viewedSection');
    var viewedList = document.getElementById('viewedList');

    function getRecentSearches() {
        try { return JSON.parse(localStorage.getItem('jacquelle_recent_searches') || '[]'); }
        catch (e) { return []; }
    }
    function saveRecentSearch(q) {
        var arr = getRecentSearches().filter(function (s) { return s !== q; });
        arr.unshift(q);
        if (arr.length > 10) arr = arr.slice(0, 10);
        localStorage.setItem('jacquelle_recent_searches', JSON.stringify(arr));
    }
    function clearAllRecent() {
        localStorage.removeItem('jacquelle_recent_searches');
        renderRecentSearches();
    }
    function renderRecentSearches() {
        var arr = getRecentSearches();
        if (!recentSection || !recentTags) return;
        if (!arr.length) { recentSection.style.display = 'none'; return; }
        recentSection.style.display = '';
        recentTags.innerHTML = arr.map(function (q) {
            return '<a href="/products?q=' + encodeURIComponent(q) + '" class="search-tag">' + q.replace(/</g, '&lt;') + '</a>';
        }).join('');
    }

    function getRecentViewed() {
        try { return JSON.parse(localStorage.getItem('jacquelle_recent_viewed') || '[]'); }
        catch (e) { return []; }
    }
    function addRecentViewed(product) {
        var arr = getRecentViewed().filter(function (p) { return p.id !== product.id; });
        arr.unshift(product);
        if (arr.length > 6) arr = arr.slice(0, 6);
        localStorage.setItem('jacquelle_recent_viewed', JSON.stringify(arr));
    }
    function fmtPrice(n) { return 'Rp ' + String(n).replace(/\B(?=(\d{3})+(?!\d))/g, ','); }
    function renderRecentViewed() {
        var arr = getRecentViewed();
        if (!viewedSection || !viewedList) return;
        if (!arr.length) { viewedSection.style.display = 'none'; return; }
        viewedSection.style.display = '';
        viewedList.innerHTML = arr.map(function (p) {
            var priceHtml = '<span class="search-viewed-price">' + fmtPrice(p.price) + '</span>';
            if (p.oldPrice && p.oldPrice > p.price) {
                priceHtml = '<span class="search-viewed-price">' + fmtPrice(p.price) + ' <span class="price-old">' + fmtPrice(p.oldPrice) + '</span></span>';
            }
            return '<a href="/products/' + p.slug + '" class="search-viewed-item">' +
                '<img class="search-viewed-img" src="' + (p.image || '/assets/images/placeholder.webp') + '" alt="' + (p.name || '').replace(/"/g, '&quot;') + '">' +
                '<div class="search-viewed-info"><div class="search-viewed-name">' + (p.name || '').replace(/</g, '&lt;') + '</div>' + priceHtml + '</div></a>';
        }).join('');
    }

    function openSearch() {
        if (searchDialog) {
            searchDialog.classList.add('open');
            renderRecentSearches();
            renderRecentViewed();
        }
    }
    function closeSearch() { if (searchDialog) searchDialog.classList.remove('open'); }

    if (btnSearch) btnSearch.addEventListener('click', function () { openSearch(); setTimeout(function () {
        if (searchInput) searchInput.focus();
    }, 100); });
    if (btnSearchClose) btnSearchClose.addEventListener('click', closeSearch);
    if (searchBackdrop) searchBackdrop.addEventListener('click', closeSearch);
    if (clearRecent) clearRecent.addEventListener('click', clearAllRecent);

    /* Save search on form submit */
    var searchForm = searchDialog ? searchDialog.querySelector('form') : null;
    if (searchForm) {
        searchForm.addEventListener('submit', function () {
            var q = searchInput ? searchInput.value.trim() : '';
            if (q) saveRecentSearch(q);
        });
    }

    /* ---------- Wishlist toggle ---------- */
    function post(url, data) {
        return fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(data).toString()
        }).then(function (r) { return r.json(); });
    }

    function updateCartBadge(n) {
        var badge = document.getElementById('cartBadge');
        if (badge) {
            if (n > 0) { badge.textContent = n; badge.style.display = 'inline-flex'; }
            else { badge.style.display = 'none'; }
        }
    }

    document.querySelectorAll('.wishlist-btn[data-action="toggle"]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var id = btn.getAttribute('data-id');
            var active = btn.classList.contains('active');
            btn.classList.remove('animate-heart-beat');
            void btn.offsetWidth;
            btn.classList.add('animate-heart-beat');
            post('/wishlist/toggle', { id: id }).then(function (r) {
                if (r.added) {
                    btn.classList.add('active');
                    btn.style.animation = 'heartBeat .6s ease';
                    setTimeout(function () { btn.style.animation = ''; }, 600);
                } else {
                    btn.classList.remove('active');
                }
            });
        });
    });

    /* Wishlist page: remove & move to cart */
    document.querySelectorAll('.wish-remove').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var card = btn.closest('.product-card');
            post('/wishlist/remove', { id: btn.getAttribute('data-id') }).then(function () {
                if (card) card.remove();
                if (!document.querySelector('.wish-remove')) { location.reload(); }
            });
        });
    });

    document.querySelectorAll('.wish-move-cart').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var card = btn.closest('.product-card');
            var id = btn.getAttribute('data-id');
            btn.textContent = 'Dipindahkan...';
            post('/wishlist/move-to-cart', { id: id }).then(function (r) {
                updateCartBadge(r.cart_count);
                if (card) card.remove();
                if (!document.querySelector('.wish-remove')) { location.reload(); }
            });
        });
    });

    /* ---------- Add to cart (detail page) ---------- */
    function selectedVariant() {
        var sw = document.querySelector('.detail-swatch.active');
        return sw ? (sw.getAttribute('data-name') || '') : '';
    }

    document.querySelectorAll('.add-cart-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.getAttribute('data-id');
            var qty = document.getElementById('qtyInput') ? parseInt(document.getElementById('qtyInput').value, 10) : 1;
            btn.textContent = 'Menambahkan...';
            post('/cart/add', { id: id, qty: qty, variant: selectedVariant() }).then(function (r) {
                btn.textContent = 'Tambah ke Keranjang';
                updateCartBadge(r.count);
                var toast = document.createElement('div');
                toast.className = 'toast toast-success';
                toast.textContent = 'Produk ditambahkan ke keranjang.';
                var wrap = document.querySelector('.toast-wrap');
                if (wrap) {
                    wrap.appendChild(toast);
                    setTimeout(function () { toast.remove(); }, 2600);
                }
            });
        });
    });

    /* ---------- Product detail: variant swatches ---------- */
    function fmtRp(n) {
        return 'Rp ' + String(n).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    document.querySelectorAll('.detail-swatch').forEach(function (sw) {
        sw.addEventListener('click', function () {
            document.querySelectorAll('.detail-swatch').forEach(function (s) { s.classList.remove('active'); });
            sw.classList.add('active');
            var img = document.getElementById('mainDetailImg');
            var src = sw.getAttribute('data-src');
            if (img && src) { img.src = src; img.setAttribute('srcset', ''); }
            var priceBox = document.querySelector('.detail-price');
            var priceEl = priceBox ? priceBox.querySelector('.price-sale') : null;
            var oldEl = priceBox ? priceBox.querySelector('.price-old') : null;
            var price = parseInt(sw.getAttribute('data-price'), 10) || 0;
            var old = parseInt(sw.getAttribute('data-oldprice'), 10) || 0;
            if (priceEl && price > 0) {
                priceEl.textContent = fmtRp(price);
            }
            if (oldEl) {
                if (old > price) {
                    oldEl.textContent = fmtRp(old);
                    oldEl.style.display = '';
                } else {
                    oldEl.style.display = 'none';
                }
            }
        });
    });

    /* ---------- Buy now (detail page) ---------- */
    document.querySelectorAll('.buy-now-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.getAttribute('data-id');
            var qty = document.getElementById('qtyInput') ? parseInt(document.getElementById('qtyInput').value, 10) : 1;
            btn.textContent = 'Memproses...';
            post('/cart/add', { id: id, qty: qty, variant: selectedVariant() }).then(function (r) {
                updateCartBadge(r.count);
                window.location.href = '/cart/checkout';
            }).catch(function () {
                btn.textContent = 'Beli Sekarang';
            });
        });
    });

    /* ---------- Cart page: qty & remove ---------- */
    function refreshCartTotals() {
        var lines = document.querySelectorAll('.cart-row');
        var subtotal = 0;
        lines.forEach(function (row) {
            var lt = row.querySelector('.cart-line-total');
            if (lt) subtotal += parseInt(lt.getAttribute('data-amount'), 10) || 0;
        });
        var total = subtotal + 9000;
        var s = document.getElementById('sum-subtotal');
        var t = document.getElementById('sum-total');
        if (s) s.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        if (t) t.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.querySelectorAll('.qty-plus').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var key = btn.getAttribute('data-key');
            var row = btn.closest('.cart-row');
            var val = row.querySelector('.qty-val');
            var qty = parseInt(val.textContent, 10) + 1;
            post('/cart/update', { key: key, qty: qty }).then(function (r) {
                val.textContent = qty;
                var lt = row.querySelector('.cart-line-total');
                if (lt) { lt.textContent = 'Rp ' + r.line.toLocaleString('id-ID'); lt.setAttribute('data-amount', r.line); }
                updateCartBadge(r.count);
                refreshCartTotals();
            });
        });
    });

    document.querySelectorAll('.qty-minus').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var key = btn.getAttribute('data-key');
            var row = btn.closest('.cart-row');
            var val = row.querySelector('.qty-val');
            var qty = parseInt(val.textContent, 10) - 1;
            if (qty < 1) {
                post('/cart/remove', { key: key }).then(function (r) {
                    row.remove();
                    updateCartBadge(r.count);
                    refreshCartTotals();
                    if (!document.querySelector('.cart-row')) location.reload();
                });
                return;
            }
            post('/cart/update', { key: key, qty: qty }).then(function (r) {
                val.textContent = qty;
                var lt = row.querySelector('.cart-line-total');
                if (lt) { lt.textContent = 'Rp ' + r.line.toLocaleString('id-ID'); lt.setAttribute('data-amount', r.line); }
                updateCartBadge(r.count);
                refreshCartTotals();
            });
        });
    });

    document.querySelectorAll('.cart-remove').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var key = btn.getAttribute('data-key');
            var row = btn.closest('.cart-row');
            post('/cart/remove', { key: key }).then(function (r) {
                row.remove();
                updateCartBadge(r.count);
                refreshCartTotals();
                if (!document.querySelector('.cart-row')) location.reload();
            });
        });
    });

    /* ---------- Promo popup ---------- */
    var promoPopup = document.getElementById('promoPopup');
    var promoClose = document.getElementById('promoClose');
    var promoBackdrop = document.getElementById('promoBackdrop');

    function openPromoPopup() {
        if (promoPopup && (window.location.pathname === '/' || window.location.pathname === '/home')) {
            setTimeout(function () { promoPopup.classList.add('open'); }, 1200);
        }
    }
    function closePromoPopup() {
        if (promoPopup) promoPopup.classList.remove('open');
    }
    if (promoClose) promoClose.addEventListener('click', closePromoPopup);
    if (promoBackdrop) promoBackdrop.addEventListener('click', closePromoPopup);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closePromoPopup(); });
    openPromoPopup();

    /* ---------- Top nav dropdowns ---------- */
    document.querySelectorAll('.top-nav-dropdown').forEach(function (dd) {
        dd.addEventListener('mouseenter', function () {
            document.querySelectorAll('.top-nav-dropdown').forEach(function (d) { d.classList.remove('open'); });
            dd.classList.add('open');
        });
        dd.addEventListener('mouseleave', function () {
            dd.classList.remove('open');
        });
    });
    document.querySelectorAll('.top-nav-toggle').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var dd = btn.closest('.top-nav-dropdown');
            var isOpen = dd && dd.classList.contains('open');
            document.querySelectorAll('.top-nav-dropdown').forEach(function (d) { d.classList.remove('open'); });
            if (!isOpen && dd) dd.classList.add('open');
        });
    });
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.top-nav-dropdown')) {
            document.querySelectorAll('.top-nav-dropdown').forEach(function (d) { d.classList.remove('open'); });
        }
    });

    /* ---------- Product detail gallery ---------- */
    document.querySelectorAll('.detail-thumbs .thumb').forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            var main = document.getElementById('mainDetailImg');
            var src = thumb.getAttribute('data-src');
            if (!main || !src) return;
            main.src = src;
            document.querySelectorAll('.detail-thumbs .thumb').forEach(function (t) { t.classList.remove('active'); });
            thumb.classList.add('active');
        });
    });
})();
