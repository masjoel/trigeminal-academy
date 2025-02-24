<form id="cart-form" method="POST" action="{{ route('keranjang') }}">
    @csrf
    <input type="hidden" name="cart_items" id="cart-items">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil data dari localStorage
        let cart = localStorage.getItem('cart');
        let cartItems = [];

        if (cart) {
            try {
                cartItems = JSON.parse(cart);
                if (!Array.isArray(cartItems)) {
                    cartItems = [];
                }
            } catch (e) {
                cartItems = [];
            }
        }

        // Ambil hanya ID produk
        let cartIds = cartItems.map(item => item.id);

        // Update input hidden
        document.getElementById('cart-items').value = JSON.stringify(cartIds);
        document.getElementById('cart-form').submit();
    });
</script>
