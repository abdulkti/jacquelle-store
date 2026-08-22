<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data = [
            'title'  => 'Masuk - Jacquelle',
            'active' => 'login',
        ];

        if ($this->request->is('post')) {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required',
            ];

            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $model = new UserModel();
            $user  = $model->where('email', $this->request->getPost('email'))->first();

            if ($user && password_verify($this->request->getPost('password'), $user['password_hash'])) {
                session()->set([
                    'id'         => $user['id'],
                    'name'       => $user['name'],
                    'email'      => $user['email'],
                    'is_admin'   => $user['is_admin'],
                    'isLoggedIn' => true,
                ]);

                return redirect()->to($this->request->getPost('redirect') ?: '/')->with('success', 'Selamat datang kembali, ' . $user['name'] . '!');
            }

            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        return view('auth/login', $data);
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data = [
            'title'  => 'Daftar Akun - Jacquelle',
            'active' => 'register',
        ];

        if ($this->request->is('post')) {
            $rules = [
                'name'     => 'required|min_length[3]|max_length[100]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'phone'    => 'permit_empty|max_length[25]',
                'password' => 'required|min_length[6]',
                'passconf' => 'required|matches[password]',
            ];

            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $model = new UserModel();
            $model->save([
                'name'          => $this->request->getPost('name'),
                'email'         => $this->request->getPost('email'),
                'phone'         => $this->request->getPost('phone'),
                'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            ]);

            $user = $model->where('email', $this->request->getPost('email'))->first();

            session()->set([
                'id'         => $user['id'],
                'name'       => $user['name'],
                'email'      => $user['email'],
                'is_admin'   => $user['is_admin'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/')->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $user['name'] . '!');
        }

        return view('auth/register', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Anda telah keluar.');
    }

    public function account()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $data = [
            'title'  => 'Akun Saya - Jacquelle',
            'active' => 'account',
            'user'   => session()->get(),
        ];

        return view('auth/account', $data);
    }
}
