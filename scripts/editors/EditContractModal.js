$(document).ready(function () {
    var contID = 0;
    $('.edit-contract').click(function () {
        $('#edit-contract-modal').show();
        contID = $(this).attr('id');
        console.log(contID);
        $.ajax({
            type : 'POST',
            url : 'controllers/GetContractDataById.php',
            data :
                {
                    contractID : contID
                },
            success : function (reply) {
                $('#e-contractNumber').val(reply.contractNumber);
                $('#e-dateOfContract').val(reply.dateOfContract);
                $('#e-expirationDate').val(reply.expirationDate);
            }
        });
    });
    $('.close2').click(function () {
        $('#edit-contract-modal').hide();
    });
    $('#edit-contract-submit').click(function () {
        $.ajax({
            type : 'POST',
            url : 'controllers/EditContract.php',
            data : {
                contractID : contID,
                contractNumber : $('#e-contractNumber').val(),
                dateOfContract : $('#e-dateOfContract').val(),
                expirationDate : $('#e-expirationDate').val()
            },
            success : function (reply) {
                if(reply === 'OK') window.location.reload();
                else
                {
                    alert("Неверные данные! Контракт с таким номером уже существует!");
                    console.log(reply);
                }
            }
        })
    });
});