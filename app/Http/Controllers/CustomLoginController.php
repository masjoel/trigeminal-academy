<?php

namespace App\Http\Controllers;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

class CustomLoginController extends AuthenticatedSessionController
{
    public function modif($input = null)
    {
        $email = $input;
        $mcad = cekAktivasi()['mcad'];
        $cek1 = cekAktivasi()['cek1'];
        $cek2 = cekAktivasi()['cek2'];
        return view('auth.login', compact('mcad', 'cek1', 'cek2', 'email'));
    }
}
