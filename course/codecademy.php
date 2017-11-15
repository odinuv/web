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

                        <h1>Kontrola splnění úkolu na Codecademy.com</h1>
<div class="formContainer">
    <p>
        Pro úspěšné ukončení předmětu APV si musíte udělat několik cvičení podle vlastního výběru na
        <a href='http://codecademy.com'>Codecademy.com</a>. Aktuálně jsou k dispozici cvičení na PHP, Javascript,
        jQuery, HTML, CSS, Python, API.
        Minimální požadovaný počet je <strong><?php echo CodecademyBackend::POINTS_REQUIRED ?></strong> cvičení
        (dosažených bodů).
        Do profilu na CA někam vložte text <strong>[APV]</strong>.
    </p>
    <p>
        <label for="inputEmail">Zadejte <strong>školní email</strong> (email použitý pro registraci na CA
            <strong>není</strong> důležitý):</label>
    </p>
    <div id="loader"></div>
    <p>
        <input id="inputEmail" autofocus="autofocus" placeholder="xlogin@node.mendelu.cz" type="email"/>
        <button type="button" id="verifyEmail" class="verify">Potvrdit</button>
    </p>
    <p id="requestResult"></p>
    <div id="profileResultSuccess" class="valid">
        <p>
            <span id="fullNameContainer">Vaše jméno je <span id="fullName"></span>.</span>
            Váš profil na Codecademy je <a id='urlDisplay' href='#'>#</a>.
        </p>
        <p>
            <button type="button" id="changeUserName">Změnit uživatelské jméno</button>
        </p>
    </div>
    <div id="profileResultFail" class="invalid">
        <p>
            Ještě nemáte zadaný svůj profil na Codecademy. <strong><a href="http://www.codecademy.com/register/sign_up">Zaregistrujte
                    se</a></strong>
            a vložte sem své <strong>uživatelské jméno</strong> (adresu svého profilu). Na viditelné místo v profilu
            (popis, jméno, umístění, &hellip;)
            napište text <strong>[APV]</strong> (včetně závorek).
        </p>
        <p>
            <label for="inputUserName">Zadejte uživatelské jméno:</label>
        </p>
        <p>
            http://www.codecademy.com/<input id="inputUserName" type="text"/>
            <button class="verify verifyPoints" type="button">Ověřit a uložit</button>
        </p>
    </div>
    <div id="changeUserNameContainer">
        <p>
            <label for="inputNewUserName">Zadejte nové uživatelské jméno:</label>
        </p>
        <p>
            http://www.codecademy.com/<input id="inputNewUserName" type="text"/>
            <button class="verify verifyPoints" type="button">Ověřit a uložit</button>
        </p>
    </div>
    <p id="pointResultSuccess" class="valid">
        Na účtu je <strong id="pointCount"></strong> bodů.
        <span id="pointsConclusion"></span><br/>
        Stav zjištěný <span id="pointAcquired"></span>. Počet bodů se načítá automaticky zhruba jednou za týden.<br/>
        <button class="verify verifyPoints" type="button">Načíst hned</button>
    </p>
    <p id="pointResultFail" class="invalid">
        V databázi zatím není uložen počet bodů. Počet bodů se načítá automaticky zhruba jednou za týden.<br/>
        <button class="verify verifyPoints" type="button">Načíst hned</button>
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
