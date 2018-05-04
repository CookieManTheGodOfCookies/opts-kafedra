$(document).ready(function () {
    var annexID = 0;
    $('.edit-annex').click(function () {
        $('#edit-annex-modal').show();
        annexID = $(this).attr('id');
        $.ajax({
            type : 'POST',
            url : 'controllers/GetAnnexDataById.php',
            data : {
                annexID : annexID
            },
            success : function (reply) {
                if(reply === 'error')
                {
                    console.log(reply);
                }
                else
                {
                    $('#e-annexNumber').val(reply.annexNumber);
                    $('#e-practiceStart').val(reply.practiceStart);
                    $('#e-practiceEnd').val(reply.practiceEnd);
                    $('#e-practiceType').val(reply.practiceType);
                }
            }
        });
    });
    $('.close2').click(function () {
        $('#edit-annex-modal').hide();
    });
    $('#edit-annex-submit').click(function () {
        $.ajax({
            type : "POST",
            url : 'controllers/EditAnnex.php',
            data : {
                annexID : annexID,
                annexNumber : $('#e-annexNumber').val(),
                practiceStart : $('#e-practiceStart').val(),
                practiceEnd : $('#e-practiceEnd').val(),
                practiceType : $('#e-practiceType').val()
            },
            success : function (reply) {
                if(reply === 'OK') location.reload();
                else
                {
                    alert("Неверные данные! Приложение с таким номером уже существует!");
                    console.log(reply);
                }
            }
        });
    });
});