<?php

namespace App\Helpers;

use App\Models\SSP;
use App\Models\Artikel;
use App\Models\LinkExternal;
use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class CustomHelper
{
  // if (!function_exists('klien')) {
  public static function klien($data)
  {
    $siklien = DB::table("perusahaan")->where('id', 1)->select($data)->first();
    return $siklien->$data;
  }
  // }
  // if (!function_exists('trending')) {
  //   function trending()
  //   {
  //     $trend = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
  //     ->where('artikels.jenis', 'post')->where('artikels.tampil', 'published')->where('categories.slug', '=', 'berita')
  //     ->select('artikels.*')
  //     ->latest()->limit(3)->get();
  //     return $trend;
  //   }
  // }
  // if (!function_exists('subtitle')) {
  public static function subtitle($subtitle, $icon)
  {
    $subtitle = ucwords(strtolower($subtitle));
    echo '<div class="page-header-icon"><i data-feather="' . $icon . '"></i></div>' . $subtitle;
    return;
  }
  // }
  public static function kalender($tanggalDiDb)
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
  public static function kal($tanggalDiDb)
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
  public static function tgldmY($tanggalDiDb)
  {
    $tanggal = date('d-m-Y', strtotime($tanggalDiDb));
    if ($tanggalDiDb == "0000-00-00" || $tanggalDiDb == "0000-00-00 00:00:00") {
      $tanggal = '';
    }
    return $tanggal;
  }
  public static function tgljam($tanggalDiDb)
  {
    $tanggal = date('d-m-Y H:i:s', strtotime($tanggalDiDb));
    if ($tanggalDiDb == "0000-00-00" || $tanggalDiDb == "0000-00-00 00:00:00") {
      $tanggal = '';
    }
    return $tanggal;
  }
  public static function romawi($tanggalDiDb)
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

  public static function tglYmd($tanggalDiDb)
  {
    if ($tanggalDiDb <> '') :
      $date = explode("-", $tanggalDiDb);
      $tanggal = $date[2] . "-" . $date[1] . "-" . $date[0];
    else : $tanggal = '0000-00-00';
    endif;
    return $tanggal;
  }

  public static function hari($tanggalDiDb)
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
  public static function bulan($tanggalDiDb)
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
  public static function enumselect($table = '', $field = '')
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
  public static function warnaStatus($var)
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
  public static function getFolderSize($folderPath)
  {
    $totalSize = 0;
    $totalSpace = disk_total_space($folderPath);
    $freeSpace = disk_free_space($folderPath);
    $totalSize = $totalSpace - $freeSpace;
    return $totalSize;
  }
  public static function formatBytes($bytes, $precision = 2)
  {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
  }
  public static function convertToIndonesianDay($englishDay)
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
  public static function convertToColor($englishDay)
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

  public static function getMenu()
  {
    $user = auth()->user();
    $roles = $user->roles;
    $permissions = $user->permissions;

    // Dapatkan semua menu item
    $menuItems = MenuItem::all();

    // Filter menu berdasarkan roles dan permissions
    $filteredMenuItems = $menuItems->filter(function ($menuItem) use ($roles, $permissions) {
      // Cek apakah user memiliki role yang dibutuhkan untuk menu item
      if ($menuItem->required_role && !$roles->contains('judul', $menuItem->required_role)) {
        return false;
      }

      // Cek apakah user memiliki permission yang dibutuhkan untuk menu item
      if ($menuItem->required_permission && !$permissions->contains('judul', $menuItem->required_permission)) {
        return false;
      }

      return true;
    });

    // Susun struktur menu sesuai hierarki
    $structuredMenu = $filteredMenuItems->mapWithKeys(function ($item) {
      return [$item->id => $item];
    })->groupBy('parent_id');

    $topLevelItems = $structuredMenu->get(null); // Items without a parent


    return $filteredMenuItems;
  }

  public static function linkExternal()
  {
    $data = LinkExternal::where('tipe', 'external')->orderBy('id', 'asc')->get();
    $list = '';
    foreach ($data as $dt) {
      $list .= '<li><a href="' . htmlentities($dt->url_ext, ENT_QUOTES, 'UTF-8') . '" target="_blank"><i class="fa fa-globe float-left me-2"></i>' . htmlentities($dt->keterangan, ENT_QUOTES, 'UTF-8') . '</a></li>';
    }
    return $list;
  }

  public static function linkMedsos()
  {
    $data = LinkExternal::where('tipe', 'medsos')->orderBy('id', 'asc')->get();
    $list = '';
    foreach ($data as $dt) {
      if ($dt === $data->last()) {
        $list .= '<a href="' . htmlentities($dt->url_ext, ENT_QUOTES, 'UTF-8') . '" target="_blank" title="' . htmlentities($dt->keterangan, ENT_QUOTES, 'UTF-8') . '"><i class="' . htmlentities($dt->icon, ENT_QUOTES, 'UTF-8') . ' text-white fa-2x"></i></a>';
      } else {
        $list .= '<a href="' . htmlentities($dt->url_ext, ENT_QUOTES, 'UTF-8') . '" target="_blank" style="margin-right: 10px" title="' . htmlentities($dt->keterangan, ENT_QUOTES, 'UTF-8') . '"><i class="' . htmlentities($dt->icon, ENT_QUOTES, 'UTF-8') . ' text-white fa-2x"></i></a>';
      }
    }
    return $list;
  }
  public static function linkMedsosTop()
  {
    $data = LinkExternal::where('tipe', 'medsos')->orderBy('id', 'asc')->get();
    $list = '';
    foreach ($data as $dt) {
      if ($dt === $data->last()) {
        $list .= '<a href="' . htmlentities($dt->url_ext, ENT_QUOTES, 'UTF-8') . '" target="_blank" title="' . htmlentities($dt->keterangan, ENT_QUOTES, 'UTF-8') . '"><i class="' . htmlentities($dt->icon, ENT_QUOTES, 'UTF-8') . ' text-white"></i></a>';
      } else {
        $list .= '<a href="' . htmlentities($dt->url_ext, ENT_QUOTES, 'UTF-8') . '" target="_blank" style="margin-right: 10px" title="' . htmlentities($dt->keterangan, ENT_QUOTES, 'UTF-8') . '"><i class="' . htmlentities($dt->icon, ENT_QUOTES, 'UTF-8') . ' text-white"></i></a>';
      }
    }
    return $list;
  }
}
