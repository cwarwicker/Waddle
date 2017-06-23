<?php

namespace Waddle;

class TrackPoint
{
    
    protected $time; // Timestamp of the time this point was recorded (generally every second)
    protected $position = array(); // Array of lat/lon
    protected $altitude; // Altitude in metres 
    protected $distance; // Distance travelled so far in metres
    
    // Extensions that may or may not be present depending on device
    protected $speed; // Metres per second
    protected $heartRate; // Current hearthate
    protected $calories; // Total calories burnt so far
    
    /**
     * Get the timestamp in a given format
     * @param type $format
     * @return type
     */
    public function getTime($format){
        return ($this->time instanceof \DateTime) ? $this->time->format($format) : $this->time;
    }
    
    /**
     * Get either the lat/long array or a specific value from it, if "lat" or "long" is passed in
     * @param type $type
     * @return type
     */
    public function getPosition($type = null){
        return ( !is_null($type) && array_key_exists($type, $this->position) ) ? $this->position[$type] : $this->position;
    }
    
    /**
     * Get the altitude
     * @return type
     */
    public function getAltitude(){
        return $this->altitude;
    }
    
    /**
     * Get the distance so far
     * @return type
     */
    public function getDistance(){
        return $this->distance;
    }
    
    /**
     * Get the current speed at this point
     * @return type
     */
    public function getSpeed(){
        return $this->speed;
    }
    
    /**
     * Get the current heart rate at this point
     * @return type
     */
    public function getHeartRate(){
        return $this->heartRate;
    }
    
    

    /**
     * Get the number of calories burnt so far
     * @return type
     */
    public function getCalories(){
        return $this->calories;
    }

    /**
     * Set the timestamp of this point
     * @param \DateTime $time
     * @return $this
     */
    public function setTime(\DateTime $time){
        $time->setTimezone( new \DateTimeZone( date_default_timezone_get() ) );
        $this->time = $time;
        return $this;
    }
    
    /**
     * Set the position array
     * @param array $val
     * @return $this
     */
    public function setPosition(array $val){
        $this->position = $val;
        return $this;
    }
    
    /**
     * Set the altitude
     * @param type $val
     * @return $this
     */
    public function setAltitude($val){
        $this->altitude = $val;
        return $this;
    }
    
    /**
     * Set the distance
     * @param type $val
     * @return $this
     */
    public function setDistance($val){
        $this->distance = $val;
        return $this;
    }
    
    /**
     * Set the speed
     * @param type $val
     * @return $this
     */
    public function setSpeed($val){
        $this->speed = $val;
        return $this;
    }
    
    /**
     * Set the heart rate
     * @param type $val
     * @return $this
     */
    public function setHeartRate($val){
        $this->heartRate = $val;
        return $this;
    }
   
    
    /**
     * Set the calories burnt so far
     * @param type $val
     * @return $this
     */
    public function setCalories($val){
        $this->calories = $val;
        return $this;
    }
    
}
