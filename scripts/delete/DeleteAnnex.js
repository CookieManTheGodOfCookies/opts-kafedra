$(document).ready(function () {
    var annexID = 0;
    var contractID = 0;
    $('.delete-annex').click(function () {
        annexID = $(this).attr('id').split("/")[0];
        contractID = $(this).attr('id').split("/")[1];
        if(confirm("Вы действительно хотите удалить приложение?\n Все студенты автоматически открепятся!")) {
            $.ajax({
                type: 'POST',
                url: 'controllers/DeleteAnnex.php',
                data: {annexID: annexID},
                success: function (reply) {
                    if (reply === 'OK') window.location.href = "ContractView.php?id=" + contractID;
                    else
                        console.log(reply);
                }
            });
        }
    });
});