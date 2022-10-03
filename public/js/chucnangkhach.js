$(document).ready(function () {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    var position = [];
    var info = null;
    var index = null;
    $('#ngaydi').val(today);

    function drawPositionOrder($position) {
        $('#position').empty();
        if ($position.length != 0) {
            position.forEach(element => {
                $('#position').append(element + ", ");
            });

        }
    }

    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 2
    })

    function tinhTien($giave, $position) {
        return $position.length * $giave;
    }

    function clickLichTrinh() {
        $('#maincontent > div.main-item-roundbus').click(function (e) {
            e.stopImmediatePropagation();
            $('#forminputdatve').trigger("reset");
            $('#modalkhachdatve').modal("show");
            index = $(this).attr("data-index");
            let temp = info[index];
            // $('#name-tuyen').text(temp.tuyen.name_tuyen);
            $('#name-tuyen').text(temp.lichtrinh.giodi + " - " + temp.lichtrinh.ngaydi);

            $('#name-benxe').text(temp.benxeden.name_benxe + " - " + temp.benxedi.name_benxe);
            position = [];
            drawPositionOrder(position);
            $('#tongtien').text("");
            $('#map-seat').empty();
            $('#map-seat').append(temp.loaixe.sodo);
            $.ajax({
                type: "GET",
                url: "/datve/getlistcho",
                data: {
                    "idlichtrinh": temp.lichtrinh.id_lichtrinh
                },
                // dataType: "dataType",
                success: function (data) {
                    clickSeat(data, temp.giave.giave);
                },
                error: function (data) {
                    alert("Lỗi hệ thống!");
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        });
    }

    // function payMent($idve) {
    //     var str = $('#tongtien').text();
    //     var tongtien = Number(str.replace(/[^0-9.]+/g, ""));
    //     // alert(number);
    //     // ₫150,000.00
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         type: "POST",
    //         url: "/thanhtoan/" + $idve,
    //         data: {
    //             "tongtien": tongtien
    //         },
    //         // dataType: "dataType",
    //         success: function (data) {
    //             const json = JSON.parse(data);
    //             console.log(json.data);
    //             window.location = json.data
    //         },
    //         error: function (data) {
    //             alert("Lỗi hệ thống thanh toán!");
    //             var errors = data.responseJSON;
    //             console.log(errors);
    //         }
    //     });
    // }

    function payMent($data) {
        var str = $('#tongtien').text();
        var tongtien = Number(str.replace(/[^0-9.]+/g, ""));
        // alert(number);
        // ₫150,000.00
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/thanhtoan",
            data: {
                "tongtien": tongtien,
                "idves" : $data
            },
            // dataType: "dataType",
            success: function (data) {
                const json = JSON.parse(data);
                console.log(json.data);
                window.location = json.data
            },
            error: function (data) {
                alert("Lỗi hệ thống thanh toán!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    }

    function clickSeat(data, giave) {
        $.each(data, function (i, item) {
            let selected = $('td[data-seat="' + item.vitri + '"]');
            selected.find('rect').attr("fill", "red");
            selected.addClass('disable-cursor').removeClass('able-cursor');
        });

        $('.able-cursor').on('click', function (e) {
            let current = $(this).find('rect');
            if (current.attr('fill') == 'white') {
                current.attr('fill', '#0dcaf0');
                position.push($(this).attr("data-seat"));
                drawPositionOrder(position);
                $('#tongtien').text(formatter.format(tinhTien(giave, position)));
                console.log(position)

            } else if (current.attr('fill') == 'red') {
                e.preventDefault();
            } else {
                current.attr('fill', 'white');
                var temp = $(this).attr("data-seat");
                position = position.filter(function (value) {
                    return temp !== value;
                })
                drawPositionOrder(position);
                $('#tongtien').text(formatter.format(tinhTien(giave, position)));
                console.log(position)

            }
        })

    }

    $('#formtimlichtrinh').submit(function (e) {
        e.preventDefault();
        var actionurl = $(this).attr("action");
        var tinhdi = $('#tinhdi').val();
        var tinhden = $('#tinhden').val();
        var ngaydi = $('#ngaydi').val();
        $.ajax({
            type: "GET",
            url: actionurl,
            data: {
                "tinhdi": tinhdi,
                "tinhden": tinhden,
                "ngaydi": ngaydi
            },
            // dataType: "dataType",
            success: function (data) {
                console.log(data);
                info = data;
                let maincontent = $("#maincontent");
                maincontent.empty();

                data.forEach(function (element, index) {
                    let contain = $(`<div data-index="${index}" id="${element.lichtrinh.id_lichtrinh}" data-tentuyen="${element.tuyen.name_tuyen}" data-benxe="${element.benxedi.name_benxe} - ${element.benxeden.name_benxe}" class="main-item-roundbus  m-2 able-cursor" data-bs-toggle="modal" data-bs-target="#modalkhachdatve"></div>`);
                    let header = $(`<div class="main-item-title d-inline-flex justify-content-around align-items-center">
                     					<span class="text-white">${element.lichtrinh.giodi}</span>
                    					<span class="text-white border border-3 p-1" style="border-radius: 5px;">${element.xe.bienso}</span>
                    				</div>`);
                    let body = $(`<div class="px-2">
                     					<span style="font-size: 17px;">${element.tuyen.name_tuyen}</span><br>
                     					<span style="font-size: 17px;" class="fw-bold text-danger text-center">${element.benxedi.name_benxe} - ${element.benxeden.name_benxe}</span>
                     					<br>
                     					<span style="font-size: 17px;">Số ghế trống: ${element.ghetrong}</span><br>
                     				</div>`);
                    contain.append(header);
                    contain.append(body);
                    maincontent.append(contain);
                    clickLichTrinh();
                });


            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });

    $('button[name="submitdatve"]').click(function (e) {
        e.preventDefault();
        let typepayment = "op1"
        if ($('#inlineRadio2').prop("checked")) {
            typepayment = "op2";
        };
        let datalichtrinh = info[index];
        let tenkhach = $('#tenkhach').val();
        let sodienthoai = $('#sodienthoai').val();
        let id_giave = datalichtrinh.giave.id_giave;
        let trungchuyen = $('#trungchuyen').val();
        let tinhtrang = 0;
        // alert(position);
        var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
        if (sodienthoai !== '') {
            if (vnf_regex.test(sodienthoai) == false) {
                alert('Số điện thoại của bạn không đúng định dạng!');
                return false;
            }
        } else {
            alert('Bạn chưa điền số điện thoại!');
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "/datve/khach",
            data: {
                lichtrinh: datalichtrinh.lichtrinh.id_lichtrinh,
                tenkhach: tenkhach,
                sodienthoai: sodienthoai,
                giave: id_giave,
                vitri: position,
                tinhtrang: tinhtrang,
                trungchuyen: trungchuyen
            },
            success: function (data) {
                console.log(data);
                data = jQuery.parseJSON(data);
                // console.log(data.idves);
                if (data.miss.length != 0) {
                    data.miss.forEach(element => {
                        alert("Vị trí " + element + " chưa được đặt do đã có khách đặt trước");
                    });
                };

                if (typepayment == "op2") {
                    alert("Vui lòng thanh toán");
                    payMent(data.idves);
                } else {
                    alert("Vé đã được đặt thành công, vui lòng đến văn phòng gần nhất để lấy vé");
                }
                position = [];
                // if (!Array.isArray(data)) {
                //     if (typepayment == "op2") {
                //         alert("Vui lòng thanh toán");
                //         payMent(data);
                //     } else {
                //         alert("Vé đã được đặt thành công, vui lòng đến văn phòng gần nhất để lấy vé");
                //     }
                //     position = [];
                // }
                // else {
                //     // data.forEach(element => {
                //     //     alert("Vị trí " + element + " chưa được đặt do đã có khách đặt trước");
                //     // });
                //     alert("la mang");
                // }
                $('#modalkhachdatve').modal("hide");

            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }

        });
        // alert("ABC");

    })
});