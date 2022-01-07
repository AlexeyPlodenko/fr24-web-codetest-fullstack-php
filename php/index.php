<?php 
include __DIR__ . '/vendor/autoload.php';

use fr24\FlightEvents;

# FlightEvents output:
header("Content-type: text/plain");
echo var_export( FlightEvents::fetch() );