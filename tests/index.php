<?php

// require files for testing
require_once __DIR__ . '/../src/Activity.php';
require_once __DIR__ . '/../src/Lap.php';
require_once __DIR__ . '/../src/TrackPoint.php';
require_once __DIR__ . '/../src/Converter.php';

require_once __DIR__ . '/../src/Parser.php';
require_once __DIR__ . '/../src/Parsers/GPXParser.php';
require_once __DIR__ . '/../src/Parsers/TCXParser.php';
require_once __DIR__ . '/../src/Parsers/CSVParser.php';
require_once __DIR__ . '/../src/Parsers/PWXParser.php';

require_once __DIR__ . '/../src/Calculators/CalorieCalculator.php';


$type = (isset($_GET['type'])) ? $_GET['type'] : 'tcx';

if ($type == 'tcx'){
    $parser = new \Waddle\Parsers\TCXParser();
    $activity = $parser->parse('run.tcx');
} elseif ($type == 'gpx') {
    $parser = new \Waddle\Parsers\GPXParser();
    $activity = $parser->parse('run.gpx');
} elseif ($type == 'csv'){
    $parser = new \Waddle\Parsers\CSVParser();
    $activity = $parser->parse('run.csv');
} elseif ($type == 'pwx'){
    $parser = new \Waddle\Parsers\PWXParser();
    $activity = $parser->parse('run.pwx');
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
var_dump( \Waddle\Converter::convertHumanReadableToSeconds( \Waddle\Converter::convertSecondsToHumanReadable($activity->getTotalDuration()) ) );

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
echo "Calculators:<br>";

echo "MET Score, running 6mph:";
var_dump(\Waddle\Calculators\CalorieCalculator::calculateMETFromMPH(6) );


echo "MET Score, running 6kmph:";
var_dump(\Waddle\Calculators\CalorieCalculator::calculateMETFromKMPH(6) );

echo "00:24:12 in hour decimal:";
var_dump(\Waddle\Converter::convertHoursMinutesSecondsToDecimal(0, 24, 12) );


echo "Calories burned, running 6mph, weighing 75kg, running for 23 minutes, 47 seconds:";
var_dump(\Waddle\Calculators\CalorieCalculator::calculateCaloriesBurned( \Waddle\Calculators\CalorieCalculator::calculateMETFromMPH(6) , 75, \Waddle\Converter::convertHoursMinutesSecondsToDecimal(0, 23, 47) ) );

echo "Calories burned, running 15.6kmph, weighing 90kg, running for 1 hour, 21 minutes, 05 seconds:";
var_dump(\Waddle\Calculators\CalorieCalculator::calculateCaloriesBurned( \Waddle\Calculators\CalorieCalculator::calculateMETFromKMPH(15.6) , 90, \Waddle\Converter::convertHoursMinutesSecondsToDecimal(1, 21, 5) ) );
