<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Ondřej Popelka">
    <meta name="keywords" content="Web application, Tutorial, Development, PHP, Framework, Slim, Bootstrap, CSS, Javascript">
    <meta name="robots" content="index, follow">
    <meta name="description" content="Web application tutorial">
    <title>Codecademy score verification</title>

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

                        <h1>Verification of Codecademy.com goal</h1>
<div class="formContainer">
    <p>
        You have to finish some of <a href="https://www.codecademy.com/">Codecademy</a> courses to finish APV
        successfully. You may select any Codecademy course you like. There are courses fot PHP, JavaScript,
        jQuery, HTML, CSS, Python, API etc.
        Minimal score is <strong><?php echo CodecademyBackend::POINTS_REQUIRED ?></strong> points.
        Insert text <strong>[APV]</strong> (brackets included) somewhere into your profile (e.g "About Me" section
        in "Account settings").
    </p>
    <p>
        <label for="inputEmail">
            Insert <strong>Mendel University email</strong> in format <em>xlogin@node.mendelu.cz</em> (email used for
            Codecademy registration is <strong>not</strong> important):
        </label>
    </p>
    <div id="loader"></div>
    <p>
        <input id="inputEmail" autofocus="autofocus" placeholder="xlogin@node.mendelu.cz" type="email"/>
        <button type="button" id="verifyEmail" class="verify">Confirm</button>
    </p>
    <p id="requestResult"></p>
    <div id="profileResultSuccess" class="valid">
        <p>
            <span id="fullNameContainer">Your name is <span id="fullName"></span>.</span>
            Your Codecademy profile is <a id='urlDisplay' href='#'>#</a>.
        </p>
        <p>
            <button type="button" id="changeUserName">Change username</button>
        </p>
    </div>
    <div id="profileResultFail" class="invalid">
        <p>
            Your Codecademy profile is not yet available.
            <strong>
                <a href="http://www.codecademy.com/register/sign_up">Register Codecademy account</a>
            </strong>
            and insert your <strong>username</strong> (your profile URL).
            Insert text <strong>[APV]</strong> (including brackets) into your profile page.
        </p>
        <p>
            <label for="inputUserName">Insert username:</label>
        </p>
        <p>
            http://www.codecademy.com/<input id="inputUserName" type="text"/>
            <button class="verify verifyPoints" type="button">Verify and save</button>
        </p>
    </div>
    <div id="changeUserNameContainer">
        <p>
            <label for="inputNewUserName">Insert username:</label>
        </p>
        <p>
            http://www.codecademy.com/<input id="inputNewUserName" type="text"/>
            <button class="verify verifyPoints" type="button">Verify and save</button>
        </p>
    </div>
    <p id="pointResultSuccess" class="valid">
        There is <strong id="pointCount"></strong> points for this account.
        <span id="pointsConclusion"></span><br/>
        Score was acquired <span id="pointAcquired"></span>. Amount of points is automatically updated roughly once a week.
        <br/>
        <button class="verify verifyPoints" type="button">Fetch now</button>
    </p>
    <p id="pointResultFail" class="invalid">
        There is no score record in database. Amount of points is automatically updated roughly once a week.
        <br/>
        <button class="verify verifyPoints" type="button">Fetch now</button>
    </p>
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
</body>
</html>
