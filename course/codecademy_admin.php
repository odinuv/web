<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Ondřej Popelka">
    <meta name="keywords" content="Web application, Tutorial, Development, PHP, Framework, Slim, Bootstrap, CSS, Javascript">
    <meta name="robots" content="index, follow">
    <meta name="description" content="Web application Tutorial">
    <title>Codecademy kontrola</title>

    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="ca/ca.css">
    <link rel="shortcut icon" href="/assets/img/favicon.png">
</head>
<body>
<?php
require(__DIR__ . DIRECTORY_SEPARATOR . 'ca/CodecademyBackend.php');
?>
<div class="root">
    <div class="container header hidden-print">
        <div class="inside">
            <!--
            <a href="/" class="logo"><img src="/assets/img/logo.png"></a>
            <span class="label">TEST</span>
            -->
            <form role="search" action="/search/">
                <input name="q" size="30" type="text" class="form-control"
                       placeholder="Search Site">
            </form>
        </div>
    </div>

    <div class="container main">
        <div class="inside">
            <div class="row">
                <div class="col-md-3 sidebar hidden-print">
                    <div class="navigation">
                        <ul class="nav">
                            <li class="current active">
                                <a href="/course/">APV Course</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 content">
                    <div class="page">
                        <ol class="breadcrumb">
                            <li><a href="/">Home</a></li>
                            <li>APV Course</li>
                        </ol>

                        <h1>Admin Codecademy.com</h1>    
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
            <img src="ca/exportConfig.png" alt="Export configuration" id="exportConfig" />
        </p>
        <p>
            <label for="csvContents">Insert exported CSV file</label><br />
            <textarea id="csvContents"></textarea><br />
            <button type="button" id="importUsers">Import users</button>
        </p>
    </fieldset>
</div>

  </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container footer hidden-print">
        <div class="inside">
            <p>
                2017 <a href='https://github.com/ujpef/site/graphs/contributors'>Authors</a>
                <a href='/LICENSE.txt'>CC-BY-SA-4.0</a>
            </p>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="ca/common.js"></script>
    <script>
    $(document).ready(function() {
        $('#refreshAllActiveUsers').bind('click', function() {
            cleanUp();
            $('#loader').show();
            $.ajax({
                url: 'ca/CodecademyBackend.php',
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
                url: 'ca/CodecademyBackend.php',
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
</body>
</html>