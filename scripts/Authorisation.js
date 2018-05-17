$(document).ready(function () {
    $('#auth-submit').click(function () {
        $.ajax({
            type: 'POST',
            url: 'controllers/Authorisation.php',
            data: $('#auth-form').serialize(),
            success: function (reply) {
                if(reply === 'OK') {
                    window.location.href = 'StudentList.php';
                } else {
                    $('#dangerAlert').show('close');
                }
            }
        })
    })
});