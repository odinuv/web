
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
            text('E-mail je v pořádku.').
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
                    $('#pointsConclusion').html('To je dostatečný počet, takže máte <strong>splněno</strong>.');
                    cont.addClass('valid').removeClass('invalid');
                } else {
                    $('#pointsConclusion').html('To zatím ještě <strong>nestačí</strong>.');
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
            text('Zadaný E-mail nemám v databázi studentů, pokud opravdu studujete APV v tomto semestru, pošlete mi zprávu (ICQ, e-mail).').
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
        text('Došlo k chybě: ' + response.status + ': ' + msg).
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
