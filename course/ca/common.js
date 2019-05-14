
// functions for codecademy
function cleanUp()
{
    $('#requestResult').
        empty().
        hide().
        removeClass('invalid').
        removeClass('valid');
    $('#profileResultSuccess').hide();
    $('#profileResultFail').hide();
    $('#pointResultSuccess').hide();
    $('#pointResultFail').hide();
    $('#changeUserNameContainer').hide();
    $('#loader').hide();
    $('#inputNewUserName').val('');
    $('#inputUserName').val('');
}


function handleGetUser(userData)
{
    cleanUp();
    var resultElm = $('#requestResult');
    resultElm.show();
    if (userData.valid) {
        resultElm.
            text('E-mail is OK.').
            addClass('valid');
        $('#inputEmail').
            data('userId', userData.idUser).
            data('userName', userData.userName);
        if (userData.profileUrl) {
            $('#urlDisplay').attr('href', userData.profileUrl).text(userData.profileUrl);
            if (userData.firstName) {
                $('#fullName').text(userData.firstName + ' ' + userData.lastName);
                $('#fullNameContainer').show();
            } else {
                $('#fullNameContainer').hide();
            }
            $('#profileResultSuccess').show();
            if (userData.pointsAcquired) {
                $('#pointAcquired').text(userData.pointsAcquired);
                $('#pointCount').text(userData.pointsAmount);
                var cont = $('#pointResultSuccess');
                cont.show();
                if (userData.pointsSufficient) {
                    $('#pointsConclusion').html('That is enough, you <strong>passed</strong> the requirement.');
                    cont.addClass('valid').removeClass('invalid');
                } else {
                    $('#pointsConclusion').html('That is not <strong>enough</strong> yet.');
                    cont.addClass('invalid').removeClass('valid');
                }
            } else {
                $('#pointResultFail').show();
            }
        } else {
            $('#profileResultFail').show();
            $('#inputUserName').val('');
        }
    } else {
        resultElm.
            text('Your email is not in database of students, if you really study APV course, send me a message (email).').
            addClass('invalid');
    }
    $('#loader').hide();
}


function handleError(response)
{
    cleanUp();
    var msg;
    if (response.responseJSON && response.responseJSON.message) {
        msg = response.responseJSON.message;
    } else {
        msg = response.statusText;
    }
    $('#requestResult').
        text('Error occurred: ' + response.status + ': ' + msg).
        addClass('invalid').
        show();
}


function verifyEmailHandler()
{
    cleanUp();
    var value = $("#inputEmail").val();
    if (!value.match(/.{3,}@.*?mendelu\.cz/)) {
        return;
    }
    $.ajax({
        url: 'ca/CodecademyBackend.php',
        type: 'post',
        data: {act: "getUser", email: value},
        async: true,
        dataType: 'json'
    }).done(handleGetUser).fail(handleError);
}

$(document).ready(function () {
    $('#inputEmail').bind('keyup change', verifyEmailHandler);
    $('#verifyEmail').bind('click', verifyEmailHandler);
    $('#changeUserName').bind('click', function () {
        $('#changeUserNameContainer').toggle();
    });
    $('.verifyPoints').bind('click', function () {
        $('#loader').show();
        var emlElm = $('#inputEmail');
        var userName = ($('#inputNewUserName').val() || $('#inputUserName').val()) || emlElm.data('userName');
        $.ajax({
            url: 'ca/CodecademyBackend.php',
            type: 'post',
            data: {act: "setUserName", userName: userName, email: emlElm.val(), idUser: emlElm.data('userId')},
            async: false,
            dataType: 'json'
        }).done(handleGetUser).fail(handleError);
    });
});
