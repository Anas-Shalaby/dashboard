$(document).ready(function () {
    var totalPrice = 0;
    $(".add-product-btn").on("click", function (e) {
        e.preventDefault();
        var name = $(this).data("name");
        var id = $(this).data("id");
        var price = Number($(this).data("price"));
        var quantity = Number($(".product-quantity").val()) || 1;

        $(this).removeClass("btn-success").addClass("btn-default disabled");

        var html = `
            <tr>
             <td>${name}</td>
             <td><input type="number" name="products[]" value="${id}" class="d-none"></td>
             <td><input type="number" name="quantaties[]" min="1"  data-price="${price}" class="form-control input-sm product-quantity"  value="${quantity}" ></td>
             <td class="product-price" >${price}</td>
             <td><button class="btn btn-outline-danger btn-sm remove-product" data-id="${id}" data-delete="${price}" >delete</td>
             </tr>

        `;

        totalPrice += price;

        $(".sum").html(totalPrice);

        $(".order-list").append(html);

        if (price > 0) {
            $(".add-form-btn").removeClass("disabled");
        } else {
            $(".add-form-btn").addClass("disabled");
        }
    });

    $(document).on("click", ".print-btn", function () {
        $("#print-area").printThis();
    });

    $(".order-products").on("click", function (e) {
        e.preventDefault();

        var url = $(this).data("url");
        var method = $(this).data("method");

        $("#loading").css("display", "flex");

        $.ajax({
            url: url,
            method: method,
            success: function (data) {
                $("#loading").css("display", "none");

                $("#order-products-list").empty();
                $("#order-products-list").append(data);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $(document).on("click", ".order-status-btn", function () {
        var status = $(this).data("status");
        var url = $(this).data("url");

        $.ajax({
            url: url,
            method: "PUT",
            success: function (data) {
                status = "finished";
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $("body").on("click", ".disabled", function (e) {
        e.preventDefault();
    });

    $("body").on("click", ".remove-product", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        var price = Number($(this).closest("tr").find(".product-price").html());
        $(this).closest("tr").remove();

        $(`.${id}`).removeClass("btn-default disabled").addClass("btn-success");
        totalPrice -= price;

        $(".sum").html(totalPrice);

        if (totalPrice == 0) {
            $(".add-form-btn").addClass("disabled");
        }
    });

    $("body").on("keyup change", ".product-quantity", function (e) {
        var productPrice = Number($(this).data("price"));
        var quantity = Number($(this).val());

        totalPrice = 0;

        $(this)
            .closest("tr")
            .find(".product-price")
            .html($.number(productPrice * quantity, 2));

        $(".order-list .product-price").each(function (index) {
            totalPrice += parseFloat($(this).html().replace(/,/g, ""));
        });

        $(".sum").html($.number(totalPrice, 2));
    });
});
