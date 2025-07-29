<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Main extends Controller
{
    public function input()
    {
        $text = htmlspecialchars($this->request->getGet('text'), ENT_QUOTES, 'UTF-8');
        return view('input', ['text' => $text]);
    }

    public function checkout()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'item' => htmlspecialchars($this->request->getPost('item'), ENT_QUOTES, 'UTF-8'),
                'amount' => htmlspecialchars($this->request->getPost('amount'), ENT_QUOTES, 'UTF-8'),
                'submitted' => true,
            ];
            return view('checkout', $data);
        }
        return view('checkout', ['submitted' => false]);
    }
}