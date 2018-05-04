$(document).ready(function () {
    //console.log("Document ready.");
    $('#add-company').click(function () {
        $('#add-company-modal').toggle();
    });

    $('#close').click(function () {
        $('#add-company-modal').hide()
    });

    $('#add-company-submit').click(function () {
        var anUrl = 'controllers/AddCompany.php';
        $.ajax({
            type: 'POST',
            url: anUrl,
            data: $('#add-company-form').serialize(),
            success: function (reply) {
                if(reply === 'OK') {
                    //window.alert('OK');
                    location.reload();
                } else {
                    alert("Неверные данные! Проверьте, нет ли компании с таким же названием.");
                }
        }}
        );
    })
});