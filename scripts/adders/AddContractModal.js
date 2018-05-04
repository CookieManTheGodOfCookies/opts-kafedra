$(document).ready(function () {
    //console.log("Document ready.");
    $('#add-contract').click(function () {
        $('#add-contract-modal').show();
    });

    $('.close').click(function () {
        $('#add-contract-modal').hide();
    });

    var compID = $('.compID').attr("id");
    $('#add-contract-submit').click(function () {
        var anUrl = 'controllers/AddContract.php';

        $.ajax({
            type : 'POST',
            url : anUrl,
            data : {
                "compID" : compID,
                "contractNumber" : $('#contractNumber').val(),
                "dateOfContract" : $('#dateOfContract').val(),
                "expirationDate" : $('#expirationDate').val()
            },
            success: function (reply) {
                if(reply === 'OK')
                {
                    //console.log('Added shit.');
                    location.reload();
                }
                else
                {
                    alert("Неверные данные! Договор с таким номером уже существует.");
                }
            }
        });
    });
});