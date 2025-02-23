<?php

use App\Models\AdpddInduk;
use App\Models\Desa;
use GuzzleHttp\Client;
use App\Models\Artikel;
use App\Models\ProfilBisnis;
use App\Models\AdsrtPermohonan;
use App\Models\LapakOrder;
use Illuminate\Support\Facades\DB;

if (!function_exists('totalCart')) {
  function totalCart()
  {
    $cart = session()->get('cart', []);
    $totalQuantity = array_sum(array_column($cart, 'quantity'));
    return $totalQuantity;
  }
}
if (!function_exists('infodesa')) {
  function infodesa($data)
  {
    $desa = DB::table("desas")->where('id', 1)->select($data)->first();
    return $desa->$data;
  }
}
if (!function_exists('klien')) {
  function klien($data)
  {
    $siklien = DB::table("perusahaan")->where('id', 1)->select($data)->first();
    return $siklien->$data;
  }
}
if (!function_exists('trending')) {
  function trending()
  {
    $trend = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
      ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'berita')
      ->select('artikels.*')
      ->latest()->limit(3)->get();
    return $trend;
  }
}
if (!function_exists('subtitle')) {
  function subtitle($subtitle, $icon)
  {
    $subtitle = ucwords(strtolower($subtitle));
    echo '<div class="page-header-icon"><i data-feather="' . $icon . '"></i></div>' . $subtitle;
    return;
  }
}
function kalender($tanggalDiDb)
{
  $bln   = array('');
  switch (date('m', strtotime($tanggalDiDb))) {
    case 1:
      $bln = array("Januari");
      break;
    case 2:
      $bln = array("Februari");
      break;
    case 3:
      $bln = array("Maret");
      break;
    case 4:
      $bln = array("April");
      break;
    case 5:
      $bln = array("Mei");
      break;
    case 6:
      $bln = array("Juni");
      break;
    case 7:
      $bln = array("Juli");
      break;
    case 8:
      $bln = array("Agustus");
      break;
    case 9:
      $bln = array("September");
      break;
    case 10:
      $bln = array("Oktober");
      break;
    case 11:
      $bln = array("November");
      break;
    case 12:
      $bln = array("Desember");
      break;
    default:
      break;
  }
  $tanggal = date('d', strtotime($tanggalDiDb)) . " " . $bln[0] . " " . date('Y', strtotime($tanggalDiDb));
  if ($tanggalDiDb == "0000-00-00" || $tanggalDiDb == "0000-00-00 00:00:00") {
    $tanggal = '';
  }
  return $tanggal;
}
function kal($tanggalDiDb)
{
  $bln   = array('');
  switch (date('m', strtotime($tanggalDiDb))) {
    case 1:
      $bln = array("Jan");
      break;
    case 2:
      $bln = array("Feb");
      break;
    case 3:
      $bln = array("Mar");
      break;
    case 4:
      $bln = array("Apr");
      break;
    case 5:
      $bln = array("Mei");
      break;
    case 6:
      $bln = array("Jun");
      break;
    case 7:
      $bln = array("Jul");
      break;
    case 8:
      $bln = array("Agt");
      break;
    case 9:
      $bln = array("Sep");
      break;
    case 10:
      $bln = array("Okt");
      break;
    case 11:
      $bln = array("Nov");
      break;
    case 12:
      $bln = array("Des");
      break;
    default:
      break;
  }
  $tanggal = date('d', strtotime($tanggalDiDb)) . " " . $bln[0] . " " . date('Y', strtotime($tanggalDiDb));
  if ($tanggalDiDb == "0000-00-00" || $tanggalDiDb == "0000-00-00 00:00:00") {
    $tanggal = '';
  }
  return $tanggal;
}
function tgldmY($tanggalDiDb)
{
  $tanggal = date('d-m-Y', strtotime($tanggalDiDb));
  if ($tanggalDiDb == "0000-00-00" || $tanggalDiDb == "0000-00-00 00:00:00") {
    $tanggal = '';
  }
  return $tanggal;
}
function tgljam($tanggalDiDb)
{
  $tanggal = date('d-m-Y H:i:s', strtotime($tanggalDiDb));
  if ($tanggalDiDb == "0000-00-00" || $tanggalDiDb == "0000-00-00 00:00:00") {
    $tanggal = '';
  }
  return $tanggal;
}
function romawi($tanggalDiDb)
{
  $bln   = '';
  $date = explode("-", $tanggalDiDb);
  if ($date[2] == 00) {
    $tanggal = "";
  } else {
    switch ($date[1]) {
      case 1:
        $bln = "I";
        break;
      case 2:
        $bln = "II";
        break;
      case 3:
        $bln = "III";
        break;
      case 4:
        $bln = "IV";
        break;
      case 5:
        $bln = "V";
        break;
      case 6:
        $bln = "VI";
        break;
      case 7:
        $bln = "VII";
        break;
      case 8:
        $bln = "VIII";
        break;
      case 9:
        $bln = "IX";
        break;
      case 10:
        $bln = "X";
        break;
      case 11:
        $bln = "XI";
        break;
      case 12:
        $bln = "XII";
        break;
      default:
        break;
    }
    $tanggal = $bln;
  }
  return $tanggal;
}

