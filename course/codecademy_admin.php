<?php
require ('../../design/head.php');

head('Aplikační programové vybavení &ndash; Codecademy', 'Codecademy, administrace', 'Administrace uživatelů na Codecademy', '', '/cs/apv/cv01/', 'apv');

?>
<script>
    $(document).ready(function() {
        $('#refreshAllActiveUsers').bind('click', function() {
            cleanUp();
            $('#loader').show();
            $.ajax({
                url: 'CodecademyBackend.php',
                type: 'post',
                data: {act: "refreshAll", ack: $('#password').val()},
                async: true,
                dataType: 'json'
            }).done(function(data) {
                var container = $('#requestResult');
                var html;
                for (var i = 0; i < data.length; i++) {
                    html = '<p>' + data[i].firstName + ' ' + data[i].lastName + ' (' + data[i].email + ')';
                    if (data[i].userName) {
                        html += ' má účet ' + data[i].userName + ' a ' + data[i].points + ' bodů.';
                    } else {
                        html += ' nemá účet na CA';
                    }
                    html += '</p>';
                    container.append(html);
                }
                container.show();
                $('#loader').hide();
            }).fail(handleError);
        });

        $('#importUsers').bind('click', function() {
            cleanUp();
            $('#loader').show();
            $.ajax({
                url: 'CodecademyBackend.php',
                type: 'post',
                data: {act: "importUsers", ack: $('#password').val(), data: $('#csvContents').val()},
                async: true,
                dataType: 'json'
            }).done(function(data) {
                var container = $('#requestResult');
                var html;
                for (var i = 0; i < data.length; i++) {
                    html = '<p>' + data[i].email + ' (' + data[i].firstName + ' ' + data[i].lastName;
                    if (data[i].update) {
                        html += ' (updated)'
                    } else {
                        html += ' (new)'
                    }
                    html += '</p>';
                    container.append(html);
                }
                container.show();
                $('#loader').hide();
            }).fail(handleError);
        });
    });
</script>
<div class="formContainer">
    <p id="requestResult"></p>
    <p>
        <label for="password">Admin password:</label>
        <input type="password" id="password" />
    </p>
    <div id="loader"></div>
    <p>
        <button type="button" id="refreshAllActiveUsers">Refresh all active users</button>
    </p>
    <fieldset class="admin_fieldset">
        <legend>Import new users:</legend>
        <p>
            Export users from IS from <strong>List of students</strong> with the following configuration:<br />
            <img src="exportConfig.png" alt="Export configuration" id="exportConfig" />
        </p>
        <p>
            <label for="csvContents">Insert exported CSV file</label><br />
            <textarea id="csvContents"></textarea><br />
            <button type="button" id="importUsers">Import users</button>
        </p>
    </fieldset>
</div>

<?php
require('../../design/foot.php');
foot('sidebar.php');
?>

