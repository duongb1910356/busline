$(document).ready(function () {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    var position = [];
    var currentchoice = null;
    $('#ngaydi').val(today);

    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 2
    })

    function drawPositionOrder($position) {
        $('#position').empty();
        if ($position.length != 0) {
            position.forEach(element => {
                $('#position').append(element + ", ");
            });

        }
    }

    function tinhTien($giave, $position) {
        return $position.length * $giave;
    }

    $('button[name="submitdatve"]').click(function (e) {
        e.preventDefault
        $tenkhach = $('#tenkhach').val();
        $sodienthoai = $('#sodienthoai').val();
        $id_giave = $('#exampleModal').attr("data-idgiave");
        $id_nhanvien = $('#id-nhanvien').attr("data-id-nhanvien");
        $trungchuyen = $('#trungchuyen').val();
        $tinhtrang = 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "/ve/banve/datve",
            data: {
                lichtrinh: $idlichtrinh,
                nhanvien: $id_nhanvien,
                tenkhach: $tenkhach,
                sodienthoai: $sodienthoai,
                giave: $id_giave,
                vitri: position,
                tinhtrang: $tinhtrang,
                trungchuyen: $trungchuyen
            },
            success: function (data) {
                console.log(data)
                data = jQuery.parseJSON(data);
                if (data.check == true) {
                    alert("Vé đã được đặt thành công");
                    currentchoice.find('span[name="soghetrong"]').text('Số ghế trống: ' + data.sochotrong);
                }
                else if (data.check == false)
                    alert("Vị trí đã được chọn trước đó");

                // currentchoice.find('#soghetrong').text(data.sochotrong);
                // alert(data.check)
                $('#exampleModal').modal('hide');

            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }

        });
    })
    function getSoChoTrong($idlichtrinh) {
        $.ajax({
            type: "GET",
            url: "/laysochotrong",
            data: {
                "idlichtrinh": $idlichtrinh
            },
            success: function (data) {

            },
            error: function (data) {
                alert("Lỗi hệ thống!");
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    }

    function clickLichTrinh() {
        $('#maincontent > div.main-item-roundbus').click(function () {
            currentchoice = $(this);
            // currentchoice.find('span[name="soghetrong"]').text("data.sochotrong");
            $idlichtrinh = $(this).attr("data-id-lichtrinh");
            $giave = $(this).attr("data-giave");
            $('#exampleModal').attr("data-idgiave", $(this).attr("data-id-giave"));
            $('#name-tuyen').text("Tuyến: " + $(this).attr("data-name-tuyen"));
            $('#name-benxe').text("Lộ trình: " + $(this).attr("data-benxe"))
            position.length = 0;
            $('#position').empty();
            document.getElementById("formdatve").reset();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "/ve/banve/lichtrinh/" + $idlichtrinh,
                dataType: "json",
                success: function (data) {
                    // $data = json_decode($data, true);
                    $('#map-seat').html(data.loaixe[0].sodo);

                    $.each(data.ves, function (i, item) {
                        let selecttd = $('td[data-seat="' + item.vitri + '"]');
                        selecttd.find('rect').attr("fill", "red");
                        selecttd.addClass('disable-cursor').removeClass('able-cursor');
                    });

                    $('.able-cursor').on('click', function (e) {
                        let current = $(this).find('rect');
                        if (current.attr('fill') == 'white') {
                            current.attr('fill', '#0dcaf0');
                            position.push($(this).attr("data-seat"));
                            drawPositionOrder(position);
                            $('#tongtien').text(formatter.format(tinhTien($giave, position)));
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
                            $('#tongtien').text(formatter.format(tinhTien($giave, position)));
                            console.log(position)

                        }
                    })

                    $('.disable-cursor').on('click', function (e) {
                        e.preventDefault();
                    })

                },
                error: function () {
                    alert("Không tìm thấy lịch trình phù hợp")
                }

            });
        })
    }

    $('#tuyen').change(function (e) {
        $id_tuyen = $(this).val();
        $ngaydi = $('#ngaydi').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "/ve/banve/lichtrinh",
            data: {
                id_tuyen: $id_tuyen,
                ngaydi: $ngaydi
            },
            success: function (data) {
                $('#maincontent').html(data);
                clickLichTrinh();
            },
            error: function () {
                alert("Không tìm thấy lịch trình phù hợp")
            }

        });
    });

    $('#ngaydi').change(function () {
        $('#tuyen').trigger('change');
    })

    const trig = function () {
        let check = $('#maincontent').attr("data-trigger");
        if (check == "true") {
            $('#tuyen').trigger('change');
            $('#maincontent').attr("data-trigger", "false");
        }
    }
    trig();



    // SESSION FOR DATVE



});
