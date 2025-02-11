<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Helpers\GlobalHelper;
use App\Models\AdsrtKategori;
use App\Models\AdsrtPermohonan;

class AutoNumberHelper
{
    public static function initGenerateNumber($prefix, $date = '')
    {
        $data = [];
        // if (url('api') == klien('endpoint')) {
            $inisial = AdsrtKategori::first()->inisial;
            $awal = AdsrtKategori::first()->awal;
        // } else {
        //     $curl = curl_init();
        //     curl_setopt_array($curl, array(
        //         CURLOPT_URL => klien('endpoint') . '/kategori-surat',
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => '',
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 0,
        //         CURLOPT_FOLLOWLOCATION => true,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => 'GET',
        //     ));
        //     $response = curl_exec($curl);
        //     curl_close($curl);
        //     $kategori = json_decode($response)->data;
        //     $inisial = $kategori[0]->inisial;
        //     $awal = $kategori[0]->awal;
        // }

        if ($prefix == null || $prefix == "") {
            return response()->json([
                "status" => "error",
                "data" => "",
                "message" => "Prefix should exist!",
            ]);
        } else {
            switch ($prefix) {
                case "NOMOR":
                    $data = [
                        "class" => AdsrtPermohonan::class,
                        "field" => "nomor_surat",
                        "prefix" => $prefix,
                        "initial" => $inisial,
                        "start_from" => $awal,
                    ];
                    break;
                default:
                    echo "Perlu jasa pembuatan aplikasi web/android ? call me 085290724894";
            }
        }

        return self::generateNumber($data, $date);
    }

    private static function generateNumber($params, $date)
    {
        $prefix = $params['prefix'];
        $initial = $params['initial'];
        $start_from = $params['start_from'];

        $now = Carbon::now();

        $month_param = $now->month;
        $year_param = $now->year;

        if ($date != '') {
            $expl_date = explode('-', $date);
            if (count($expl_date) > 1) {
                $month_param = $expl_date[1];
                $year_param = $expl_date[0];
            }
        }

        $year = $year_param;
        $month = GlobalHelper::numberToRomanRepresentation($month_param);

        $number = '';
        // $number = '#' . date('ymd');
        $number = $prefix . '/';
        $sufix = '/' . $month . '/' . $initial . '/' . $year;
        // if (url('api') == klien('endpoint')) {
            $data = $params['class']::where($params['field'], 'like', '%' . $initial . '%')->orderBy('id', 'DESC')->first();
        // } else {
        //     $curl = curl_init();
        //     curl_setopt_array($curl, array(
        //         CURLOPT_URL => klien('endpoint') . '/surat-permohonan?' . $params['field'] . '=' . $initial,
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => '',
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 0,
        //         CURLOPT_FOLLOWLOCATION => true,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => 'GET',
        //     ));
        //     $response = curl_exec($curl);
        //     curl_close($curl);
        //     $datas = json_decode($response)->data;
        //     if (!empty($datas)) {
        //         $data = (array) $datas[0];
        //     } else {
        //         $data = null;
        //     }
        // }

        if ($data == null) {
            $number .= sprintf('%02d', $start_from);
        } else {
            $repeat = true;
            $last = explode('/', $data[$params['field']])[1];

            $new = sprintf('%02d', ++$last);
            while ($repeat) {
                // if (url('api') == klien('endpoint')) {
                    $data = $params['class']::where($params['field'], $number . $new)->first();
                // } else {
                //     $curl = curl_init();
                //     curl_setopt_array($curl, array(
                //         CURLOPT_URL => klien('endpoint') . '/surat-permohonan?' . $params['field'] . '=' . $number . $new,
                //         CURLOPT_RETURNTRANSFER => true,
                //         CURLOPT_ENCODING => '',
                //         CURLOPT_MAXREDIRS => 10,
                //         CURLOPT_TIMEOUT => 0,
                //         CURLOPT_FOLLOWLOCATION => true,
                //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //         CURLOPT_CUSTOMREQUEST => 'GET',
                //     ));
                //     $response = curl_exec($curl);
                //     curl_close($curl);
                //     $datas = json_decode($response)->data;
                //     if (!empty($datas)) {
                //         $data = (array) $datas[0];
                //     } else {
                //         $data = null;
                //     }
                // }
                if ($data == null) {
                    $repeat = false;
                    $number .= sprintf('%02d', $new);
                } else {
                    $new++;
                }
            }
        }
        return $number . $sufix;
    }
}
