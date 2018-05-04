$(document).ready(function () {
    var cid = 0;
    $('.edit-company').click(function () {
        cid = $(this).attr('id');
        //console.log(cid);
        $('#edit-company-modal').toggle();
        $.ajax({
            type : 'POST',
            url : 'controllers/GetCompanyDataById.php',
            data : {
                compID : cid
            },
            success : function (reply) { //returns JSON
                $('#e-compName').val(reply.compName);
                $('#e-contactInfo').val(reply.contactInfo);
            }
        });

    });
    $('.close').click(function() {
        $('#edit-company-modal').hide();
    });

    $('#edit-company-submit').click(function () {
        $.ajax({
            type : 'POST',
            url : 'controllers/EditCompany.php',
            data : {
                compID : cid,
                compName : $('#e-compName').val(),
                contactInfo : $('#e-contactInfo').val()
            },
            success : function (reply) {
                if(reply === 'OK') window.location.reload();
                else
                {
                    alert("Неверные данные! Компания с таким названием уже существует.");
                }
            }
        });
    })
});