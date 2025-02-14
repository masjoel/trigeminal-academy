<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body">
                Copyright &copy; {{ date('Y') }}
            </div>
            <div class="d-none d-lg-inline-block">
            </div>
        </div>
    </div>
</footer>

@php
    $clientIP = Request::ip();
    $clientDo = request()->segments();
    $doing = $clientDo ? $clientDo[0] : Request::route()->getName();
    $log = [
        'iduser' => auth()->user()->id,
        'nama' => auth()->user()->username,
        'level' => auth()->user()->role,
        'datetime' => date('Y-m-d H:i:s'),
        'do' => Str::substr($doing, 0, 30),
        'ipaddr' => $clientIP,
    ];
    DB::table('userlog')->insert($log);
@endphp
