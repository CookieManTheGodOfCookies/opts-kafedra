$(document).ready(function () {
    var anUrl = 'controllers/AddAnnex.php';
    $('#add-annex').click(function () {
        $('#add-annex-modal').modal('show');
        
        $('#add-annex-submit').click(function () {
            $.ajax({
                type : 'POST',
                url : anUrl,
                data : {
                    annexNumber : $('#annexNumberInput-a').val(),
                    practiceStart : $('#practiceStartInput-a').val(),
                    practiceEnd : $('#practiceEndInput-a').val(),
                    contractID : $('.contID').attr('id'),
                    practiceType : $('#practiceTypeSelect-a').val()
                },
                success : function (reply) {
                    var addErrorAlert = $('#addErrorAlert');
                    var addErrorAlertText = $('#addErrorAlertText');
                    if(reply === 'OK') location.reload();
                    else if(reply === 'Empty')
                    {
                        addErrorAlertText.text("Заполните все поля!");
                        addErrorAlert.show('close');
                    }
                    else if(reply === 'Dublicate')
                    {
                        addErrorAlertText.text("Приложение с таким номером уже существует!");
                        addErrorAlert.show('close');
                    }
                }
            });
        });
    });
});