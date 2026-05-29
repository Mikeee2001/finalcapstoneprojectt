function reloadPets() {

    $("#tableLoader").css("display", "flex").hide().fadeIn(200);

    $("#pets-container").load(
        location.href + " #pets-container > *",
        function () {

            $("#tableLoader").fadeOut(200);

        }
    );
}
