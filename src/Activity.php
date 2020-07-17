<?php

namespace Waddle;

use DateTime;
use DateTimeZone;

class Activity
{
    /** @var string */
    protected $type;
    /** @var DateTime */
    protected $startTime;
    /** @var Lap[] */
    protected $laps = [];

    /**
     * Get the type of activity, e.g. "Running" or "Cycling"
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the activity type
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the start time in a particular format
     * @param string $format
     * @return string
     */
    public function getStartTime($format)
    {
        return ($this->startTime instanceof DateTime) ? $this->startTime->format($format) : $this->startTime;
    }

    /**
     * Set the start time
     * @param DateTime $time
     * @return $this
     */
    public function setStartTime(DateTime $time)
    {
        $time->setTimezone(new DateTimeZone(date_default_timezone_get()));
        $this->startTime = $time;
        return $this;
    }

    /**
     * Get all laps on the activity
     * @return Lap[]
     */
    public function getLaps()
    {
        return $this->laps;
    }

    /**
     * Get a specific lap number
     * @param int $num
     * @return Lap|bool
     */
    public function getLap($num)
    {
        return (array_key_exists($num, $this->laps)) ? $this->laps[$num] : false;
    }

    /**
     * Add a lap to the activity
     * @param Lap $lap
     */
    public function addLap(Lap $lap)
    {
        $this->laps[] = $lap;
    }

    /**
     * Set the array of laps on the activity
     * @param Lap[] $laps
     * @return $this
     */
    public function setLaps(array $laps)
    {
        $this->laps = $laps;
        return $this;
    }

    /**
     * Get the total distance covered in the whole activity
     * @return float
     */
    public function getTotalDistance()
    {
        $total = 0;

        foreach ($this->laps as $lap) {
            $total += $lap->getTotalDistance();
        }

        return $total;
    }

    /**
     * Get the total duration of the whole activity
     * @return int
     */
    public function getTotalDuration()
    {
        $total = 0;

        foreach ($this->laps as $lap) {
            $total += $lap->getTotalTime();
        }

        return $total;
    }

    /**
     * Get the average pace per mile
     * @return string
     */
    public function getAveragePacePerMile()
    {
        return Converter::convertSecondsToHumanReadable(($this->getTotalDuration() / Converter::convertMetresToMiles($this->getTotalDistance())));
    }

    /**
     * Get the average pace per kilometre
     * @return string
     */
    public function getAveragePacePerKilometre()
    {
        return Converter::convertSecondsToHumanReadable(($this->getTotalDuration() / Converter::convertMetresToKilometres($this->getTotalDistance())));
    }

    /**
     * Get the average speed in mph
     * @return float
     */
    public function getAverageSpeedInMPH()
    {
        return Converter::convertMetresToMiles($this->getTotalDistance()) / ($this->getTotalDuration() / 3600);
    }

    /**
     * Get the average speed in kph
     * @return float
     */
    public function getAverageSpeedInKPH()
    {
        return (Converter::convertMetresToKilometres($this->getTotalDistance()) / ($this->getTotalDuration() / 3600));
    }

    /**
     * Get total calories burned across whole activity
     * @return float
     */
    public function getTotalCalories()
    {
        $total = 0;

        foreach ($this->laps as $lap) {
            $total += $lap->getTotalCalories();
        }

        return $total;
    }

    /**
     * Get the max speed in mph
     * @return float
     */
    public function getMaxSpeedInMPH()
    {
        $max = 0;

        foreach ($this->laps as $lap) {
            if ($lap->getMaxSpeed() > $max) {
                $max = $lap->getMaxSpeed();
            }
        }

        return Converter::convertMetresPerSecondToMilesPerHour($max);
    }

    /**
     * Get the max speed in kph
     * @return float
     */
    public function getMaxSpeedInKPH()
    {
        $max = 0;

        foreach ($this->laps as $lap) {
            if ($lap->getMaxSpeed() > $max) {
                $max = $lap->getMaxSpeed();
            }
        }

        return Converter::convertMetresPerSecondToKilometresPerHour($max);
    }

    /**
     * Add up the total ascent and descent across the activity
     * In the future, might change this to look up lat/long points for more accuracy?
     * @return array ['ascent' => int
     */
    public function getTotalAscentDescent()
    {
        $result = [
            'ascent' => 0,
            'descent' => 0,
        ];

        // First lap
        $last = $this->getLap(0)->getTrackPoint(0)->getAltitude();

        // Loop through each lap and point and add it all up
        foreach ($this->laps as $lap) {
            foreach ($lap->getTrackPoints() as $point) {

                if ($point->getAltitude() > $last) {
                    $result['ascent'] += ($point->getAltitude() - $last);
                } elseif ($point->getAltitude() < $last) {
                    $result['descent'] += ($last - $point->getAltitude());
                }

                $last = $point->getAltitude();

            }
        }

        return $result;
    }

    /**
     * Gives some information about the geographical properties of this track like extremal points
     * @return array
     */
    public function getGeographicInformation()
    {
        $result = [
            'north' => PHP_INT_MIN,
            'east' => PHP_INT_MIN,
            'south' => PHP_INT_MAX,
            'west' => PHP_INT_MAX,
            'highest' => PHP_INT_MIN,
            'lowest' => PHP_INT_MAX,
            'center' => [
                'lat' => 0,
                'lng' => 0
            ]
        ];

        // Loop through each lap and point and add it all up
        foreach ($this->laps as $lap) {
            foreach ($lap->getTrackPoints() as $point) {
                $lat = $point->getPosition('lat');
                $long = $point->getPosition('lon');
                if (empty($lat) && empty($long)) {
                    continue;
                }
                $altitude = $point->getAltitude();

                $result['highest'] = max($altitude, $result['highest']);
                $result['lowest'] = min($altitude, $result['lowest']);

                $result['north'] = max($lat, $result['north']);
                $result['south'] = min($lat, $result['south']);
                $result['east'] = max($long, $result['east']);
                $result['west'] = min($long, $result['west']);
            }
        }
        
        $result['center']['lat'] = ($result['north'] + $result['south']) / 2;
        $result['center']['lng'] = ($result['east'] + $result['west']) / 2;

        return $result;
    }

    /**
     * Get an array of splits, in miles
     * @param string $type "k" - kilometers to meters or "m" - miles to meters
     * @return array
     */
    public function getSplits($type)
    {
        if ($type == 'k') {
            $distance = Converter::convertKilometresToMetres(1);
        } else {
            $distance = Converter::convertMilesToMetres(1);
        }

        $splits = [];
        $diff = 0;
        $point = null;
        $key = null;

        foreach ($this->laps as $lap) {
            foreach ($lap->getTrackPoints() as $key => $point) {
                if (($point->getDistance() - $diff) >= $distance) {
                    $splits[] = $key;
                    $diff = $point->getDistance();
                }
            }
        }

        // Get the last split, even if it's not a full mile
        if ($point && $point->getDistance() > $diff) {
            $splits[] = $key;
        }

        return $splits;
    }
}
