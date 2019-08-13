var hasReadICF = false;
function toggleSubmit() {
    if ($("#privacyPolicy:checked").length > 0 && hasReadICF) {
        $("#submitBtn").attr("disabled", false);
    } else {
        $("#submitBtn").attr("disabled", true);
    }
}
$("#submitBtn").on("click", function(e) {
    e.preventDefault();
    $("#submitBtn").attr("disabled", true);
    $("#registerBtnSpinner").removeClass("d-none");
    $("form").submit();
});
$("#informedConsentBox").scroll(function() {
    var element = document.getElementById('informedConsentBox');
    if(element.scrollHeight - element.scrollTop < element.clientHeight + 50) {
        hasReadICF = true;
        $("#ICFAccept").hide();
        toggleSubmit();
    }
 });