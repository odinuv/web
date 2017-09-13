<?php

$numberOfWheels = 4;
$drive = 'electric';

switch ($numberOfWheels) {
    case 4:
        switch ($drive) {
            case 'electric':
                echo "It's an electric car.";
                break;
            case 'combustion':
                echo "It's a smoking car.";
                break;
            case 'feet':
                echo "It's a Flintstones car.";
                break;
            default:
                echo "It's an unknown car.";
        }
        break;
    case 2:
        echo "It's a bike.";
        break;
    case 1:
        echo "It's a unicycle.";
        break;
    default:
        echo "I don't know what that is.";
}
