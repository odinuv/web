<?php

$numberOfWheels = 4;
$drive = 'electric';

if (($numberOfWheels == 4) && ($drive == 'electric')) {
    echo "It's an electric car.";
} elseif (($numberOfWheels == 4) && ($drive == 'combustion')) {
    echo "It's a smoking car.";
} else if (($numberOfWheels == 4) && ($drive == 'feet')) {
    echo "It's a Flintstones car.";
} elseif ($numberOfWheels == 2) {
    echo "It's a bike.";
} else if ($numberOfWheels == 1) {
    echo "It's a unicycle.";
} else {
    echo "I don't know what that is.";
}
