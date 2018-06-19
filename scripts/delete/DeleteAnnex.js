$(document).ready(function () {
    var annexID = 0;
    var contractID = 0;
    $('.delete-annex').click(function () {
        annexID = $(this).attr('id').split("/")[0];
        contractID = $(this).attr('id').split("/")[1];
        $('#warningDialogText').text("Вы действительно хотите удалить приложение?");
        $('#deleteWarning').modal('show');
        $('#deleteConfirm').click(function () {
            $.ajax({
                type : 'POST',
                url : 'controllers/DeleteAnnex.php',
                data : {
                    annexID : annexID
                },
                success : function (reply) {
                    if(reply === 'OK') location.reload();
                }
            });
        });
    });
});