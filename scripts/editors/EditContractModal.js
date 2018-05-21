$(document).ready(function () {
    var contID = 0;
    $('#editContractForm').keydown(function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            return false;
        }
    });
    $('.edit-contract').click(function () {
        contID = $(this).attr('id');
        $('#editContractModal').modal('show');
        
        $.ajax({
            type : 'POST',
            url : 'controllers/GetContractDataById.php',
            data : {
                contractID : contID
            },
            success : function (reply) {
                $('#contractNumberInput-e').val(reply.contractNumber);
                $('#dateOfContractInput-e').val(reply.dateOfContract);
                $('#expirationDateInput-e').val(reply.expirationDate);
            }
        });

        $('#editContractSubmit').click(function () {
            $.ajax({
                type : 'POST',
                url : 'controllers/EditContract.php',
                data : {
                    contractID : contID,
                    contractNumber : $('#contractNumberInput-e').val(),
                    dateOfContract : $('#dateOfContractInput-e').val(),
                    expirationDate : $('#expirationDateInput-e').val()
                },
                success : function (reply) {
                    var editErrorAlert = $('#editErrorAlert');
                    var editErrorAlertText = $('#editErrorAlertText');
                    if(reply === 'OK') location.reload();
                    else if(reply === 'Empty')
                    {
                        editErrorAlertText.text("Заполните все поля!");
                        editErrorAlert.show('close');
                    }
                    else if(reply === 'Dublicate')
                    {
                        editErrorAlertText.text("Контракт с таким номером уже существует!");
                        editErrorAlert.show('close');
                    }
                }
            });
        });
    });
});