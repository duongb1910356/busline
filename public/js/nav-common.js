$(document).ready(function () {
    // // function search_product() {
    // //     alert("odg");
    // //     var inputsearch =  $('#search-box').val();
    // //     alert(inputsearch);
    // // }

    var position = [];
    var idlichtrinh_khach;
    var vitri_khach;

    $('#search-box').keyup(function (e) {
        var expand = $('div.card-list');
        live_search();
        expand.show();

    });

    $('#search-box').click(function () {
        $(this).trigger("keyup");
    });

    $('div.card-list').mouseleave(function () {
        $('div.card-list').hide();
    });

    function live_search() {
        let search_sdt = $('#search-box').val();
        $.ajax({
            type: "GET",
            url: "/timve",
            data: {
                "sodienthoai": search_sdt
            },
            // dataType: "dataType",
            success: function (data) {
                console.log(data);
                let tbody = $('table.table-striped > tbody');
                if (data != -1) {
                    tbody.empty();

                    data.forEach(element => {
                        // let match = element.sodienthoai.match(search_sdt);
                        // element.sodienthoai = match.match(element.sodienthoai);
                        // let positionmatch = element.sodienthoai.search(search_sdt);
                        let replace = "<b>" + search_sdt + "</b>";
                        let sodienthoai = element.sodienthoai;
                        sodienthoai = sodienthoai.replace(search_sdt, replace);

                        // alert(replace);

                        let tr = $(`<tr data-idve="${element.id_ve}" class="hover-card-list"></tr>`);
                        let td1 = $(`<td>${sodienthoai}</td>`);
                        let td2 = $(`<td>${element.name_khach}</td>`);
                        let td3 = $(`<td>${element.trungchuyen}</td>`);
                        tr.append(td1); tr.append(td2); tr.append(td3);
                        tbody.append(tr);
                        clickInputList();
                    });
                } else {
                    tbody.empty();
                }
            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    }

    function clickInputList() {
        $('table.table-striped > tbody > tr').click(function (e) {
            e.stopImmediatePropagation();
            position.length = 0;
            // alert("$(this)");
            fillFormModal($(this).attr("data-idve"));
            // let modal = $('#modalchuyenlich');            
            // modal.modal("show");
            // let idve = $(this).attr("data-idve")
        });
    }

    function actionRegisterSeat() {
        $previous = null;
        $('.able-cursor').on('click', function (e) {
            let current = $(this).find('rect');
            if ($previous != null) {
                $previous.find('rect').attr('fill', 'white');
                position = position.filter(function (value) {
                    return $previous.attr("data-seat") !== value;
                })
            }
            if (current.attr('fill') == 'white') {
                current.attr('fill', '#0dcaf0');
                $previous = $(this);
                position.push($(this).attr("data-seat"));
                // alert("x" + $previous.attr("data-seat"));
                // drawPositionOrder(position);
                console.log(position);
            } else if (current.attr('fill') == 'red') {
                e.preventDefault();
            }

        })

        $('.disable-cursor').on('click', function (e) {
            e.preventDefault();
        })
    }


    function fillFormModal(idve) {
        $.ajax({
            type: "GET",
            url: "/fill_form_modal/" + idve,
            // data: "data",
            dataType: "json",
            success: async function (data) {
                console.log(data);
                let modal = $('#modalchuyenlich');
                $('#formsuave').trigger("reset");
                $('#modalsuave-suangay').val("");
                $('#modalsuave-lichxechay').val("");
                $('#modalsuave-seat').empty();
                $('input#modalsuave-tenkhach').val(data.ve.name_khach);
                $('input#modalsuave-sodienthoai').val(data.ve.sodienthoai);
                $('input#modalsuave-trungchuyen').val(data.ve.trungchuyen);
                // alert("oo");
                $('#modalsuave-suatuyen').val(data.tuyen.id_tuyen);
                $('#modalsuave-suangay').val(data.lichtrinh.ngaydi);
                $('button[name="btntimlichtrinh"]').trigger("click");
                idlichtrinh_khach = data.lichtrinh.id_lichtrinh;
                vitri_khach = data.ve.vitri;
                timLichFillModal($('#modalsuave-suatuyen').val(), $('#modalsuave-suangay').val(), idlichtrinh_khach, vitri_khach);
                // $('#modalsuave-lichxechay').val(2);
                // alert($('#lichxechay').val());
                $('#modalchuyenlich').attr("data-idve", data.ve.id_ve);
                modal.modal("show");

            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    }

    function timLichFillModal(tuyen, ngay, idlichtrinh, vitri) {
        $.ajax({
            type: "GET",
            url: "/ve/quanlyve/timlich",
            data: {
                "tuyen": tuyen,
                "ngay": ngay
            },
            dataType: "json",
            success: function (data) {
                console.log(data);

                $('#modalsuave-lichxechay').empty();
                data.forEach((element, index) => {
                    let opption = $('<option data-index="' + index + '" value="' + element.lichtrinh.id_lichtrinh + '">' + element.bendi.name_benxe + " - " + element.benden.name_benxe + " - Giờ đi " + element.lichtrinh.giodi + '</option>');
                    $('#modalsuave-lichxechay').append(opption);
                });

                $('#modalsuave-lichxechay').off("change");
                if (idlichtrinh != -1)
                    $('#modalsuave-lichxechay').val(idlichtrinh);

                idlt = -1;
                $('#modalsuave-lichxechay').change({ lichtrinh: data }, function (e) {
                    idlt = $(this).find('option:selected').val();
                    $index = $(this).find('option:selected').attr("data-index");
                    // alert(idlt + " " + $index);
                    $('#modalsuave-seat').empty();
                    $('#modalsuave-seat').append(e.data.lichtrinh[$index].loaixe.sodo);

                    // e.data.lichtrinh[$index].ve.forEach(element => {
                    //     let selecttd = $('td[data-seat="' + item.vitri + '"]');
                    //     selecttd.find('rect').attr("fill", "red");
                    //     selecttd.addClass('disable-cursor').removeClass('able-cursor');
                    // });
                    $.each(e.data.lichtrinh[$index].ve, function (i, item) {
                        let selecttd = $('td[data-seat="' + item.vitri + '"]');
                        if (item.vitri == vitri && idlichtrinh == e.data.lichtrinh[$index].lichtrinh.id_lichtrinh) {
                            selecttd.find('rect').attr("fill", "rgb(233, 242, 107)");
                        } else {
                            selecttd.find('rect').attr("fill", "red");
                        }
                        selecttd.addClass('disable-cursor').removeClass('able-cursor');
                    });
                    actionRegisterSeat();
                    // actionRegisterSeat();
                });

                $('#modalsuave-lichxechay').trigger('change');
                actionRegisterSeat();
                // console.log(data);
            },
            error: function (data) {
                alert("Lỗi hệ thống tìm kiếm he!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    }

    $('button[name="btntimlichtrinh"]').click(function (e) {
        e.preventDefault();
        $tuyen = $('#modalsuave-suatuyen').val();
        $ngay = $('#modalsuave-suangay').val();
        timLichFillModal($tuyen, $ngay, idlichtrinh_khach, vitri_khach);
    });

    $('#submitxoa').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "/xoave/" + $('#modalchuyenlich').attr("data-idve"),
            success: function (data) {
                alert("Vé đã xóa thành công");
                $('#modalchuyenlich').modal('hide');
                // buttonprevious.trigger("click");

            },
            error: function (data) {
                alert("Lỗi hệ thống tìm kiếm he!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });

    // function submitCapNhat() {
    $('#submitcapnhat').click(function (e) {
        e.preventDefault();
        let tenkhach = $('input#modalsuave-tenkhach').val();
        let sodienthoai = $('input#modalsuave-sodienthoai').val();
        let trungchuyen = $('input#modalsuave-trungchuyen').val();
        let idlichtrinh = $('#modalsuave-lichxechay').val();
        let vitri = position[0];
        let idve = $('#modalchuyenlich').attr("data-idve");

        // alert(idve)
        // if( !$('#lichxechay').val() ){
        //     idlichtrinh = $('#lichxechay').val();
        // }
        // if(position.length != 0){
        //     vitri = position;
        // }
        // alert(idve);
        // // console($idlt);
        // // alert("idlichtrinh");

        $.ajax({
            type: "GET",
            url: "/ve/capnhat",
            data: {
                tenkhach: tenkhach,
                sodienthoai: sodienthoai,
                trungchuyen: trungchuyen,
                idlichtrinh: idlichtrinh,
                vitri: vitri,
                idve: idve
            },
            // dataType: "dataType",
            success: function (data) {
                if (data == true) {
                    alert("Vé đã được cập nhật thành công!");
                } else {
                    alert("Vé chưa được cập nhật!")
                }
                $('#modalchuyenlich').modal("hide");
                // buttonprevious.trigger("click");
                // alert(data);
            },
            error: function (data) {
                alert("Lỗi hệ thống khi cập nhật vé!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });

    });
    // }

    $('#submitxuatve').click(function (e) {
        alert($('#modalchuyenlich').attr("data-idve"));
        $.ajax({
            type: "GET",
            url: "/thanhtoanvedon/" + $('#modalchuyenlich').attr("data-idve"),
            success: function () {
                alert("Vé đã được thanh toán thành công");
                $('#modalchuyenlich').modal("hide")
            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }

        });
    })

    // function clickSuaVe() {
    //     $('button[name="btnchuyenlich"]').click(function (e) {
    //         e.stopImmediatePropagation();
    //         var idve = $(this).closest("tr").attr("id");
    //         // var element = $(this);
    //         position.length = 0;
    //         alert("okkkhhkkgg");
    //         fillFormModal(idve);
    //         // showModalSuaVe(idve, element);
    //     });
    // }
});

// const name = "Jesse";
// const age = 40;

// export {name, age};


