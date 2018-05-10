$(document).ready(function () {
    $('.delete-company').click(function () {
        var cid = $(this).attr('id');
        //console.log(cid);
        var anUrl = 'controllers/DeleteCompany.php';
        if(confirm("Вы действительно хотите удалить компанию?\nВсе связанные с ней контракты и приложения удалятся!")) {
            $.ajax({
                    type: 'POST',
                    url: anUrl,
                    data: {
                        compID: cid
                    },
                    success: function (reply) {
                        if (reply === 'OK') document.location.href = "CompaniesList.php";
                    }
                }
            );
        }
    });
});
