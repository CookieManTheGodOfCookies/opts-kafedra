$(document).ready(function () {
    var contractID = 0;
    var companyID = 0;
    $('.delete-contract').click(function () {
        contractID = $(this).attr('id').split("/")[0];
        companyID = $(this).attr('id').split("/")[1];
        if(confirm("Вы действительно хотите удалить контракт?\nВсе связанные с ним приложения удалятся.")) {
            $.ajax({
                type: 'POST',
                url: 'controllers/DeleteContract.php',
                data: {
                    contractID: contractID
                },
                success: function (reply) {
                    if (reply === 'OK') window.location.href = "CompanyView.php?id=" + companyID;
                }
            });
        }
    });
});