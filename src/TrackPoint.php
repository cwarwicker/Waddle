<?php

namespace Waddle;

use DateTime;
use DateTimeZone;

class TrackPoint
{
    /** @var int Timestamp of the time this point was recorded (generally every second) */
    protected $time;
    /** @var array Array [lat => float, long => float] */
    protected $position = [];
    /** @var float Altitude in metres */
    protected $altitude;
    /** @var float Distance travelled so far in metres */
    protected $distance;

    // Extensions that may or may not be present depending on device
    /** @var float Metres per second */
    protected $speed;
    /** @var float Current heart rate */
    protected $heartRate;
    /** @var float Total calories burnt so far */
    protected $calories;
    /** @var int */
    protected $cadence;

    /**
     * Get the timestamp in a given format
     * @param string $format
     * @return string|int
     */
    public function getTime($format)
    {
        return ($this->time instanceof DateTime) ? $this->time->format($format) : $this->time;
    }

    /**
     * Get either the lat/long array or a specific value from it, if "lat" or "lon" is passed in
     * @param string $type
     * @return float|array
     */
    public function getPosition($type = null)
    {
        return (!is_null($type) && array_key_exists($type, $this->position)) ? $this->position[$type] : $this->position;
    }

    /**
     * Get the altitude
     * @return float
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * Get the distance so far
     * @return float
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Get the current speed at this point
     * @return float
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Get the current heart rate at this point
     * @return float
     */
    public function getHeartRate()
    {
        return $this->heartRate;
    }
    
    /**
     * Get the current cadence rate at this point
     * @return int
     */
    public function getCadence()
    {
        return $this->cadence;
    }

    /**
     * Get the number of calories burnt so far
     * @return float
     */
    public function getCalories()
    {
        return $this->calories;
    }

    /**
     * Set the timestamp of this point
     * @param DateTime $time
     * @return $this
     */
    public function setTime(DateTime $time)
    {
        $time->setTimezone(new DateTimeZone(date_default_timezone_get()));
        $this->time = $time;
        return $this;
    }

    /**
     * Set the position array
     * @param array $val
     * @return $this
     */
    public function setPosition(array $val)
    {
        $this->position = $val;
        return $this;
    }

    /**
     * Set the altitude
     * @param float $val
     * @return $this
     */
    public function setAltitude($val)
    {
        $this->altitude = $val;
        return $this;
    }

    /**
     * Set the distance
     * @param float $val
     * @return $this
     */
    public function setDistance($val)
    {
        $this->distance = $val;
        return $this;
    }

    /**
     * Set the speed
     * @param float $val
     * @return $this
     */
    public function setSpeed($val)
    {
        $this->speed = $val;
        return $this;
    }

    /**
     * Set the heart rate
     * @param float $val
     * @return $this
     */
    public function setHeartRate($val)
    {
        $this->heartRate = $val;
        return $this;
    }
   
    /**
     * Set the cadence rate
     * @param int $val
     * @return $this
     */
    public function setCadence($val)
    {
        $this->cadence = $val;
        return $this;
    }

    /**
     * Set the calories burnt so far
     * @param float $val
     * @return $this
     */
    public function setCalories($val)
    {
        $this->calories = $val;
        return $this;
    }
}
