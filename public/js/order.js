document.addEventListener('DOMContentLoaded', function () {
    var orderDetails = localStorage.getItem('orderDetails');

    if (orderDetails) {
        orderDetails = JSON.parse(orderDetails);
        $.ajax({
            url: saveOrder,
            data: {
                itemQty: orderDetails.itemQty,
                token: token
            },
            type: "GET",
            dataType: 'JSON',
            async: false,
            success: function (response) {
                let itemQty = {};
                let html = ''
                let productName = ''
                let subtotal = 0
                let subtotalbudget = 0
                let price = 0
                let totalPrice = 0
                let totalBudget = 0
                $.each(response.data, function (index, item) {
                    productName = item.name;//.replace(/"/g, '');
                    price = JSON.stringify(item.price);
                    subtotal = JSON.stringify(item.quantity) * JSON.stringify(item.price);
                    subtotalbudget = item.quantity * item.budget;
                    totalPrice += subtotal
                    totalBudget += subtotalbudget
                    html += `<input type="hidden" id="orderId" value="${JSON.stringify(item.lapak_order_id)}">`
                    html += `<li style="margin-left: -25px;">${productName}<br>`
                    html += `${addCommas(price)} x `
                    html += `<input style="width: 4ch; border: none; text-align: center" type="number" min="0" max="100"  id="${JSON.stringify(item.id)}-quantity" value="${JSON.stringify(item.quantity)}">`
                    html += '= '
                    html += `<span class="item-v-subtotal" id="${JSON.stringify(item.id)}-v-subtotal">${addCommas(subtotal)}</span>`
                    html += `<span class="item-subtotal d-none" id="${JSON.stringify(item.id)}-subtotal">${subtotal}</span>`
                    html += `<span class="item-subtotalbudget d-none" id="${JSON.stringify(item.id)}-subtotalbudget">${subtotalbudget}</span>`
                    html += '<div class="d-flex justify-content-left float-right">'
                    html += '<button class="mr-2 btn btn-sm btn-warning" onclick="updateSubtotal(`' + JSON.stringify(item.id) + '`, `' + price +'`, `'+ item.budget + '`, `minus`)"><i class="fa-solid fa-minus"></i></button>'
                    html += '<button class="btn btn-sm btn-info" onclick="updateSubtotal(`' + JSON.stringify(item.id) + '`, `' + price +'`, `'+ item.budget + '`, `plus`)"><i class="fa-solid fa-plus"></i></button>'
                    html += '</div>'
                    html += '</li>'
                });
                document.getElementById('order-list').innerHTML = html
                document.getElementById('total-price').innerHTML = addCommas(totalPrice)
                if (totalPrice > 0) {
                    // $("#message").removeClass("d-none");
                    $("#order-button").removeClass("d-none");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
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
