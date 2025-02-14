@extends('frontend.webdesa.main')
@push('style')
@endpush
@section('title', $title)
@section('main')
    @include('pages.lapak-desa.breadcrumb')
    <section class="about-area pt-20 pb-80">
        <div class="container">
            <div class="about-content">
                <section class="healthy-area pt-10 pb-30">
                    <div class="container">
                        <div class="healthy-inner-wrap">
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <div class="section-title-wrap mb-30">
                                        <div class="section-title">
                                            <h2 class="title">Detail pesanan</h2>
                                        </div>
                                        <div class="section-title-line"></div>
                                    </div>
                                    <div id="order-details">
                                        <ul id="order-list">
                                        </ul>
                                        <h4>Total : <span id="total-price">0</span></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section-title-wrap mb-30">
                                        <div class="section-title">
                                            <h2 class="title">Data Pelanggan</h2>
                                        </div>
                                        <div class="section-title-line"></div>
                                    </div>
                                    <div class="d-block">
                                        <div class="from-group mb-1">
                                            <input type="text" class="form-control" name="cust_nama" id="cust-nama"
                                                placeholder="Nama Pelanggan">
                                        </div>
                                        <div class="from-group mb-1">
                                            <input type="number" class="form-control" name="cust_hp" id="cust-hp"
                                                placeholder="No. HP">
                                        </div>
                                        <div class="from-group mb-3">
                                            <textarea class="form-control" name="cust_alamat" id="cust-alamat" placeholder="Alamat"></textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button id="order-button" class="btn btn-lg btn-secondary d-none" disabled><i
                                                class="fa fa-paper-plane mr-2"></i>&nbsp; Pesan sekarang</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script>
        let saveOrder = "{{ route('save-order') }}"
        let saveCustomer = "{{ route('save-customer') }}"
        let updateOrder = "{{ route('update-order') }}"
        let token = '{{ csrf_token() }}'
    </script>
    <script src="{{ asset('js/order-webdesa.js') }}"></script>
    <script>
        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        function updateSubtotal(itemName, itemPrice, budgetPrice, operation) {
            var orderId = $('#orderId').val();
            var quantityInput = document.getElementById(itemName + '-quantity');
            var subtotalField = document.getElementById(itemName + '-subtotal');
            var subtotalbudgetField = document.getElementById(itemName + '-subtotalbudget');
            var vSubtotalField = document.getElementById(itemName + '-v-subtotal');
            var grandTotalField = document.getElementById('total-price');

            var quantity = parseInt(quantityInput.value);
            var price = parseFloat(itemPrice);
            var budget = parseFloat(budgetPrice);
            var subtotal = 0;

            if (!isNaN(quantity) && quantity >= 0) {
                if (operation === 'plus') {
                    quantity++;
                } else if (operation === 'minus' && quantity > 0) {
                    quantity--;
                }
                quantityInput.value = quantity;
                subtotal = quantity * price;
                subtotalbudget = quantity * budget;
                subtotalField.innerText = subtotal;
                subtotalbudgetField.innerText = subtotalbudget;
                vSubtotalField.innerText = addCommas(subtotal);

                var subtotals = document.querySelectorAll('.item-subtotal');
                var subtotalbudgets = document.querySelectorAll('.item-subtotalbudget');
                var vSubtotals = document.querySelectorAll('.item-v-subtotal');
                var grandTotal = 0;
                var grandTotalBudget = 0;
                for (var i = 0; i < subtotals.length; i++) {
                    grandTotal += parseFloat(subtotals[i].innerText);
                    grandTotalBudget += parseFloat(subtotalbudgets[i].innerText);
                }
                grandTotalField.innerText = addCommas(grandTotal);
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", updateOrder, true);
            xhr.setRequestHeader("X-CSRF-TOKEN", token);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the server response if needed
                    //console.log(JSON.parse(xhr.responseText).status);
                    if (JSON.parse(xhr.responseText).status === 'error') {
                        swal({
                            title: 'Oops...!',
                            text: JSON.parse(xhr.responseText).message,
                            icon: 'error',
                            dangerMode: true,
                        })
                        $('#' + itemName + '-quantity').val(0);
                        $('#' + itemName + '-v-subtotal').text(0);
                        $('#' + itemName + '-subtotal').text(0);
                        $('#' + itemName + '-subtotalbudget').text(0);
                        $('#total-price').text(0);
                    }
                }
            };
            var data = "order_id=" + orderId + "&product_id=" + itemName + "&quantity=" + quantity + "&subtotal=" +
                subtotal + "&grand_total=" + grandTotal + "&grand_total_budget=" + grandTotalBudget;
            xhr.send(data);
        }
        $(document).on("change", "#cust-nama", function(e) {
            if ($(this).val() != '' && $(this).val().length >= 3) {
                $('#order-button').prop('disabled', false);
            }
        })
        $(document).on("click", "button#order-button", function(e) {
            e.preventDefault();
            var token = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();
            $.ajax({
                url: saveCustomer,
                type: "POST",
                data: {
                    '_token': token,
                    'nama': $('#cust-nama').val(),
                    'hp': $('#cust-hp').val(),
                    'alamat': $('#cust-alamat').val(),
                },
                success: function(result) {
                    //console.log('result', result);
                    window.location.href = "{{ route('cart-detail') }}";
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(jqXHR, textStatus, errorThrown);
                }
            })
        });
    </script>
@endpush
