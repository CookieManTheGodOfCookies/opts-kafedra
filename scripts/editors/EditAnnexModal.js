$(document).ready(function () {
    var annexID = 0;
    $('.edit-annex').click(function () {
            console.log('suka');
            $('#edit-annex-modal').modal('show');
            annexID = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'controllers/GetAnnexDataById.php',
                data: {
                    annexID: annexID
                },
                success: function (reply) {
                    $('#annexNumberInput-e').val(reply.annexNumber);
                    $('#practiceStartInput-e').val(reply.practiceStart);
                    $('#practiceEndInput-e').val(reply.practiceEnd);
                    $('#practiceTypeSelect-e').val(reply.practiceType);
                }
            });
            $('#edit-annex-submit').click(function () {
                $.ajax({
                    type: "POST",
                    url: 'controllers/EditAnnex.php',
                    data: {
                        annexID: annexID,
                        annexNumber: $('#annexNumberInput-e').val(),
                        practiceStart: $('#practiceStartInput-e').val(),
                        practiceEnd: $('#practiceEndInput-e').val(),
                        practiceType: $('#practiceTypeSelect-e').val()
                    },
                    success: function (reply) {
                        var editErrorAlert = $('#editErrorAlert');
                        var editErrorAlertText = $('#editErrorAlertText');
                        if (reply === 'OK') location.reload();
                        else if (reply === 'Empty')
                        {
                            editErrorAlertText.text("Заполните все поля!");
                            editErrorAlert.show('close');
                        }
                        else if (reply === 'Dublicate')
                        {
                            editErrorAlertText.text("Приложение с таким номером уже существует!");
                            editErrorAlert.show('close');
                        }
                    }
                });
            });
        }
    );
});