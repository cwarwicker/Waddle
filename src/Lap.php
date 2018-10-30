<?php

namespace Waddle;

class Lap
{
    
    protected $totalTime = null;     // Seconds
    protected $totalDistance = null; // Metres
    protected $maxSpeed = null;      // Metres per second
    protected $totalCalories = null;

    protected $avgHeartRate = null;
    protected $maxHeartRate = null;
    protected $cadence = null;

    protected $trackPoints = array();

    /**
     * Get the total lap time
     * @return type
     */
    public function getTotalTime(){
        return $this->totalTime;
    }
    
    /**
     * Get the total lap distance
     * @return type
     */
    public function getTotalDistance(){
        return $this->totalDistance;
    }
    
    /**
     * Get the max speed achieved during the lap
     * @return type
     */
    public function getMaxSpeed(){
        return $this->maxSpeed;
    }
    
    /**
     * Get the calories burnt during the lap
     * @return type
     */
    public function getTotalCalories(){
        return $this->totalCalories;
    }
    
    /**
     * Get the array of track points
     * @return type
     */
    public function getTrackPoints(){
        return $this->trackPoints;
    }
    
    /**
     * Get a specific track point, by its number
     * @param type $num
     * @return type
     */
    public function getTrackPoint($num){
        return (array_key_exists($num, $this->trackPoints)) ? $this->trackPoints[$num] : false;
    }
    
    /**
     * Get the average heart rate achieved during the lap
     * @return type
     */
    public function getAvgHeartRate(){
        return $this->avgHeartRate;
    }

    /**
     * Get the maximum heart rate achieved during the lap
     * @return type
     */
    public function getMaxHeartRate(){
        return $this->maxHeartRate;
    }

    /**
     * Get the cadence achieved during the lap
     * @return type
     */
    public function getCadence(){
        return $this->cadence;
    }

    /**
     * Set the total lap time (seconds)
     * @param type $val
     * @return $this
     */
    public function setTotalTime($val){
        $this->totalTime = $val;
        return $this;
    }
    
    /**
     * Set the total lap distance (metres)
     * @param type $val
     * @return $this
     */
    public function setTotalDistance($val){
        $this->totalDistance = $val;
        return $this;
    }
    
    /**
     * Set the max lap speed (metres per second)
     * @param type $val
     * @return $this
     */
    public function setMaxSpeed($val){
        $this->maxSpeed = $val;
        return $this;
    }
    
    /**
     * Set the total calories burnt
     * @param type $val
     * @return $this
     */
    public function setTotalCalories($val){
        $this->totalCalories = $val;
        return $this;
    }
    
    /**
     * Add a track point to the lap
     * @param \Waddle\TrackPoint $point
     * @return \Waddle\TrackPoint
     */
    public function addTrackPoint(TrackPoint $point){
        $this->trackPoints[] = $point;     
        return $point;
    }
    
    /**
     * Set the average heart rate in lap
     * @param type $val
     * @return $this
     */
    public function setAvgHeartRate($val){
        $this->avgHeartRate = $val;
        return $this;
    }

    /**
     * Set the maximum heart rate in lap
     * @param type $val
     * @return $this
     */
    public function setMaxHeartRate($val){
        $this->maxHeartRate = $val;
        return $this;
    }

    /**
     * Set the cadence in lap
     * @param type $val
     * @return $this
     */
    public function setCadence($val){
        $this->cadence = $val;
        return $this;
    }

}
