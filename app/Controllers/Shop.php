<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Shop extends BaseController
{
    private function getCart(): array
    {
        $cart = session()->get('cart');
        return is_array($cart) ? $cart : [];
    }

    private function saveCart(array $cart): void
    {
        session()->set('cart', $cart);
    }

    private function getWishlist(): array
    {
        $wish = session()->get('wishlist');
        return is_array($wish) ? $wish : [];
    }

    private function saveWishlist(array $wish): void
    {
        session()->set('wishlist', $wish);
    }

    public function cartCount(): int
    {
        $cart = $this->getCart();
        return array_sum($cart);
    }

    public function cart()
    {
        $cart     = $this->getCart();
        $products = $this->loadProducts($cart);
        $subtotal = 0;
        foreach ($products as &$p) {
            $subtotal += $p['price'] * $p['qty'];
        }
        unset($p);

        return view('shop/cart', [
            'title'    => 'Keranjang Belanja - Jacquelle',
            'active'   => 'cart',
            'cart'     => $products,
            'subtotal' => $subtotal,
            'shipping' => 9000,
            'total'    => $subtotal + 9000,
        ]);
    }

    public function cartAdd()
    {
        $id      = (int) $this->request->getPost('id');
        $qty     = max(1, (int) $this->request->getPost('qty'));
        $variant = trim((string) $this->request->getPost('variant'));
        $key     = $id . '|' . $variant;
        if ((new ProductModel())->find($id)) {
            $cart       = $this->getCart();
            $cart[$key] = ($cart[$key] ?? 0) + $qty;
            $this->saveCart($cart);
        }

        return $this->response->setJSON([
            'ok'    => true,
            'count' => $this->cartCount(),
        ]);
    }

    public function cartUpdate()
    {
        $key  = (string) $this->request->getPost('key');
        $qty  = (int) $this->request->getPost('qty');
        $cart = $this->getCart();
        if ($qty > 0 && isset($cart[$key])) {
            $cart[$key] = $qty;
        } else {
            unset($cart[$key]);
        }
        $this->saveCart($cart);

        $products = $this->loadProducts($cart);
        $subtotal = 0;
        foreach ($products as $p) {
            $subtotal += $p['price'] * $p['qty'];
        }

        return $this->response->setJSON([
            'ok'       => true,
            'count'    => $this->cartCount(),
            'subtotal' => $subtotal,
            'total'    => $subtotal + 9000,
            'line'     => $this->lineTotal($products, $key),
        ]);
    }

    public function cartRemove()
    {
        $key  = (string) $this->request->getPost('key');
        $cart = $this->getCart();
        unset($cart[$key]);
        $this->saveCart($cart);

        return $this->response->setJSON([
            'ok'    => true,
            'count' => $this->cartCount(),
        ]);
    }

    public function wishlist()
    {
        $wish     = $this->getWishlist();
        $products = $this->loadProducts(array_fill_keys($wish, 1));

        return view('shop/wishlist', [
            'title'    => 'Wishlist - Jacquelle',
            'active'   => 'wishlist',
            'products' => $products,
        ]);
    }

    public function wishlistToggle()
    {
        $id   = (int) $this->request->getPost('id');
        $wish = $this->getWishlist();
        $added = false;

        if (in_array($id, $wish)) {
            $wish = array_values(array_filter($wish, fn ($w) => (int) $w !== $id));
        } else {
            $wish[] = $id;
            $added = true;
        }
        $this->saveWishlist($wish);

        return $this->response->setJSON(['ok' => true, 'added' => $added, 'count' => count($wish)]);
    }

    public function wishlistRemove()
    {
        $id   = (int) $this->request->getPost('id');
        $wish = $this->getWishlist();
        $wish = array_values(array_filter($wish, fn ($w) => (int) $w !== $id));
        $this->saveWishlist($wish);

        return $this->response->setJSON(['ok' => true, 'count' => count($wish)]);
    }

    public function wishlistMoveToCart()
    {
        $id   = (int) $this->request->getPost('id');
        $wish = $this->getWishlist();
        $cart = $this->getCart();
        $wish = array_values(array_filter($wish, fn ($w) => (int) $w !== $id));
        if ((new ProductModel())->find($id)) {
            $key         = $id . '|';
            $cart[$key]  = ($cart[$key] ?? 0) + 1;
        }
        $this->saveWishlist($wish);
        $this->saveCart($cart);

        return $this->response->setJSON([
            'ok'        => true,
            'count'     => count($wish),
            'cart_count' => $this->cartCount(),
        ]);
    }

    public function checkout()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan masuk terlebih dahulu untuk checkout.');
        }

        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->to('/cart')->with('warn', 'Keranjang masih kosong.');
        }

        $products = $this->loadProducts($cart);
        $subtotal = 0;
        foreach ($products as $p) {
            $subtotal += $p['price'] * $p['qty'];
        }

        return view('shop/checkout', [
            'title'    => 'Checkout - Jacquelle',
            'active'   => 'checkout',
            'cart'     => $products,
            'subtotal' => $subtotal,
            'shipping' => 9000,
            'total'    => $subtotal + 9000,
        ]);
    }

    public function checkoutSubmit()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->to('/cart')->with('warn', 'Keranjang masih kosong.');
        }

        $rules = [
            'name'    => 'required|min_length[3]',
            'phone'   => 'required|min_length[8]',
            'address' => 'required|min_length[10]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $products = $this->loadProducts($cart);
        $subtotal = 0;
        foreach ($products as $p) {
            $subtotal += $p['price'] * $p['qty'];
        }
        $shipping = 9000;
        $total    = $subtotal + $shipping;

        $db = \Config\Database::connect();
        $orderNumber = 'JQL' . date('Ymd') . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

        $db->transBegin();
        $db->table('orders')->insert([
            'order_number'    => $orderNumber,
            'user_id'         => session()->get('id') ?: null,
            'customer_name'   => $this->request->getPost('name'),
            'customer_email'  => session()->get('email') ?: '',
            'customer_phone'  => $this->request->getPost('phone'),
            'address'         => $this->request->getPost('address'),
            'subtotal'        => $subtotal,
            'shipping_fee'    => $shipping,
            'total'           => $total,
            'payment_method'  => $this->request->getPost('payment_method') ?: 'transfer',
            'notes'           => $this->request->getPost('notes') ?: null,
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);
        $orderId = (int) $db->insertID();

        foreach ($products as $p) {
            $db->table('order_items')->insert([
                'order_id'      => $orderId,
                'product_id'    => $p['id'],
                'product_name'  => $p['name'],
                'variant_name'  => $p['variant'] ?: null,
                'product_image' => $p['image'],
                'price'         => $p['price'],
                'qty'           => $p['qty'],
            ]);
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal menyimpan pesanan. Coba lagi.');
        }
        $db->transCommit();

        $this->saveCart([]);

        return redirect()->to('/orders/' . $orderId)->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function orders()
    {
        $builder = \Config\Database::connect()->table('orders');
        if (session()->get('id')) {
            $builder->where('user_id', session()->get('id'));
        } else {
            $builder->where('user_id', 0);
        }
        $orders = $builder->orderBy('id', 'DESC')->limit(50)->get()->getResultArray();

        return view('shop/orders', [
            'title'  => 'Pesanan Saya - Jacquelle',
            'active' => 'orders',
            'orders' => $orders,
        ]);
    }

    public function orderDetail($id)
    {
        $db = \Config\Database::connect();
        $order = $db->table('orders')->where('id', (int) $id)->get()->getRowArray();
        if (! $order) {
            return $this->response->setStatusCode(404)->setBody(view('shop/orders', [
                'title' => 'Pesanan Tidak Ditemukan - Jacquelle',
                'active' => 'orders',
                'orders' => [],
                'notFound' => true,
            ]));
        }

        $items = $db->table('order_items')->where('order_id', $order['id'])->orderBy('id')->get()->getResultArray();

        return view('shop/order_detail', [
            'title' => 'Pesanan ' . $order['order_number'] . ' - Jacquelle',
            'active' => 'orders',
            'order' => $order,
            'items' => $items,
        ]);
    }

    private function loadProducts(array $cart): array
    {
        if (empty($cart)) {
            return [];
        }

        $ids = [];
        foreach (array_keys($cart) as $key) {
            [$id] = explode('|', $key, 2);
            $ids[(int) $id] = 1;
        }
        $rows = (new ProductModel())->whereIn('id', array_keys($ids))->findAll();
        $byId = [];
        foreach ($rows as $r) {
            $r['old_price'] = $r['price'];
            $r['price']     = $r['sale_price'] ?: $r['price'];
            $byId[(int) $r['id']] = $r;
        }

        $out = [];
        foreach ($cart as $key => $qty) {
            [$id, $variant] = array_pad(explode('|', $key, 2), 2, '');
            $id = (int) $id;
            if (! isset($byId[$id])) {
                continue;
            }
            $p = $byId[$id];
            $p['qty']     = $qty;
            $p['variant'] = $variant;
            $p['cart_key'] = $key;
            if ($variant !== '') {
                $variants = is_string($p['variants'] ?? '') ? json_decode($p['variants'], true) : ($p['variants'] ?? []);
                if (is_array($variants)) {
                    foreach ($variants as $v) {
                        if (($v['name'] ?? '') === $variant) {
                            if (! empty($v['image'])) {
                                $p['image'] = $v['image'];
                            }
                            if (! empty($v['price'])) {
                                $p['old_price'] = (int) ($v['old_price'] ?? $p['price']);
                                $p['price']     = (int) $v['price'];
                            }
                            break;
                        }
                    }
                }
            }
            $out[] = $p;
        }

        return $out;
    }

    private function lineTotal(array $products, string $key): int
    {
        foreach ($products as $p) {
            if ($p['cart_key'] === $key) {
                return $p['price'] * $p['qty'];
            }
        }

        return 0;
    }
}
