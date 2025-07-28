<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Main extends Controller
{
    public function input()
    {
        $text = $this->request->getGet('text');
        return view('input', ['text' => $text]);
    }

    public function checkout()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'item' => $this->request->getPost('item'),
                'amount' => $this->request->getPost('amount'),
                'submitted' => true,
            ];
            return view('checkout', $data);
        }
        return view('checkout', ['submitted' => false]);
    }
}

