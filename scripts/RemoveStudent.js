$(document).ready(function () {
    var studentID = 0;
    $('.remove-student').click(function () {
        studentID = $(this).attr('id');
        $.ajax({
            type : 'POST',
            url : 'controllers/RemoveStudent.php',
            data : {
                studentID : studentID
            },
            success : function (reply) {
                if(reply === 'OK') location.reload();
                else
                {
                    console.log(reply);
                }
            }
        })
    });
});