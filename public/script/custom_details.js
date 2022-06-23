$(document).ready(function () {
    $(".addToCart").click(function (e) {
        e.preventDefault();

        var product_id = $(this)
            .closest(".product_data")
            .find(".product_id")
            .val();
        var product_qty = $(this)
            .closest(".product_data")
            .find(".qty-input")
            .val();
        var harga = $(this).closest(".product_data").find(".harga").val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "POST",
            url: "/add-to-cart",
            data: {
                product_id: product_id,
                product_qty: product_qty,
                harga: harga,
            },
            success: function (response) {
                alert(response.status);
                location.reload();
            },
        });
    });

    $(".increment_btn").click(function (e) {
        e.preventDefault();

        var increment_value = $(".qty-input").val();
        var value = parseInt(increment_value, 10);
        value = isNaN(value) ? 0 : value;

        if (value < 10) {
            value++;
            $(".qty-input").val(value);
        }
    });
    $(".decrement_btn").click(function (e) {
        e.preventDefault();

        var decrement_value = $(".qty-input").val();
        var value = parseInt(decrement_value, 10);
        value = isNaN(value) ? 0 : value;

        if (value > 1) {
            value--;
            $(".qty-input").val(value);
        }
    });
});
