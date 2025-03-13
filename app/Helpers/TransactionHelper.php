<?php

namespace App\Helpers;

class TransactionHelper
{
    public static function translateStatus($status)
    {
        $translations = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Dibayar',
            'processing' => 'Diproses',
            'shipping' => 'Dikirim',
            'delivered' => 'Diterima',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'failed' => 'Gagal'
        ];

        return $translations[strtolower($status)] ?? ucfirst($status);
    }
}
