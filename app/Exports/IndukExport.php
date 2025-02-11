<?php

namespace App\Exports;

use Illuminate\View\View;
use App\Models\AdpddInduk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;

class IndukExport implements FromView
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $params = $this->request->all();
        $data = AdpddInduk::select('*')->selectRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) AS usia')
                ->when($params['search'], function ($query, $search) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery->where('nama', 'like', '%' . $search . '%');
                    })->orWhere(function ($subQuery) use ($search) {
                        $subQuery->where('nik', 'like', '%' . $search . '%');
                    })->orWhere(function ($subQuery) use ($search) {
                        $subQuery->where('kk', 'like', '%' . $search . '%');
                    })->orWhere(function ($subQuery) use ($search) {
                        $subQuery->where('telpon', 'like', '%' . $search . '%');
                    })->orWhere(function ($subQuery) use ($search) {
                        $subQuery->where('alamat', 'like', '%' . $search . '%');
                    });
                })
                ->when($params['gender'], function ($query, $searchGender) {
                    $query->where('gender', '=', $searchGender);
                })
                ->when($params['agama'], function ($query, $searchAgama) {
                    $query->where('agama', '=', $searchAgama);
                })
                ->when($params['pendidikan'], function ($query, $searchPendidikan) {
                    $query->where('pendidikan', '=', $searchPendidikan);
                })
                ->when($params['pekerjaan'], function ($query, $searchPekerjaan) {
                    $query->where('pekerjaan', '=', $searchPekerjaan);
                })
                ->when($params['status_kawin'], function ($query, $searchKawin) {
                    $query->where('status_kawin', '=', $searchKawin);
                })
                ->when($params['hubungan'], function ($query, $searchHubungan) {
                    $query->where('hubungan', '=', $searchHubungan);
                })
                ->orderBy('id', 'desc')->get()->map(function ($item) {
                    $item->tgl_lahir_excel = Date::dateTimeToExcel(new \DateTime($item->tgl_lahir));
                    return $item;
                });
        return view('sid.adm-penduduk.induk.export', ['dataRows' => $data]);
    }
}
