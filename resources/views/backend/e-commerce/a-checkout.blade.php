@extends('layouts.lapakdesa')
@section('title', $title)
@push('style')
@endpush

@section('main')
<div id="header-toko" class="text-center" style="display: none;">
    <div id="view-logo-toko">
        {{-- <img src="" alt="LOGO" class="img-fluid" id="logo-toko" style="max-height: 100px"> --}}
    </div>
    <div id="data-toko" class="mt-3"></div>
    <div id="data-kasir"></div>
</div>
<div class="card my-3">
    <div class="card-header" id="nota" style="background-color: #a3e1eb">
        <h3>Detail Pesanan <span id="customer"></span></h3>
    </div>
    <div class="card-body">
        <div id="order-details">
            <ul id="order-list">
            </ul>
            <h4>Total : <span id="total-price">0</span></h4>
        </div>
        {{-- @if (!auth()->check()) --}}
        <p id="xmessage">Silakan bayar pesanan Anda, dengan cara transfer ke rekening berikut:
            <br> 0000 0000 0000 0000
            <br> a/n {{ klien('nama_client') }}
            <br><br>Pesanan anda segera kami antar
        </p>
        {{-- @endif
        @if (auth()->check())
        <div class="d-flex mt-5 justify-content-center" id="pay-button">
        </div>
        @endif --}}
    </div>
</div>
<div id="footer-toko" style="display: none;"></div>
@endsection

@push('scripts')
<script>
    let checkout =  "{{ route('checkout') }}"
    let payment =  "{{ route('payment') }}"
    let token =  '{{ csrf_token() }}'
</script>
<script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('js/checkout.js') }}"></script>
<script>
    @if(auth()->check())
    $(document).on("click", "button#pay-button", function(e) {
        e.preventDefault();
        document.getElementById("header-toko").style.display = "block";
        document.getElementById("footer-toko").style.display = "block";

        let opr = "{{ auth()->user()->name }}"
        let id = $(this).data('id')
        let inv = $(this).data('invoice')
        let asset = "{{ url('').Storage::url('') }}"
        let html = ''
        let tgl = ''
        let viewLogo
        const logoToko = document.querySelector("#logo-toko");
        $.ajax({
            url: "{{ route('profil-bisnis.show', auth()->user()->id) }}",
            type: "GET",
            dataType: 'JSON',
            async: false,
            success: function(result) {
                viewLogo = result.profil.logo
                html += '<div class="d-block text-center">'
                html += '<h2>'+result.profil.nama_client+'</h2>'
                html += '<p>'+result.profil.alamat_client+'</p>'
                html += '</div>'
                if (viewLogo != null) {
                    $("#view-logo-toko").html('<img src="'+asset + result.profil.logo+'" alt="LOGO" class="img-fluid" id="logo-toko" style="max-height: 100px">')
                    logoToko.src = asset + result.profil.logo;
                }
                // if (logoToko) {logoToko.src = asset + result.profil.logo;}
                $("#data-toko").html(html)
                html = ''
                html += '<div class="d-block text-center">'
                html += '<p>'+result.profil.footnot+'</p>'
                html += '</div>'
                $("#footer-toko").html(html)
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        })
        $.ajax({
            url: payment,
            type: "GET",
            data: {orderId : id},
            dataType: 'JSON',
            async: false,
            success: function(result) {
                $.each(result.data, function(index, val) {
                    tgl = val.created_at;
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        })

        $("#nota").html('');
        var cards = document.getElementsByClassName("card");
        var cardHeaders = document.getElementsByClassName("card-header");

        for (var i = 0; i < cards.length; i++) {
            cards[i].classList.add("border-0");
        }

        for (var i = 0; i < cardHeaders.length; i++) {
            cardHeaders[i].classList.add("border-0");
        }
        let vDate = new Date(tgl);
        html = ''
        html += '<div class="d-flex justify-content-between">'
        html += '<span>Nota</span>'
        html += `<span>${inv}</span>`
        html += '</div>'
        html += '<div class="d-flex justify-content-between">'
        html += '<span>Waktu</span>'
        html += `<span>${moment(vDate).format('DD/MM/YYYY HH:mm')}</span>`
        html += '</div>'
        html += '<div class="d-flex justify-content-between">'
        html += '<span>Kasir</span>'
        html += `<span>${opr}</span>`
        html += '</div>'
        html += '<div class="d-flex justify-content-between">'
        html += '<span>Bayar</span>'
        html += `<span>Tunai</span>`
        html += '</div>'
        $('#data-kasir').html(html)

        // Mencetak nota
        if (viewLogo == null) {
            window.print();
            window.location.href = "{{ url('payment-success') }}/" + id;
        }else{
            logoToko.addEventListener("load", function() {
                window.print();
                window.location.href = "{{ url('payment-success') }}/" + id;
            });
        }
    });
    @endif
</script>
@endpush