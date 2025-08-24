<div class="row" id="cart-panel" style="display: none;"></div>
<div>
    <a href="javascript:" id="checkout-button" class="btn btn-primary w-100">CHECKOUT!</a>
</div>
<script>
    $(document).ready(function () {
        getCart("#cart-panel");

        $("#checkout-button").click(function (){
            saveCart();
        });
    });
</script>