function tglYmd($tanggalDiDb)
{
  if ($tanggalDiDb <> '') :
    $date = explode("-", $tanggalDiDb);
    $tanggal = $date[2] . "-" . $date[1] . "-" . $date[0];
  else : $tanggal = '0000-00-00';
  endif;
  return $tanggal;
}

function hari($tanggalDiDb)
{
  $hr   = array('');
  $date = date("N", strtotime($tanggalDiDb));
  switch ($date) {
    case 1:
      $hr = array("Senin");
      break;
    case 2:
      $hr = array("Selasa");
      break;
    case 3:
      $hr = array("Rabu");
      break;
    case 4:
      $hr = array("Kamis");
      break;
    case 5:
      $hr = array("Jum'at");
      break;
    case 6:
      $hr = array("Sabtu");
      break;
    case 7:
      $hr = array("Minggu");
      break;
    default:
      break;
  }
  $tanggal = $hr[0];
  return $tanggal;
}
function bulan($tanggalDiDb)
{
  $bln   = '';
  $date = explode("-", $tanggalDiDb);
  if ($date[2] == 00) {
    $tanggal = "";
  } else {
    switch ($date[1]) {
      case 1:
        $bln = "Januari";
        break;
      case 2:
        $bln = "Februari";
        break;
      case 3:
        $bln = "Maret";
        break;
      case 4:
        $bln = "April";
        break;
      case 5:
        $bln = "Mei";
        break;
      case 6:
        $bln = "Juni";
        break;
      case 7:
        $bln = "Juli";
        break;
      case 8:
        $bln = "Agustus";
        break;
      case 9:
        $bln = "September";
        break;
      case 10:
        $bln = "Oktober";
        break;
      case 11:
        $bln = "November";
        break;
      case 12:
        $bln = "Desember";
        break;
      default:
        break;
    }
    $tanggal = $bln;
  }
  return $tanggal;
}
function enumselect($table = '', $field = '')
{
  $enums = array();
  if ($table == '' || $field == '') return $enums;
  $type = DB::select(DB::raw("SHOW COLUMNS FROM {$table} LIKE '{$field}'"))[0]->Type;
  preg_match_all("/'(.*?)'/", $type, $matches);
  foreach ($matches[1] as $value) {
    $enums[$value] = $value;
  }
  return $enums;
}
function warnaStatus($var)
{
  switch ($var) {
    case 'draft':
      $bgc = 'yellow';
      break;
    case 'pending review':
      $bgc = 'blue';
      break;
    case 'rejected':
      $bgc = 'red';
      break;
    case 'published':
      $bgc = 'green';
      break;
    case 'settlement':
      $bgc = 'green';
      break;
    case 'pending':
      $bgc = 'red';
      break;
    case 'proses':
      $bgc = 'yellow';
      break;
    case 'dikirim':
      $bgc = 'blue';
      break;
    case 'selesai':
      $bgc = 'green';
      break;
    case 'disetujui':
      $bgc = 'green';
      break;
    case 'ditolak':
      $bgc = 'black';
      break;
    case 'suspend':
      $bgc = 'black';
      break;
    default:
      $bgc = 'gray';
      break;
  }
  return $bgc;
}
function getFolderSize($folderPath)
{
  $totalSize = 0;
  $totalSpace = disk_total_space($folderPath);
  $freeSpace = disk_free_space($folderPath);
  $totalSize = $totalSpace - $freeSpace;
  return $totalSize;
}
function formatBytes($bytes, $precision = 2)
{
  $units = array('B', 'KB', 'MB', 'GB', 'TB');
  $bytes = max($bytes, 0);
  $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
  $pow = min($pow, count($units) - 1);
  $bytes /= pow(1024, $pow);
  return round($bytes, $precision) . ' ' . $units[$pow];
}
function convertToIndonesianDay($englishDay)
{
  $indonesianDays = [
    "Sunday" => "Minggu",
    "Monday" => "Senin",
    "Tuesday" => "Selasa",
    "Wednesday" => "Rabu",
    "Thursday" => "Kamis",
    "Friday" => "Jumat",
    "Saturday" => "Sabtu",
  ];
  return $indonesianDays[$englishDay];
}
function convertToColor($englishDay)
{
  $colorOfDays = [
    "Sunday" => "#ff0009",
    "Monday" => "#ff9900",
    "Tuesday" => "#63ed7a",
    "Wednesday" => "#6799aa",
    "Thursday" => "#99544b",
    "Friday" => "#6777ef",
    "Saturday" => "#117711",
  ];
  return $colorOfDays[$englishDay];
}
function safeDivision($numerator, $denominator)
{
  if ($denominator != 0) {
    $result = $numerator / $denominator;
    return $result;
  } else {
    return null;
  }
}
function ellipsis($string, $length = 50, $append = '...')
{
  if (strlen($string) > $length) {
    $string = substr($string, 0, $length) . $append;
  }
  return $string;
}
function terbilang($angka)
{
  $bilangan = [
    '',
    'satu',
    'dua',
    'tiga',
    'empat',
    'lima',
    'enam',
    'tujuh',
    'delapan',
    'sembilan',
    'sepuluh',
    'sebelas'
  ];

  if ($angka < 12) {
    return $bilangan[$angka];
  } elseif ($angka < 20) {
    return $bilangan[$angka - 10] . ' belas';
  } elseif ($angka < 100) {
    return $bilangan[floor($angka / 10)] . ' puluh ' . $bilangan[$angka % 10];
  } elseif ($angka < 200) {
    return 'seratus ' . terbilang($angka - 100);
  } elseif ($angka < 1000) {
    return $bilangan[floor($angka / 100)] . ' ratus ' . terbilang($angka % 100);
  } elseif ($angka < 2000) {
    return 'seribu ' . terbilang($angka - 1000);
  } elseif ($angka < 1000000) {
    return terbilang(floor($angka / 1000)) . ' ribu ' . terbilang($angka % 1000);
  } elseif ($angka < 1000000000) {
    return terbilang(floor($angka / 1000000)) . ' juta ' . terbilang($angka % 1000000);
  } elseif ($angka < 1000000000000) {
    return terbilang(floor($angka / 1000000000)) . ' miliar ' . terbilang($angka % 1000000000);
  } elseif ($angka < 1000000000000000) {
    return terbilang(floor($angka / 1000000000000)) . ' triliun ' . terbilang($angka % 1000000000000);
  } else {
    return 'Angka terlalu besar';
  }
}

