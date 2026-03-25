$(document).ready(function () {

    /* ==========================
       ITEM CARD CLICK (DETAILS)
    =========================== */
    $(document).on("click", ".card", function () {
        const itemId = $(this).data("id");

        $.get("api/item_fetch.php", { id: itemId }, function (data) {
            const item = JSON.parse(data);

            $("#itemTitle").text(item.title);
            $("#itemDesc").text(item.description);
            $("#itemPrice").text("€" + parseFloat(item.price).toFixed(2));

            $("#co2").text(item.co2_saved.toFixed(1) + " kg");
            $("#water").text(item.water_saved.toFixed(0) + " L");
            $("#waste").text(item.waste_saved.toFixed(1) + " kg");

            $("#itemDetails").fadeIn();
        });
    });


    /* ==========================
       OPEN ADD ITEM MODAL
    =========================== */
    $("#addItemBtn").on("click", function (e) {
        e.preventDefault();

        $("#itemForm")[0].reset();
        $("#item_id").val("");
        $("#modalTitle").text("List an Item");

        $("#itemModal").fadeIn();
    });


    /* ==========================
       CLOSE MODALS
    =========================== */
    $("#closeModal").on("click", function () {
        $("#itemModal").fadeOut();
    });

    $("#closeDetails").on("click", function () {
        $("#itemDetails").fadeOut();
    });


    /* ==========================
       SUBMIT ITEM FORM
    =========================== */
    $("#itemForm").on("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: "api/item_save.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                location.reload();
            },
            error: function (xhr) {
                alert("Failed to save item");
                console.error(xhr.responseText);
            }
        });
    });


    /* ==========================
       EDIT ITEM
    =========================== */
    $(document).on("click", ".editBtn", function () {
        const id = $(this).data("id");

        $.get("api/item_fetch.php", { id }, function (res) {
            const item = JSON.parse(res);

            $("#item_id").val(item.id);
            $("#title").val(item.title);
            $("#description").val(item.description);
            $("#price").val(item.price);
            $("#weight_kg").val(item.weight_kg);
            $("#category_id").val(item.category_id);
            $("#condition").val(item.condition);

            $("#modalTitle").text("Edit Item");
            $("#itemModal").fadeIn();
        });
    });

});
