$(document).ready(function () {
    var buttonprevious = null;
    var idlichtrinh = null;
    var currentrow = null;

    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $('#modalngaydi').val(today);
    $('#ngaydi').val(today);

    $('button[name="btnxoalichtrinh"]').click(function (e) { 
        e.stopImmediatePropagation();
        idlichtrinh = $(this).closest("tr").attr("id");
        currentrow = $(this).closest("tr");
        $modal = $('#modalxoalichtrinh');
        $modal.modal("show");
        $modal.find(".modal-body").text("Xóa lịch trình " + idlichtrinh);
    });

    $('#submitxoalichtrinh').click(function (e) { 
        $.ajax({
            type: "GET",
            url: "/lichtrinh/xoa",
            data: {
                "idlichtrinh" : idlichtrinh
            },
            // dataType: "dataType",
            success: function (data) {
                if(data == true){
                    alert("Lịch trình đã xóa thành công!")
                }else{
                    alert("Lịch trình chưa được!")
                }
                $('#modalxoalichtrinh').modal("hide");
                currentrow.remove();
                
            },
            error: function (data) {
                alert("Lỗi hệ thống khi xóa lịch trình!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });        
    });

    $('button[name="btnthemmoilichtrinh"]').click(function (e) { 
        e.preventDefault();
        $('#modalthemlichtrinh').modal("show");
        $('#modaltuyen').trigger("change");
        
    });

    $('#modaltuyen').change(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "/lichtrinh/benxetheotuyen",
            data: {
                idtuyen : $(this).val()
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $selectdi = $('#modalbendi');
                $selectden = $('#modalbenden');
                $selectdi.empty();
                $selectden.empty();
                data.forEach(element => {
                    let row = $(`<option value="${element.id_benxe}">${element.name_benxe}</option>`);
                    let row2 = $(`<option value="${element.id_benxe}">${element.name_benxe}</option>`);
                    $selectdi.append(row);
                    $selectden.append(row2);
                    // alert(data.id_benxe);
                });
            },
            error: function (data) {
                alert("Lỗi hệ thống khi xóa lịch trình!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
        
    });
});