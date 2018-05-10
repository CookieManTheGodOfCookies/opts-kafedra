$(document).ready(function () {
    var annexID = 0;
    $('.delete-annex').click(function () {
        annexID = $(this).attr('id');
        $.ajax({
            type : 'POST',
            url : 'controllers/DeleteAnnex.php',
            data : {annexID : annexID},
            success : function (reply) {
                if(reply === 'OK') location.reload();
                else
                {
                    alert("Невозможно удалить приложение! Сначала открепите от приложения оставшихся студентов!");
                    //console.log(reply);
                }
            }
        });
    });
});