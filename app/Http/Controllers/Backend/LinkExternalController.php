<?php

namespace App\Http\Controllers\Backend;

use App\Models\LinkExternal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\StoreLinkExternalReq;

class LinkExternalController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:seting-lsm')->only(['index', 'show']);
        $this->middleware('can:seting-lsm.edit')->only(['edit', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        $tipe = strtolower($request->input('search'));
        if ($tipe == "media sosial") {
            $tipe = "medsos";
        } elseif ($tipe == "link eksternal") {
            $tipe = "external";
        }
        $link = LinkExternal::orderBy('id', 'desc')->when($request->input('search'), function ($query, $search) use ($tipe) {
            $query->where('keterangan', 'like', '%' . $search . '%')
                ->orWhere('url_ext', 'like', '%' . $search . '%')
                ->orWhere('tipe', $search)
                ->orWhere('tipe', $tipe);
        })->paginate(10);
        $title = 'Link External';
        return view('sid.v3.link.index', compact('title', 'link'));
    }

    public function create()
    {
        $title = 'Link External';
        return view('sid.v3.link.create', compact('title'));
    }

    public function store(StoreLinkExternalReq $request)
    {
        DB::beginTransaction();
        $tipe = $request->input('tipe');
        $icon = 'fa fa-link';
        $validate = $request->validated();

        $medsos = [
            'instagram.com' => 'fab fa-instagram',
            'facebook.com' => 'fab fa-facebook',
            'twitter.com' => 'fab fa-twitter',
            'x.com' => 'fab fa-twitter',
            'google.com' => 'fab fa-google',
            'tiktok.com' => 'fab fa-tiktok',
        ];
        foreach ($medsos as $dts => $iconData) {
            if (str_contains($validate['url_ext'], $dts)) {
                $tipe = 'medsos';
                $icon = $iconData;
            }
        }

        $validate['user_id'] = auth()->user()->id;
        $validate['tipe'] = $tipe;
        $validate['icon'] = $icon;
        LinkExternal::create($validate);
        DB::commit();
        return redirect(route('link.index'))->with('success', 'Data berhasil ditambahkan');
    }

    public function show(LinkExternal $link)
    {
        //
    }


    public function edit(LinkExternal $link)
    {
        $title = "Link External";
        return view('sid.v3.link.edit', compact('title', 'link'));
    }

    public function update(StoreLinkExternalReq $request, LinkExternal $link)
    {
        DB::beginTransaction();
        $tipe = $request->input('tipe');
        $icon = $request->input('icon');
        $validate = $request->validated();

        $medsos = [
            'instagram.com' => 'fab fa-instagram',
            'facebook.com' => 'fab fa-facebook',
            'twitter.com' => 'fab fa-twitter',
            'x.com' => 'fab fa-twitter',
            'google.com' => 'fab fa-google',
            'tiktok.com' => 'fab fa-tiktok',
        ];
        foreach ($medsos as $dts => $iconData) {
            if (str_contains($validate['url_ext'], $dts)) {
                $tipe = 'medsos';
            }
        }
        $validate['tipe'] = $tipe;
        $validate['icon'] = $icon;
        $link->update($validate);
        DB::commit();
        return redirect()->route('link.index')->with('success', 'Edit Successfully');
    }

    public function destroy(LinkExternal $link)
    {
        DB::beginTransaction();
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete link ' . $link->tipe . ' ' . $link->keterangan,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        $link->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
