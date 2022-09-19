$(document).ready(function () {
    $('#btn-submit').click(function (e) {
        e.preventDefault();
        $username = $('#username').val();
        $pass = $('#pass').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/login",
            type: "POST",
            data: {
                username: $username,
                pass: $pass
            },
            success: function (data) {
                if (data == '') {
                    window.location = "/ve/banve"
                } else {
                    $('.toast-container').empty();
                    $('.toast-container').append(data);
                    $('.toast').each(function (indexInArray,
                        valueOfElement) {
                        var toast2 = new bootstrap.Toast($(this));
                        toast2.show();
                    });

                }

            },
            error: function () {
                alert("Not submit")
            },

        });
    });
});