if (!function_exists('total_reg_penduduk_baru')) {
  function total_reg_penduduk_baru()
  {
    $total_reg_penduduk_baru = AdpddInduk::where('mutasi', 'baru')->count();
    return $total_reg_penduduk_baru;
  }
}

function getSid($kategoriSid = null, $label = null, $request = null, $limit = 100)
{
  $client = new Client();
  try {
    $url = klien('endpoint') . '/' . $kategoriSid . '?apikey=' . klien('apikey') . '&search=' . $request . '&limit=' . $limit;
    $response = $client->request('GET', $url, ['http_errors' => false]);
  } catch (Exception $e) {
    $response = null;
    $data["endpoint"] = null;
    ProfilBisnis::where('id', 1)->update($data);
  }

  $rows = [];
  $jkn_label = [];
  $jkn_data = [];
  $jkn_color = [];

  if ($response !== null) {
    if ($response->getStatusCode() == 200) {
      $responseData = json_decode($response->getBody()->getContents())->data;
      if (!empty($responseData) && is_array($responseData)) {
        if ($label == 'pendidikan') {
          $row = array_map(function ($item) {
            return $item->pendidikan;
          }, $responseData);
        }
        if ($label == 'pekerjaan') {
          $row = array_map(function ($item) {
            return $item->pekerjaan;
          }, $responseData);
        }
        if ($label == 'hub-keluarga') {
          $row = array_map(function ($item) {
            return $item->hubungan;
          }, $responseData);
        }
        if ($label == 'jkn') {
          $jkn = array_map(function ($item) {
            return $item->jkn;
          }, $responseData);
          $jkn_label = array_map(function ($item) {
            return $item->jkn_label;
          }, $responseData);
          $jkn_data = array_map(function ($item) {
            return $item->jkn_data;
          }, $responseData);
          $jkn_color = array_map(function ($item) {
            return $item->jkn_color;
          }, $responseData);
        }
        if ($label == 'luas-wilayah') {
          $luas_wilayah = array_map(function ($item) {
            return $item->luas_wilayah;
          }, $responseData);
          $luas_wilayah_label = array_map(function ($item) {
            return $item->luas_wilayah_label;
          }, $responseData);
          $luas_wilayah_data = array_map(function ($item) {
            return $item->luas_wilayah_data;
          }, $responseData);
          $luas_wilayah_color = array_map(function ($item) {
            return $item->luas_wilayah_color;
          }, $responseData);
        }
      }
      if (!empty($responseData) && is_array($responseData)) {
        $rows = array_map(function ($item) {
          return (array) $item;
        }, $responseData);
      }
      if ($label == 'lembaga') {
        return isset($responseData) ? $responseData : [];
      } else if ($label == 'data-mutasi' || $label == 'jumlahpenduduk') {
        return $rows == null ? [] : (object) $rows[0];
      } else if ($label == 'kategori-usia') {
        return $rows == null ? [] : $rows[0];
      } else if ($label == 'jkn') {
        return compact('rows', 'jkn_label', 'jkn_data', 'jkn_color');
      } else if ($label == 'luas-wilayah') {
        return $rows == null ? [] : compact('rows', 'luas_wilayah_label', 'luas_wilayah_data', 'luas_wilayah_color');
      } else {
        return $rows;
      }
    }
  }
}

