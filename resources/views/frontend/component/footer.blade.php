<footer style="border-top: 2px solid #e8f1f1">
    <div class="footer-area">
        <div class="footer-top" style="padding: 30px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="footer-widget">
                            <div class="logo">
                                <a href="/"><img
                                        src="{{ preg_match('/profil/i', klien('logo')) ? Storage::url(klien('logo')) : asset(klien('logo')) }}"
                                        alt="{{ klien('nama_app') }}"></a>
                            </div>
                            <div class="footer-content">
                                {{ klien('footnot') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="footer-widget">
                            <h4 class="fw-title">Visit</h4>
                            <div class="footer-link-wrap">
                                <ul class="list-wrap">
                                    {!! App\Helpers\CustomHelper::linkExternal() !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="footer-widget">
                            <h4 class="fw-title">Contact us</h4>
                            <div class="footer-link-wrap">
                                Office
                                <br>{{ klien('alamat_client') }}

                                <ul class="list-wrap" style="margin-bottom: 30px">
                                    <li><a><i class="fa fa-envelope"></i> {{ klien('email') }}</a></li>
                                    <li><a><i class="fa fa-phone"></i> {{ klien('phone') }}</a></li>
                                </ul>
                                {!! App\Helpers\CustomHelper::linkMedsos() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-shape" data-background="{{ '/assets/frontend/img/images/footer_shape.png' }}"></div>
        </div>
        <div class="footer-bottom" style="padding: 10px">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="footer-bottom-menu">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="copyright-text">
                            <p>&copy; {{ date('Y') }} {{ klien('nama_client') }}. All Rights Reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@php
    $clientIP = Request::ip();
    $clientDo = request()->segments();
    $doing = $clientDo ? $clientDo[0] : Request::route()->getName();
    $log = [
        'iduser' => 0,
        'nama' => 'guest',
        'level' => '',
        'datetime' => date('Y-m-d H:i:s'),
        'do' => $doing,
        'ipaddr' => $clientIP,
    ];
    DB::table('userlog')->insert($log);
@endphp
