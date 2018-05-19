$(document).ready(function () {
    $('.addCompany').click(function () {
        $('#addCompanyModal').modal('show');
    });

    $('#add-company-submit').click(function () {
        $.ajax({
            type : 'POST',
            url : 'controllers/AddCompany.php',
            data : {
                compName : $('#companyNameInput').val(),
                contactInfo : $('#contactInfoInput').val()
            },
            success : function (reply) {
                var errorAlert = $('#addErrorAlert');
                var errorAlertText = $('#addErrorAlertText');
                console.log(errorAlertText);
                if(reply === 'OK') location.reload();
                else if (reply === 'Empty') {
                    errorAlertText.text("Заполните все поля!");
                    errorAlert.show('close');
                }
                else if (reply === 'Dublicate data') {
                    errorAlertText.text("Компания с таким названием уже существует!");
                    errorAlert.show('close');
                }
            }
        });
    });
});