function cekAktivasi()
{
  $mac = getMacAddressLinux();
  if ($mac == null) {
    $mac = getSerialNumber();
  }
  if ($mac == null) {
    $mac = getMacAddress();
  }
  $init = substr(strtoupper(md5($mac)), 0, 9);
  $init = strtoupper(substr(md5($init), 5, 5));
  $cek1 = Desa::where('init', $init)->count();
  $cek2 = Desa::where('mcad', $mac)->count();
  $mcad = $mac;
  return compact('cek1', 'cek2', 'mcad');
}
function getMacAddress()
{
  ob_start();
  // system('ipconfig /all');
  shell_exec('ipconfig /all');
  $output = ob_get_clean();
  $findme = "Physical Address";
  $pos = strpos($output, $findme);
  if ($pos === false) {
    return null;
  }
  $macAddress = trim(substr($output, $pos + 36, 17));
  return $macAddress;
}
function getMacAddressLinux()
{
  ob_start();
  $output = shell_exec('ip link');
  // system('ifconfig');
  // $output = ob_get_clean();
  if (preg_match('/ether\s+([0-9a-f:]+)/', $output, $matches)) {
    return $matches[1];
  } else {
    return null;
  }
}
function getSerialNumber()
{
  $command = 'powershell "Get-WmiObject Win32_PhysicalMedia | Select-Object -ExpandProperty SerialNumber"';
  $output = shell_exec($command);
  $lines = explode("\n", trim($output));
  $serialNumbers = array_filter(array_map('trim', $lines), function ($line) {
    return !empty($line) && stripos($line, 'SerialNumber') === false;
  });
  $output = implode('', $serialNumbers);

  if (empty($output)) {
    return null;
  }
  return trim($output);
}

// function getSerialNumber()
// {
//   ob_start();
//   // system('wmic path win32_physicalmedia get SerialNumber');
//   shell_exec('wmic path win32_physicalmedia get SerialNumber');
//   $output = ob_get_clean();
//   $findme = "SerialNumber";
//   $pos = strpos($output, $findme);
//   if ($pos === false) {
//     return null;
//   }
//   $serialNumber = trim(substr($output, $pos + strlen($findme)));
//   return $serialNumber;
// }

function batasRowImport()
{
  return 500;
}

function waktuDelayImport()
{
  return 60;
}
