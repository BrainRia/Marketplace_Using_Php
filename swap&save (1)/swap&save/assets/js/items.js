$(document).ready(function () {

    /* OPEN ITEM DETAILS */
    $(document).on("click", ".item-card", function () {
        const itemId = $(this).data("id");

        if (!itemId) return;

        $.ajax({
            url: "/Swap&Save/actions/get_item.php",
            method: "GET",
            data: { id: itemId },
            dataType: "json",
            success: function (item) {

                const imageSrc = item.image
                    ? "/Swap&Save/" + item.image
                    : "/Swap&Save/assets/img/placeholder.jpg";

                $("#detailsImage").attr("src", imageSrc);
                $("#detailsTitle").text(item.title);
                $("#detailsPrice").text("€" + parseFloat(item.price).toFixed(2));
                $("#detailsDescription").text(item.description);

                /* PICKUP LOCATION */
                $("#detailsPickup").text(item.pickup_location);

                /* ENVIRONMENTAL IMPACT */
                const weight = parseFloat(item.weight_kg) || 0;

                /* ENVIRONMENTAL IMPACT */
$("#impactCo2").text(item.co2_saved.toFixed(1) + " kg");
$("#impactWater").text(item.water_saved.toFixed(0) + " L");
$("#impactWaste").text(item.waste_saved.toFixed(1) + " kg");
$("#impactEnergy").text(item.energy_saved.toFixed(1) + " kWh");


                $("#itemDetailsModal").css("display", "flex");
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("Failed to load item details.");
            }
        });
    });
$(document).on("submit", "#itemForm", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "/Swap&Save/actions/save_item.php",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log(res);

            if (res === "success") {
                location.reload();
            } else {
                alert(res);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Failed to save item");
        }
    });
});

    /* CLOSE DETAILS MODAL */
    $(document).on("click", "#closeDetails", function () {
        $("#itemDetailsModal").hide();
    });
    $(document).on("click", "#addItemBtn", function (e) {
    e.preventDefault();
    $("#itemModal").css("display", "flex");
});

$(document).on("click", "#closeModal", function () {
    $("#itemModal").hide();
});


});
