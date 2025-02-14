var itemCount = 0;
var itemQty = {};
var itemPrices = {};
var itemNames = {};

function addItemToCart(productId) {
    itemCount++;
    if (!itemQty[productId]) {
        itemQty[productId] = 0;
    }
    itemQty[productId]++;
    updateItemCount();
    updateItemQty(productId);
}

function removeItemFromCart(productId) {
    if (itemCount > 0) {
        itemCount--;
        if (itemQty[productId]) {
            itemQty[productId]--;
        }
        updateItemCount();
        updateItemQty(productId);
    }
}

function updateItemCount() {
    var itemCountElement = document.getElementById("item-count");
    itemCountElement.textContent = itemCount;
}

function updateItemQty(productId) {
    var itemQtyElement = document.getElementById("item-qty_" + productId);
    itemQtyElement.textContent = itemQty[productId];
    itemPrices[productId] = $("#item-prices_" + productId).val();
    itemNames[productId] = $("#item-names_" + productId).val();
}
