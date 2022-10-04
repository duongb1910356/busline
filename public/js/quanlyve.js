// import {fillFormModal} from './nav-common.js'

// import { name, age } from "./nav-common";
// const someName = require('./nav-common.js');

$(document).ready(function () {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    var position = [];
    var idlt = -1;
    var buttonprevious = null;
    var idve = null;
    var idlichtrinh_khach;
    var vitri_khach;

    $('#ngaydi').val(today);



    $(".example").each(function () {
        $(this).fancyTable({
            inputStyle: "",
            inputPlaceholder: "Search..."
        })
    });

    function clickXoaVe() {
        $('button[name="btnxoa"]').click(function (e) {
            e.stopImmediatePropagation();
            idve = $(this).closest("tr").attr("id");
            // alert($idve);
            $('div#exampleModal > div > div > div.modal-body').text("Xác nhận xóa vé " + idve);
        });
    }

    $('#submitmodalxoa').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "/xoave/" + idve,
            success: function (data) {
                alert("Vé đã xóa thành công");
                $('#exampleModal').modal('hide');
                buttonprevious.trigger("click");
            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });

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
                console.log(position)

            } else if (current.attr('fill') == 'red') {
                e.preventDefault();
            }

        })

        $('.disable-cursor').on('click', function (e) {
            e.preventDefault();
        })
    }

    $('button[name="btnxemlistve"]').click(function () {
        $('#bodylistve').empty();
        var idlichtrinh = $(this).closest("tr").attr("id");
        buttonprevious = $(this);
        $.ajax({
            type: "GET",
            url: "/ve/lichtrinh/danhsachve",
            data: {
                "idlichtrinh": idlichtrinh
            },
            dataType: "json",
            success: function (data) {
                // data = data[0];
                // raw = data;
                $('table[name="listve"]').attr("id", data[0].lichtrinh.id_lichtrinh);
                data[0].ve.forEach(element => {

                    let row = $('<tr></tr>', { id: element.id_ve, class: "text-center" });
                    row.append(`<td>${element.name_khach}</td>`);
                    row.append(`<td>${element.sodienthoai}</td>`);
                    row.append(`<td>${element.trungchuyen}</td>`);
                    row.append(`<td>${data[0].benxedi.name_benxe}</td>`);
                    row.append(`<td>${data[0].benxeden.name_benxe}</td>`);
                    row.append(`<td>${data[0].lichtrinh.ngaydi}</td>`);
                    row.append(`<td>${data[0].giave}</td>`);
                    row.append(`<td>${element.vitri}</td>`);
                    if (element.tinhtrang == 0) {
                        row.append(`<td>Chưa thanh toán</td>`);
                    } else {
                        row.append(`<td>Đã thanh toán</td>`);
                    }
                    row.append('<td><button name="btnxuatve" class="btn btn-primary" style="padding: .2rem .4rem; font-size: 15px;" data-bs-placement="top" title = "Xuất vé" > <i class="bi bi-cash-coin"></i></button > <button name="btndoicho" class="btn btn-secondary" style="padding: .2rem .4rem; font-size: 15px;" data-bs-placement="top" title = "Đổi chỗ" ><i class="bi bi-arrow-left-right"></i></button> <button name="btnchuyenlich" class="btn btn-info" style="padding: .2rem .4rem; font-size: 15px;" data-bs-placement="top" title = "Sửa vé" ><i class="bi bi-gear"></i></button> <button name="btnxoa" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" style="padding: .2rem .4rem; font-size: 15px;" data-bs-placement="top" title = "Xóa vé" ><i class="bi bi-trash"></i></button></td > ');
                    // let row = $('<td>abc</td>');
                    $('#bodylistve').append(row);
                    clickXoaVe();
                    clickDoiCho();
                    clickSuaVe();
                    clickXuatVe();
                    // console.log(row);
                });

                // json_decode(data);
                // console.log(data);
                // data.forEach(element => {
                //     let row = $('tr', {id : data[0].lichtrinh.id_lichtrinh}, class : "text-center");
                //     let f1 = $('<td>${data[0].lichtrinh.id_}</td>')
                // });
                // alert(data[0].lichtrinh.giodi);
                // $table = $('table', {id : data[0].lichtrinh.id_lichtrinh, class : "table example text-center", style : "width: 100%"});
                // $table.appendTo($('#lichtrinhchitet'));
                // array.forEach(element => {

                // });

            },
            error: function (data) {
                alert("vui!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    })


    function clickDoiCho() {
        $('button[name="btndoicho"]').click(function (e) {
            e.preventDefault();
            position.length = 0;
            $idlichtrinh = $(this).closest("table").attr("id");
            idve = $(this).closest("tr").attr("id");
            $vitringoi = $(this).closest("tr").find("td:nth-child(8)").text();
            $.ajax({
                type: "GET",
                url: "/ve/doicho/" + $idlichtrinh,
                dataType: "json",
                success: function (data) {
                    $('#modalseat').empty();
                    $('#modalseat').html(data.loaixe[0].sodo);
                    $('#modalDoiChoLabel').text("Vị trí hiện tại: " + $vitringoi);
                    $.each(data.ves, function (i, item) {
                        let selecttd = $('td[data-seat="' + item.vitri + '"]');
                        selecttd.find('rect').attr("fill", "red");
                        selecttd.addClass('disable-cursor').removeClass('able-cursor');
                    });
                    // $previous = null;
                    actionRegisterSeat();
                    // $('.able-cursor').on('click', function (e) {
                    //     let current = $(this).find('rect');
                    //     if ($previous != null){
                    //         $previous.find('rect').attr('fill', 'white');
                    //         position = position.filter(function (value) {
                    //             return $previous.attr("data-seat") !== value;
                    //         })
                    //     }
                    //     if (current.attr('fill') == 'white') {
                    //         current.attr('fill', '#0dcaf0');
                    //         $previous = $(this);
                    //         position.push($(this).attr("data-seat"));
                    //         // alert("x" + $previous.attr("data-seat"));

                    //         // drawPositionOrder(position);
                    //         console.log(position)

                    //     } else if (current.attr('fill') == 'red') {
                    //         e.preventDefault();
                    //     }
                    //     // else {
                    //     //     current.attr('fill', 'white');
                    //     //     var temp = $(this).attr("data-seat");
                    //     //     position = position.filter(function (value) {
                    //     //         return temp !== value;
                    //     //     })
                    //     //     // drawPositionOrder(position);
                    //     //     console.log(position)

                    //     // }
                    // })

                    // $('.disable-cursor').on('click', function (e) {
                    //     e.preventDefault();
                    // })
                }
            });
            $('#modalDoiCho').modal('show');
            // alert("dsgdgd")

        });
    }

    $('#submitdoicho').click(function (e) {
        $.ajax({
            type: "GET",
            url: "/ve/capnhat/doicho",
            data: {
                vitri: position[0],
                idve: idve
            },
            success: function (data) {
                if (data == true) {
                    alert("Chỗ đã đổi thành công");
                    $('#modalDoiCho').modal('hide');
                    buttonprevious.trigger("click");
                }
                // alert(data)
            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
        // alert($idve);

    });




    // function clickSuaVe() {
    //     $('button[name="btnchuyenlich"]').click(function () {
    //         $('#formsuave').trigger("reset");
    //         $('#suangay').val("");
    //         $('#lichxechay').val("");
    //         $('#seat').empty();
    //         $('input#tenkhach').val($(this).closest("tr").find("td:nth-child(1)").text());
    //         $('input#sodienthoai').val($(this).closest("tr").find("td:nth-child(2)").text());
    //         $('input#trungchuyen').val($(this).closest("tr").find("td:nth-child(3)").text())
    //         var idve = $(this).closest("tr").attr("id");
    //         $('#modalchuyenlich').attr("data-idlichtrinh", idve);
    //         position.length = 0;
    //         // alert(idve);
    //         // alert("hell");
    //         // alert("dg");
    //         // $temp = $('#2').after("<tr></tr>").next().append('<td colspan="12"></td>');
    //         // $v = $temp.children();
    //         // $v.append($('#formchuyenlich'))
    //         $('#modalchuyenlich').modal('show')
    //     });
    // }

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

                if(data.ve.tinhtrang == 1){
                    $('#submitxuatve').prop('disabled', true);
                    $('#submitcapnhat').prop('disabled', true);
                }else{
                    $('#submitxuatve').prop('disabled', false);
                    $('#submitcapnhat').prop('disabled', false);
                }

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

    // function triggerToooltip() {
    //     var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    //     var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    //         return new bootstrap.Tooltip(tooltipTriggerEl)
    //     })
    // }

    function timLichFillModal(tuyen, ngay, idlichtrinh, vitri) {
        $.ajax({
            type: "GET",
            url: "/ve/quanlyve/timlich",
            data: {
                tuyen: tuyen,
                ngay: ngay
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
                        // alert(e.data.lichtrinh[$index].lichtrinh.id_lichtrinh);
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

    function showModalSuaVe(idve, element) {
        $('#formsuave').trigger("reset");
        $('#suangay').val("");
        $('#lichxechay').val("");
        $('#seat').empty();
        $('input#tenkhach').val(element.closest("tr").find("td:nth-child(1)").text());
        $('input#sodienthoai').val(element.closest("tr").find("td:nth-child(2)").text());
        $('input#trungchuyen').val(element.closest("tr").find("td:nth-child(3)").text())
        $('#modalchuyenlich').attr("data-idlichtrinh", idve);
        position.length = 0;
        // alert(idve);
        // alert("hell");
        // alert("dg");
        // $temp = $('#2').after("<tr></tr>").next().append('<td colspan="12"></td>');
        // $v = $temp.children();
        // $v.append($('#formchuyenlich'))
        $('#modalchuyenlich').modal('show')
    }

    function clickSuaVe() {
        $('button[name="btnchuyenlich"]').click(function (e) {
            e.stopImmediatePropagation();
            var idve = $(this).closest("tr").attr("id");
            // var element = $(this);
            position.length = 0;
            fillFormModal(idve);
            // showModalSuaVe(idve, element);
        });
    }

    $('button[name="btntimlichtrinh"]').click(function (e) {
        e.preventDefault();
        $tuyen = $('#modalsuave-suatuyen').val();
        $ngay = $('#modalsuave-suangay').val();
        timLichFillModal($tuyen, $ngay, idlichtrinh_khach, vitri_khach);
    });

    // $('button[name="btntimlichtrinh"]').click(function (e) {
    //     e.preventDefault();
    //     $tuyen = $('#suatuyen').val();
    //     $ngay = $('#suangay').val();
    //     $.ajax({
    //         type: "GET",
    //         url: "/ve/quanlyve/timlich",
    //         data: {
    //             tuyen: $tuyen,
    //             ngay: $ngay
    //         },
    //         dataType: "json",
    //         success: function (data) {
    //             console.log(data);

    //             $('#lichxechay').empty();
    //             data.forEach((element, index) => {
    //                 let opption = $('<option data-index="' + index + '" value="' + element.lichtrinh.id_lichtrinh + '">' + element.bendi.name_benxe + " - " + element.benden.name_benxe + " - Giờ đi " + element.lichtrinh.giodi + '</option>');
    //                 $('#lichxechay').append(opption);
    //             });
    //             $('#lichxechay').off("change");
    //             idlt = -1;
    //             $('#lichxechay').change({ lichtrinh: data }, function (e) {
    //                 idlt = $(this).find('option:selected').val();
    //                 $index = $(this).find('option:selected').attr("data-index");
    //                 // alert(idlt + " " + $index);
    //                 $('#seat').empty();
    //                 $('#seat').append(e.data.lichtrinh[$index].loaixe.sodo);

    //                 // e.data.lichtrinh[$index].ve.forEach(element => {
    //                 //     let selecttd = $('td[data-seat="' + item.vitri + '"]');
    //                 //     selecttd.find('rect').attr("fill", "red");
    //                 //     selecttd.addClass('disable-cursor').removeClass('able-cursor');
    //                 // });
    //                 $.each(e.data.lichtrinh[$index].ve, function (i, item) {
    //                     let selecttd = $('td[data-seat="' + item.vitri + '"]');
    //                     selecttd.find('rect').attr("fill", "red");
    //                     selecttd.addClass('disable-cursor').removeClass('able-cursor');
    //                 });

    //                 actionRegisterSeat();
    //                 // actionRegisterSeat();
    //             });

    //             $('#lichxechay').trigger('change');
    //             actionRegisterSeat();
    //             // console.log(data);
    //         },
    //         error: function (data) {
    //             alert("Lỗi hệ thống tìm kiếm he!");
    //             var errors = data.responseJSON;
    //             console.log(errors);
    //         }
    //     });
    // });


    $('#submitcapnhat').click(function (e) {
        e.stopImmediatePropagation();
        let tenkhach = $('input#modalsuave-tenkhach').val();
        let sodienthoai = $('input#modalsuave-sodienthoai').val();
        let trungchuyen = $('input#modalsuave-trungchuyen').val();
        let idlichtrinh = $('#modalsuave-lichxechay').val();
        let vitri = position[0];
        let idve = $('#modalchuyenlich').attr("data-idve");

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
            success: function (data) {
                if (data != true) {
                    alert("Vé chưa được cập nhật!")
                }
                $('#modalchuyenlich').modal("hide");
                buttonprevious.trigger("click");
                // alert(data);
            },
            error: function (data) {
                alert("Lỗi hệ thống khi cập nhật vé!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });

    });

    $('#submitxoa').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "/xoave/" + $('#modalchuyenlich').attr("data-idve"),
            success: function (data) {
                // alert("Vé đã xóa thành công");
                // $('#modalchuyenlich').modal('hide');
                buttonprevious.trigger("click");
            },
            error: function (data) {
                alert("Lỗi hệ thống tìm kiếm he!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });


    function clickXuatVe() {
        $('button[name="btnxuatve"]').click(function (e) {
            e.stopImmediatePropagation();
            idve = $(this).closest("tr").attr("id");

            $.ajax({
                type: "GET",
                url: "/ve/inve/" + idve,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#tentuyen').text(data[0].tentuyen);
                    $('#biensoxe').text(data[0].soxe);
                    $('#bendi').text(data[0].bendi);
                    $('#benden').text(data[0].benden);
                    $('#giokhoihanh').text(data[0].giokhoihanh);
                    $('#ngaykhoihanh').text(data[0].ngaykhoihanh);
                    $('#vitri').text(data[0].soghe);
                    $('#giatien').text(data[0].giave);
                    $('#tenkhach').text(data[0].tenkhach);
                    $('#sodienthoai').text(data[0].sodienthoai);

                    $('body').css("visibility", "hidden");
                    $('#divinve').css("visibility", "visible");
                    window.print();
                    $('#divinve').css("visibility", "hidden");
                    $('body').css("visibility", "visible");

                    buttonprevious.trigger("click");
                },
                error: function () {
                    alert("Không tìm thấy vé để in!")
                }
            });

        });
    }




});