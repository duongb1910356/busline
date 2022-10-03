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
    var multi = $('#chonbenxe').filterMultiSelect();


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
                } else {
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

    $('button[name="btnsuatuyen"]').click(function () {
        currentrow = $(this);
        $('#modalchuyenlichLabel').text("Sửa tuyến");
        $('#submitcapnhattuyen').text("Cập nhật");
        $.ajax({
            type: "GET",
            url: "/tuyen/thongtin/" + currentrow.parent().attr("data-idtuyen"),
            success: function (data) {
                console.log(data);
                $('#selecttinhden').val(data.id_tinhden);
                $('#selecttinhdi').val(data.id_tinhdi);
                $('#inputtentuyen').val(data.name_tuyen);
                $('#inputkhoangcach').val(data.khoangcach);
                $('#inputthoigian').val(data.thoigian);
                // alert(data);
            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
        // $('#selecttinhden').val(currentrow.parent().attr("data-idtinhden"));
        // $('#selecttinhdi').val(currentrow.parent().attr("data-idtinhdi"));
        // $('#inputtentuyen').val(currentrow.parent().attr("data-nametuyen"));
        // $('#inputkhoangcach').val(currentrow.parent().attr("data-khoangcach"));
        // $('#inputthoigian').val(currentrow.parent().attr("data-thoigian"));

        $.ajax({
            type: "GET",
            url: "/tuyenbenxe/" + currentrow.parent().attr("data-idtuyen"),
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                multi.deselectAll();
                data.forEach(element => {
                    multi.selectOption(element.id_benxe);
                });
            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });

        $('#modalcapnhattuyen').modal("show");
    });

    $('#submitcapnhattuyen').click(function () {
        var myform = $('#formsuatuyen').serialize();
        // alert(paramidtuyen);
        // if(paramidtuyen == null){
        //     paramidtuyen = currentrow.parent().attr("data-idtuyen");
        // }

        if (currentrow != null ) {
            $idtuyen = currentrow.parent().attr("data-idtuyen");
        }else{
            $idtuyen = -1;
        }
        $.ajax({
            type: "GET",
            url: "/tuyen/capnhat",
            data: {
                "idtuyen": $idtuyen,
                // "tentuyen" : $('#inputtentuyen'),
                // "tinhdi" : $('#selecttinhdi'),
                // "tinhden" : $('#selecttinhden'),
                // "khoangcach" : $('#inputkhoangcach'),
                // "thoigian" : $('#inputthoigian')
                "dataform": myform
            },
            // dataType: "dataType",
            success: function (data) {
                // alert("okkk");
                console.log(data);
                if (data == true) {
                    alert("Tuyến đã được cập nhật thành công");
                    $('#modalcapnhattuyen').modal("hide");
                    window.location = "http://busline.localhost/tuyen/quanly";
                } else {
                    alert("Cập nhật thất bại");
                }
            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    })

    $('button[name="btnthemmoituyen"]').click(function(){
        multi.deselectAll();
        currentrow = null;
        $('#formsuatuyen').trigger("reset");
        $('#modalchuyenlichLabel').text("Thêm tuyến mới");
        $('#submitcapnhattuyen').text("Thêm");
        $('#modalcapnhattuyen').modal("show");
    })

});