$(document).ready(function () {
    var cid = 0;
    $('.edit-company').click(function() {
        cid = $(this).attr('id');
        $('#editCompanyModal').modal('show');

        $.ajax({
            type : 'POST',
            url : 'controllers/GetCompanyDataById.php',
            data : {
                compID : cid
            },
            success : function (reply) {
                $('#companyNameInput-e').val(reply.compName);
                $('#contactInfoInput-e').val(reply.contactInfo);
            }
        });

        $('#edit-company-submit').click(function () {
            $.ajax({
                type : 'POST',
                url : 'controllers/EditCompany.php',
                data : {
                    compID : cid,
                    compName : $('#companyNameInput-e').val(),
                    contactInfo : $('#contactInfoInput-e').val()
                },
                success : function (reply) {
                    var editErrorAlert = $('#editErrorAlert');
                    var editErrorAlertText = $('#editErrorAlertText');
                    if (reply === 'OK') location.reload();
                    else if (reply === 'Empty') {
                        editErrorAlertText.text("Заполните все поля!");
                        editErrorAlert.show('close');
                    }
                    else if(reply === 'Dublicate') {
                        editErrorAlertText.text("Компания с таким именем уже существует!");
                        editErrorAlert.show('close');
                    }
                }
            });
        });
    });

});