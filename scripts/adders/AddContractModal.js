$(document).ready(function () {
    var cid = 0;
    $('#addContractForm').keydown(function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            return false;
        }
    });
    $('#add-contract').click(function () {
        cid = $('.companyID').attr('id');
        $('#addContractModal').modal('show');

        $('#addContractSubmit').click(function () {
            $.ajax({
                type : 'POST',
                url : 'controllers/AddContract.php',
                data : {
                    compID : cid,
                    contractNumber : $('#contractNumberInput-a').val(),
                    dateOfContract : $('#dateOfContractInput-a').val(),
                    expirationDate : $('#expirationDateInput-a').val()
                },
                success : function (reply) {
                    var addErrorAlert = $('#addErrorAlert');
                    var addErrorAlertText = $('#addErrorAlertText');
                    if(reply === 'OK') location.reload();
                    else if (reply === 'Empty') {
                        addErrorAlertText.text("Заполните все поля!");
                        addErrorAlert.show('close');
                    }
                    else if (reply === 'Dublicate') {
                        addErrorAlertText.text("Контракт с таким номером уже существует!");
                        addErrorAlert.show('close')
                    }
                }
            })
        });
    });
});