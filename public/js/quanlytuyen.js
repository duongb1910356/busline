$(document).ready(function () {
    var buttonprevious = null;
    var idlichtrinh = null;
    var currentrow = null;

    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    // $('#modalngaydi').val(today);
    $('#ngaydi').val(today);

    $(".example").each(function () {
        $(this).fancyTable({
            inputStyle: "",
            inputPlaceholder: "Search..."
        })
    });

    $('button[name="btnxoatuyen"]').click(function () {
        currentrow = $(this);
        $('#modalnametuyen').text(currentrow.parent().parent().attr("data-nametuyen"));
        $('#modalxoatuyen').modal("show");
    });

    $('#submitxoalichtrinh').click(function () {
        $.ajax({
            type: "GET",
            url: "/tuyen/xoa/" + currentrow.attr("data-idtuyen"),
            success: function (data) {
                if (data == true) {
                    alert("Tuyến đã được xóa thành công");
                    currentrow.parent().parent().remove();
                    $('#modalxoatuyen').modal("hide");
                }else{
                    alert("Tuyến chưa được xóa")
                }
            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });

    $('button[name="btnsualichtrinh"]').click(function(){
        currentrow = $(this);
        // $.ajax({
        //     type: "GET",
        //     url: "/tuyen/sua/" + currentrow.attr("data-idtuyen"),
        //     success: function (data) {
                
        //     },
        //     error: function (data) {
        //         alert("Lỗi hệ thống!");
        //         var errors = data.responseJSON;
        //         console.log(errors);
        //     }
        // });
        $('#selecttinhden').val(currentrow.parent().attr("data-idtinhden"));
        $('selecttinhdi').val(currentrow.parent().attr("data-idtinhdi"));
        $('#inputtentuyen').val(currentrow.parent().attr("data-nametuyen"));
        $('#inputkhoangcach').val(currentrow.parent().attr("data-khoangcach"));
        $('#inputthoigian').val(currentrow.parent().attr("data-thoigian"));

        $.ajax({
            type: "GET",
            url: "/tuyenbenxe/" + currentrow.parent().attr("data-idtuyen"),
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                alert("yes");
                $('#chonbenxe > option').attr("selected", "selected")
            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });

        $('#modalthemlichtrinh').modal("show");
    });

});