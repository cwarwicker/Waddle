<?php

// require files for testing
require_once __DIR__ . '/../src/Activity.php';
require_once __DIR__ . '/../src/Lap.php';
require_once __DIR__ . '/../src/TrackPoint.php';
require_once __DIR__ . '/../src/Converter.php';

require_once __DIR__ . '/../src/Parser.php';
require_once __DIR__ . '/../src/Parsers/GPXParser.php';
require_once __DIR__ . '/../src/Parsers/TCXParser.php';


if (@$_GET['type'] == 'tcx'){
    $parser = new \Waddle\Parsers\TCXParser();
    $activity = $parser->parse('run.tcx');
} else {
    $parser = new \Waddle\Parsers\GPXParser();
    $activity = $parser->parse('run.gpx');
}

echo "starttime:";
var_dump($activity->getStartTime('d-m-Y H:i:s'));

echo "dist:";
var_dump( $activity->getTotalDistance() );
var_dump( \Waddle\Converter::convertMetresToMiles($activity->getTotalDistance()) . ' mi') ;
var_dump( \Waddle\Converter::convertMetresToKilometres($activity->getTotalDistance()) . ' k') ;


echo "dur:";
var_dump( $activity->getTotalDuration() );
var_dump( \Waddle\Converter::convertSecondsToHumanReadable($activity->getTotalDuration()) );

echo "pace:";
var_dump( $activity->getAveragePacePerMile() );
var_dump( $activity->getAveragePacePerKilometre() );

echo "cal:";
var_dump( $activity->getTotalCalories() );

echo "avg speed:";
var_dump( $activity->getAverageSpeedInMPH() . ' mph') ;
var_dump( $activity->getAverageSpeedInKPH(). ' kph') ;

echo "max speed:";
var_dump( $activity->getMaxSpeedInMPH() . ' mph') ;
var_dump( $activity->getMaxSpeedInKPH() . ' kph') ;

echo "elevation:";
$elv = $activity->getTotalAscentDescent();
var_dump($elv);
var_dump( 'up ' . \Waddle\Converter::convertMetresToFeet( $elv['ascent'] ) . ' ft');
var_dump( 'down ' . \Waddle\Converter::convertMetresToFeet( $elv['descent'] ) . ' ft');

echo "splits:";
var_dump( $activity->getSplits('mi') );
var_dump( $activity->getSplits('k') );



echo "<hr>";
var_dump($parser);