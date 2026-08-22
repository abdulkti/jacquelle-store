<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function placeholder(string $page)
    {
        $titles = [
            'wishlist' => 'Wishlist',
            'cart'     => 'Keranjang',
            'orders'   => 'Pesanan',
        ];

        if ($page === 'account') {
            return $this->response->redirect('/account');
        }

        $title = $titles[$page] ?? 'Jacquelle';

        return view('pages/placeholder', [
            'title'  => $title . ' - Jacquelle',
            'page'   => $page,
            'name'   => $title,
            'active' => $page,
        ]);
    }
}
