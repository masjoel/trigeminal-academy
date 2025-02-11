<?php

use App\Models\AdpddInduk;
use App\Models\AdprofLembaga;
$statistics = AdpddInduk::selectRaw('SUM(CASE WHEN mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_pdd, SUM(CASE WHEN hubungan = "Kepala Keluarga" AND mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_kk, SUM(CASE WHEN gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_lk, SUM(CASE WHEN gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_pr')->first();
        $statmutasi = AdpddInduk::selectRaw('SUM(CASE WHEN mutasi = "Lahir" THEN 1 ELSE 0 END) as total_lahir, SUM(CASE WHEN mutasi = "Datang" THEN 1 ELSE 0 END) as total_datang, SUM(CASE WHEN mutasi = "Pindah" THEN 1 ELSE 0 END) as total_pindah, SUM(CASE WHEN mutasi = "Meninggal" THEN 1 ELSE 0 END) as total_mati')->first();
        $kategoriUsia = AdpddInduk::selectRaw(
            'SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 0 and 13) THEN 1 ELSE 0 END) as u_anak_l, 
            SUM(CASE WHEN (gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 0 and 13) THEN 1 ELSE 0 END) as u_anak_p,
            SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 13 and 18) THEN 1 ELSE 0 END) as u_remaja_l, 
            SUM(CASE WHEN (gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 13 and 18) THEN 1 ELSE 0 END) as u_remaja_p,
            SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 18 and 66) THEN 1 ELSE 0 END) as u_dewasa_l, 
            SUM(CASE WHEN (gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 18 and 66) THEN 1 ELSE 0 END) as u_dewasa_p,
            SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) > 65) THEN 1 ELSE 0 END) as u_lansia_l, 
            SUM(CASE WHEN (gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) > 65) THEN 1 ELSE 0 END) as u_lansia_p'
        )->first();

        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 0 and 3) THEN 1 ELSE 0 END)as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 0 and 3) THEN 1 ELSE 0 END)as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 4 and 5) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 4 and 5) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 6 and 12) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 6 and 12) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 13 and 16) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 13 and 16) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) = 17) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) = 17) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 18 and 25) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 18 and 25) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 26 and 30) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 26 and 30) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 31 and 35) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 31 and 35) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 36 and 40) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 36 and 40) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 41 and 65) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 41 and 65) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 66 and 70) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 66 and 70) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 71 and 80) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 71 and 80) THEN 1 ELSE 0 END) as pr')->first()->toArray();
        $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) > 80) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) > 80) THEN 1 ELSE 0 END) as pr')->first()->toArray();

        $pendidikan = AdpddInduk::selectRaw('distinct pendidikan')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->orderBy('pendidikan')->pluck('pendidikan')->toArray();
        $pekerjaan = AdpddInduk::selectRaw('distinct pekerjaan')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->orderBy('pekerjaan')->pluck('pekerjaan')->toArray();
        $hub_klg = AdpddInduk::selectRaw('distinct hubungan')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->orderBy('hubungan')->pluck('hubungan')->toArray();
        $jkn = AdpddInduk::selectRaw('distinct jkn')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->orderBy('jkn')->pluck('jkn')->toArray();

        $v_usia = ['0 - 3th', '4 - 5th', '6 - 12th', '13 - 16th', '17th', '18 - 25th', '26 - 30th', '31 - 35th', '36 - 40th', '41 - 65th', '66 - 70th', '71 - 80th', '> 80th'];

        // join between $usia[] and $v_usia;
        $usia = array_combine($v_usia, $usia);
        $u_lk = [];
        $u_pr = [];
        $l_anak = [];
        $l_remaja = [];
        $l_dewasa = [];
        $l_lansia = [];
        $u_anak_lk = [];
        $u_anak_pr = [];
        $u_remaja_lk = [];
        $u_remaja_pr = [];
        $u_dewasa_lk = [];
        $u_dewasa_pr = [];
        $u_lansia_lk = [];
        $u_lansia_pr = [];
        $wn = [
            'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary','bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary',
        ];
        $color = [
            'blue', 'cyan', 'green', 'red', 'orange', 'teal', 'yellow',
        ];