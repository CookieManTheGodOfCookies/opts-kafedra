$(document).ready(function(){
    var cid = 0;
    $('.deleteCompany').click(function(){
        cid = $('.companyID').attr('id');
        $('#warningDialogText').text("Вы действительно хотите удалить компанию? Все связанные с ней контракты и приложения удалятся!");
        $('#deleteWarning').modal('show');
        $('#deleteConfirm').click(function () {
            $.ajax({
                type : 'POST',
                url : 'controllers/DeleteCompany.php',
                data : {compID : cid},
                success : function (reply) {
                    if(reply === 'OK') location.href = 'CompaniesList.php';
                }
            });
        });
    });
});