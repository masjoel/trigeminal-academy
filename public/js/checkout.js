document.addEventListener('DOMContentLoaded', function() {
    var orderDetails = localStorage.getItem('orderDetails');

    if (orderDetails) {
        orderDetails = JSON.parse(orderDetails);
        $.ajax({
            url: checkout,
            data: {
                itemQty: orderDetails.itemQty,
                token: token
            },
            type: "GET",
            dataType: 'JSON',
            async: false,
            success: function(response) {
                let itemQty = {};
                let html = ''
                let customer
                let orderId
                let invoice
                let productName = ''
                let subtotal = 0
                let price = 0
                let totalPrice = 0
                $.each(response.data, function(index, item) {
                    customer = item.nama;
                    productName = item.name;//.replace(/"/g, '');
                    orderId = JSON.stringify(item.order_id);
                    invoice = JSON.stringify(item.number).replace(/"/g, '');
                    price = JSON.stringify(item.price);
                    subtotal = JSON.stringify(item.quantity) * JSON.stringify(item.price);
                    totalPrice += subtotal
                    html += `<li style="margin-left: -25px;">${productName}<br>`
                    html += addCommas(price) + ' x ' + JSON.stringify(item.quantity) + ' = '+ addCommas(subtotal)
                    html += '</li>'
                });
                document.getElementById('customer').innerHTML = ' - ' + customer
                document.getElementById('order-list').innerHTML = html
                document.getElementById('total-price').innerHTML = addCommas(totalPrice)
                if (totalPrice > 0) {
                    $("#message").removeClass("d-none");
                    $("#pay-button").html(`<button id="pay-button" data-id="${orderId}" data-invoice="${invoice}" class="no-print ml-2 btn btn-lg btn-success"><i class="fa fa-print mr-2"></i> Cetak Nota</button>`);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // console.log(data)
            }
        })
    }
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
    
});
