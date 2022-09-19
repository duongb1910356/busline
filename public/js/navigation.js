$(document).ready(function () {

    var dt = new Date();
    var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
    $('#formsearchmave').on("submit",function(event){
        event.preventDefault();
        $idmave = $('#inputmave').val();
        // alert($idmave);
        $.ajax({
            type: "GET",
            url: "/tracuuhoadon",
            data: {
                "inputmave" : $idmave
            },
            // dataType: "dataType",
            success: function (data) {
                if(data == false){
                    alert("Không tìm thấy vé yêu cầu")
                }else{
                    window.location = "/ketquatracuuve/" + $idmave;
                }
            },
            error: function (data) {
                alert("Lỗi hệ thống khi xóa lịch trình!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });
    // $('#searchmave').keypress(function (event) {
    //     event.preventDefault();
    //     var keycode = (event.keyCode ? event.keyCode : event.which);
    //     if (keycode == '13') {
    //         let inputsearch = $(this).val();
    //         if (inputsearch == null) {
    //             alert("Bạn chưa nhập mã vé");
    //             return false;
    //         } else {
    //             alert("asfffgd");
    //             return false;
    //         }
    //     }else{
    //         alert($(this).val());
    //     }
    // });

    // $('#buttonhuyve').click(function(e){
    //     e.preventDefault();
    //     let idve = $(this).attr("data-idve");
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         type: "POST",
    //         url: "/huyve/" + idve,
    //         success: function (data) {
    //             alert("Vé đã được hủy thành công!");
    //         },
    //     error: function (data) {
    //         alert("Không thể hủy vé!");
    //         var errors = data.responseJSON;
    //         console.log(errors);
    //     }
    //     });
    // });
});