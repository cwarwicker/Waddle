Waddle
======

Waddle is a PHP library for parsing GPS activities (e.g. from a Sports Watch) and calculating various metrics.
It supports the parsing of .TCX, .GPX, .PWX and .CSV files.


Installation
-----

### via Composer

```javascript
{
    "require": {
        "duckfusion/waddle": "^1.0"
    }
}
```        

### via Zip file

Download the Waddle zip file from this repository and place inside your project.
You will then need to require or include the files you wish to use, unless you are making use of an autoloader.


Example Usage
-----

```php
<?php
$parser = new \Waddle\Parsers\TCXParser();
$activity = $parser->parse('/path/to/activity.tcx');
```

This will parse the .tcx file and load the Activity into the $activity variable, which can then be used to calculate metrics:

```php
<?php
$parser = new \Waddle\Parsers\TCXParser();
$activity = $parser->parse('/path/to/activity.tcx');

// Get some key metrics
$totalDistance = $activity->getTotalDistance(); # In metres, e.g. 1000
$totalDuration = $activity->getTotalDuration(); # In seconds, e.g. 255
$totalCalories = $activity->getTotalCalories(); # e.g. 100

// Convert those metrics into more human-readable values
$totalDistanceInMiles = \Waddle\Converter::convertMetresToMiles($totalDistance); # e.g. 0.62
$totalDurationInHoursMinutesSeconds = \Waddle\Converter::convertSecondsToHumanReadable($totalDuration); # e.g. 00:04:15
```
    
    
Available Parsers    
------    
```php
$parser = new \Waddle\Parsers\TCXParser();
$parser = new \Waddle\Parsers\GPXParser();
$parser = new \Waddle\Parsers\PWXParser();
$parser = new \Waddle\Parsers\CSVParser();
```

All parsers just have the one ```parse()``` method you need to call, passing in the path to your relevant file, as seen in earlier examples. This ```parse()``` method returns an instance of the Activity class (or throws an exception upon failure). This Activity object can then be used to calculate all the different metrics based on the file contents.


Available Activity Metrics/Data
-----
```$activity->getType()``` - This returns the type of activity, e.g. "Running" or "Cycling"

```$activity->getStartTime($format)``` - This returns the start time of the activity. The ```$format``` variable should contain a [valid data format](http://php.net/manual/en/datetime.formats.php)

```$activity->getTotalDistance()``` - This returns the total distance of the activity, in metres.

```$activity->getTotalDuration()``` - This returns the total duration of the activity, in seconds.

```$activity->getAveragePacePerMile()``` - This returns the average pace per mile of the activity, in the format "hh:mm:ss".

```$activity->getAveragePacePerKilometre()``` - This returns the average pace per kilometre of the activity, in the format "hh:mm:ss".

```$activity->getAverageSpeedInMPH()``` - This returns the average speed of the activity, in miles per hour.

```$activity->getAverageSpeedInKPH()``` - This returns the average speed of the activity, in kilometres per hour.

```$activity->getTotalCalories()``` - This returns the total calories burned in the activity (if this was specified in the file).

```$activity->getMaxSpeedInMPH()``` - This returns the maximum speed of the activity, in miles per hour.

```$activity->getMaxSpeedInKPH()``` - This returns the maximum speed of the activity, in kilometres per hour.

```$activity->getTotalAscentDescent()``` - This returns an array with the total distance ascended and decended, in metres.

```$activity->getSplits($type)``` - This retrurns an array of the activity splits. The ```$type``` variable should contain either "m" for miles, or "k" for kilometres. The activity will then be split into 1 mile/kilometre points. **Future** - In the future this will split into mini Activity objects, so metrics can be calculated on individual splits as well.


Differences Between The Parsers
-----
Some file formats contain more information than others. For example, a standard .TCX or .PWX file contains summary information at the top, with the Total Duration of the activity, the Total Distance, etc... Whereas formats such as .CSV and .GPX do not, so this information is calculated by the Parser. As such you may find slight differences between the results of the Parsers.


Converting Metrics Between Formats
-----
By default some metrics are calculated in unhelpful measures, such as Total Distance being in metres, when you might want a more helpful measure, such as miles or kilometres.

You can use the Converter class to convert between formats:

```\Waddle\Converter::convertMetresPerSecondToMilesPerHour($val)``` - This converts a metres per second value, into miles per hour.

```\Waddle\Converter::convertMetresPerSecondToKilometresPerHour($val)``` - This converts a metres per second value, into kilometres per hour.

```\Waddle\Converter::convertMetresToKilometres($val)``` - This converts a metres value, into kilometres.

```\Waddle\Converter::convertMetresToMiles($val)``` - This converts a metres value, into miles.

```\Waddle\Converter::convertMetresToFeet($val)``` - This converts a metres value, into feet.

```\Waddle\Converter::convertMilesToMetres($val)``` - This converts a miles value, into metres.

```\Waddle\Converter::convertKilometresToMetres($val)``` - This converts a kilometres value, into metres.

```\Waddle\Converter::convertHoursMinutesSecondsToDecimal($h, $m, $s)``` - This converts the values of hours, minutes and seconds, into a decimal hour value. For example, 2 hours, 45 minutes and 0 seconds, would be converted to a decimal "2.75" hours.

```\Waddle\Converter::convertSecondsToHumanReadable($val)``` - This converts a seconds value, into the format "hh:mm:ss".

```\Waddle\Converter::convertHumanReadableToSeconds($val)``` - This converts a string with the format "hh:mm:ss", into seconds.


Extras - Calculators
-----
In addition to the calculations available on the Activity class, there are also extra Calculator classes you can use to calculate data not included in the GPS activity file, such as Calories burned.

### CalorieCalculator
The CalorieCalculator class uses MET (Metabolic Equivilent) scores to calculate how many calories are burned, based on the intensity of the activity and the weight of the person.

It should be noted that calorie calculations can vary quite wildly between different systems and should only ever be used as a rough estimate, as there are many things which can affect how quickly an individual burns calories.

#### Available methods
```\Waddle\Calculators\CalorieCalculator::calculateMETFromMPH($avgSpeed)``` - This calculates the rough MET score of a Running activity, based on the average speed in miles per hour.

```\Waddle\Calculators\CalorieCalculator::calculateMETFromKPH($avgSpeed)``` - This calculates the rough MET score of a Running activity, based on the average speed in kilometres per hour.

```\Waddle\Calculators\CalorieCalculator::calculateCaloriesBurned(float $mets, float $weightInKG, float $timeInHours)``` - This calculates the rough Calories burned, based on the MET score of the activity, the weight of the person in kilograms, and the duration of the activity, in decimal time.

#### Examples
```php
// Get the average speed in MPH
$averageSpeedInMPH = $activity->getAverageSpeedInMPH();

// Calculate the MET score
$metScore = \Waddle\Calculators\CalorieCalculator::calculateMETFromMPH($averageSpeedInMPH);

// Get the weight of the person in KG
$weightInKG = 75;

// Get the duration and convert to hours decimal
$durationInHumanReadable = \Waddle\Converter::convertSecondsToHumanReadable($activity->getTotalDuration());
$durationSplit = explode(":", $durationInHumanReadable);
$durationInDecimalHours = \Waddle\Converter::convertHoursMinutesSecondsToDecimal($durationSplit[0], $durationSplit[1], $durationSplit[2]);

// Calculate the calories burned
$caloriesBurned = \Waddle\Calculators\CalorieCalculator::calculateCaloriesBurned($metScore , $weightInKG, $durationInDecimalHours );
```

Help
-----
If you need any help with Waddle, just raise an issue describing the problem.
