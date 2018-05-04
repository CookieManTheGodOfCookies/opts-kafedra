$(document).ready(function () {
    var contractID = 0;
    $('.delete-contract').click(function () {
        contractID = $(this).attr('id');
        $.ajax({
            type : 'POST',
            url : 'controllers/DeleteContract.php',
            data : {
                contractID : contractID
            },
            success : function (reply) {
                if(reply === 'OK') window.location.reload();
                else
                {
                    alert("Невозможно удалить контракт! Сначала удалите все связанные с ним приложения!");
                    //console.log(reply);
                }
            }
        })
    });
});