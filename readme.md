Waddle
======

Waddle is a PHP library for parsing running/cycling activities and calculating various metrics.
It currently supports the parsing of .TCX files, but support for more file types will be added in the future.

Example Usage
-----

```php
<?php

$parser = new \Waddle\Parser\TCXParser();
$activity = $parser->parse('/path/to/activity.tcx');
```

This will load the parse the .tcx file and load the activity into the $activity variable, which can then be used to calculate metrics.


Calculating Metrics
-----

```php
<?php

$parser = new \Waddle\Parser\TCXParser();
$activity = $parser->parse('/path/to/activity.tcx');

// Get some key metrics
$totalDistance = $activity->getTotalDistance(); # In metres, e.g. 1000
$totalDuration = $activity->getTotalDuration(); # In seconds, e.g. 255
$totalCalories = $activity->getTotalCalories(); # e.g. 100

// Convert those metrics into more human-readable values
$totalDistanceInMiles = \Waddle\Converter::convertMetresToMiles($totalDistance); # e.g. 0.62
$totalDurationInHoursMinutesSeconds = \Waddle\Converter::convertSecondsToHumanReadable($totalDuration); # e.g. 00:04:15
```

Running the Unit Tests
-----

### Setup vendor 

    $ cd Waddle
    $ composer install --dev

### Run the tests

    $ cd Waddle
    $ phpunit

