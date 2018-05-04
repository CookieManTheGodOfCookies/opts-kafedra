$(document).ready(function () {
    $('.delete-company').click(function () {
        var cid = $(this).attr('id');
        //console.log(cid);
        var anUrl = 'controllers/DeleteCompany.php';
        $.ajax({
            type : 'POST',
            url : anUrl,
            data : {
                compID : cid
            },
            success : function (reply) {
                if(reply === 'OK') document.location.reload();
                else
                {
                    alert("Невозможно удалить компанию! Для начала удалите все связанные с ней договоры и приложения!");
                }
            }
            }
        );
    });
});
