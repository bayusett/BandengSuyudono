// $(function () {
//     $("#cek").on("input", function (e) {
//         if (this.value.length > 0) {
//             $("button").prop("disabled", false);
//         } else {
//             $("button").prop("disabled", true);
//         }
//     });
// });
// var phone = document.getElementsByClassName("phone_number").val();
// var address = document.getElementsByClassName("address_one").val();
// var code_pos = document.getElementsByClassName("zip_code").val();
// var country = document.getElementsByClassName("country").val();
// var provinces_id = document.getElementsByClassName("provinces_id").val();
// var regencies_id = document.getElementsByClassName("regencies_id").val();
// var kurir = document.getElementsByClassName("kurir").val();
// var harga = document.getElementsByClassName("harga").val();

$(document).ready(function () {
    $("#cek").on("input", function (e) {
        if (this.value.length > 0) {
            $("button").prop("disabled", false);
        } else {
            $("button").prop("disabled", true);
        }
    });

    // $(".btn_bayar").click(function (e) {
    //     e.preventDefault();

    //     var phone = $(".phone_number").val();
    //     var address = $(".address_one").val();
    //     var code_pos = $(".zip_code").val();
    //     var country = $(".country").val();
    //     var provinces_id = $(".provinces_id").val();
    //     var regencies_id = $(".regencies_id").val();
    //     var kurir = $(".kurir").val();
    //     var harga = $(".harga").val();

    //     if (!phone) {
    //         var fphone_error = "Nomor Telephone Wajib Diisi!";
    //         $(".phone_error").html("");
    //         $(".phone_error").html(fphone_error);
    //     } else {
    //         var fphone_error = "";
    //         $(".phone_error").html("");
    //     }
    // });
});
