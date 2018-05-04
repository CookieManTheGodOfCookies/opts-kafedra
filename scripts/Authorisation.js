$(document).ready(function () {
    console.log('Document ready');
    $('#auth-submit').click(function () {
        console.log('Received a click from auth-submit');
        $.ajax({
            type: 'POST',
            url: 'controllers/Authorisation.php',
            data: $('#auth-form').serialize(),
            success: function (reply) {
                if(reply === 'OK') {
                    window.location.href = 'StudentList.php';
                } else {
                    window.alert(reply);
                    console.log("REPLY FORM AUTH : " + reply);
                }
            }
        })
    })
});