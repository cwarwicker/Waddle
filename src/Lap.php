<?php

namespace Waddle;

class Lap
{
    
    protected $totalTime; // Seconds
    protected $totalDistance; // Metres
    protected $maxSpeed; // Metres per second
    protected $totalCalories;
    protected $trackPoints = array();
    
    public function getTotalTime(){
        return $this->totalTime;
    }
    
    public function getTotalDistance(){
        return $this->totalDistance;
    }
    
    public function getMaxSpeed(){
        return $this->maxSpeed;
    }
    
    public function getTotalCalories(){
        return $this->totalCalories;
    }
    
    public function getTrackPoints(){
        return $this->trackPoints;
    }
    
    public function getTrackPoint($num){
        return (array_key_exists($num, $this->trackPoints)) ? $this->trackPoints[$num] : false;
    }
    
    public function setTotalTime($val){
        $this->totalTime = $val;
        return $this;
    }
    
    public function setTotalDistance($val){
        $this->totalDistance = $val;
        return $this;
    }
    
    public function setMaxSpeed($val){
        $this->maxSpeed = $val;
        return $this;
    }
    
    public function setTotalCalories($val){
        $this->totalCalories = $val;
        return $this;
    }
    
    public function addTrackPoint(TrackPoint $point){
        $this->trackPoints[] = $point;        
    }
    
    
}