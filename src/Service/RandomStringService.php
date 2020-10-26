<?php

namespace App\Service;

class RandomStringService
{
    public function randomString(int $length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i <= $length; $i++) {
             $string .= $characters[mt_rand(0, $max)];
        }
        return $string;
    }
}