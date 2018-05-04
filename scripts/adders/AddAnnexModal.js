$(document).ready(function () {
    var anUrl = 'controllers/AddAnnex.php';
    console.log('document ready.');
    $('#add-annex').click(function () {
        $('#add-annex-modal').toggle();
    });

    $('.close').click(function () {
        $('#add-annex-modal').toggle();
    });

    $('#add-annex-submit').click(function () {
        console.log('clicked shit');

        $.ajax({
            type: 'POST',
            url: anUrl,
            data: {
                "annexNumber": $('#annexNumber').val(),
                "practiceStart": $('#practiceStart').val(),
                "practiceEnd": $('#practiceEnd').val(),
                "contractID": $('.contID').attr('id'),
                "practiceType": $('#practiceType').val()
            },
            success: function (reply) {
                if (reply === 'OK') {
                    console.log('OK');
                    location.reload();
                }
                else {
                    alert('shit... check console');
                    console.log(reply);
                }
            }
        });
    });
});