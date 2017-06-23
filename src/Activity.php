<?php

namespace Waddle;

class Activity
{
    
    protected $startTime;
    protected $laps = array();
    
    /**
     * Get the start time in a particular format
     * @param type $format
     * @return type
     */
    public function getStartTime($format){
        return ($this->startTime instanceof \DateTime) ? $this->startTime->format($format) : $this->startTime;
    }
    
    /**
     * Set the start time
     * @param \DateTime $time
     * @return $this
     */
    public function setStartTime(\DateTime $time){
        $time->setTimezone( new \DateTimeZone( date_default_timezone_get() ) );
        $this->startTime = $time;
        return $this;
    }
    
    /**
     * Get all laps on the activity
     * @return type
     */
    public function getLaps(){
        return $this->laps;
    }
    
    /**
     * Get a specific lap number
     * @param type $num
     * @return type
     */
    public function getLap($num){
        return (array_key_exists($num, $this->laps)) ? $this->laps[$num] : false;
    }
    
    /**
     * Add a lap to the activity
     * @param \Waddle\Lap $lap
     */
    public function addLap( Lap $lap ){
        $this->laps[] = $lap;
    }
    
    /**
     * Set the array of laps on the activity
     * @param array $laps
     * @return $this
     */
    public function setLaps(array $laps){
        $this->laps = $laps;
        return $this;
    }
    
    /**
     * Get the total distance covered in the whole activity
     * @return type
     */
    public function getTotalDistance(){
        
        $total = 0;
        
        foreach($this->laps as $lap)
        {
            $total += $lap->getTotalDistance();
        }
        
        return $total;
        
    }
    
    /**
     * Get the total duration of the whole activity
     * @return type
     */
    public function getTotalDuration(){
        
        $total = 0;
        
        foreach($this->laps as $lap)
        {
            $total += $lap->getTotalTime();
        }
        
        return $total;
        
    }
    
    /**
     * Get the average pace per mile
     * @return type
     */
    public function getAveragePacePerMile(){
        return Converter::convertSecondsToHumanReadable( ($this->getTotalDuration() / Converter::convertMetresToMiles($this->getTotalDistance())) );
    }
    
    /**
     * Get the average pace per kilometre
     * @return type
     */
    public function getAveragePacePerKilometre(){
        return Converter::convertSecondsToHumanReadable( ($this->getTotalDuration() / Converter::convertMetresToKilometres($this->getTotalDistance())) );
    }
    
    /**
     * Get the average speed in mph
     * @return type
     */
    public function getAverageSpeedInMPH(){
        return ( Converter::convertMetresToMiles($this->getTotalDistance()) / ($this->getTotalDuration() / 3600) );
    }
    
    /**
     * Get the average speed in kph
     * @return type
     */
    public function getAverageSpeedInKPH(){
        return ( Converter::convertMetresToKilometres($this->getTotalDistance()) / ($this->getTotalDuration() / 3600) );
    }
    
    /**
     * Get total calories burned across whole activity
     * @return type
     */
    public function getTotalCalories(){
        
        $total = 0;
        
        foreach($this->laps as $lap)
        {
            $total += $lap->getTotalCalories();
        }
        
        return $total;
        
    }
    
    /**
     * Get the max speed in mph
     * @return type
     */
    public function getMaxSpeedInMPH(){
        
        $max = 0;
        
        foreach($this->laps as $lap)
        {
            if ($lap->getMaxSpeed() > $max)
            {
                $max = $lap->getMaxSpeed();
            }
        }
        
        return Converter::convertMetresPerSecondToMilesPerHour($max);
        
    }
    
    /**
     * Get the max speed in kph
     * @return type
     */
    public function getMaxSpeedInKPH(){
        
        $max = 0;
        
        foreach($this->laps as $lap)
        {
            if ($lap->getMaxSpeed() > $max)
            {
                $max = $lap->getMaxSpeed();
            }
        }
        
        return Converter::convertMetresPerSecondToKilometresPerHour($max);
        
    }
    
    /**
     * Add up the total ascent and descent across the activity
     * In the future, might change this to look up lat/long points for more accuracy?
     * @return type
     */
    public function getTotalAscentDescent(){
        
        $result = array(
            'ascent' => 0,
            'descent' => 0
        );
        
        // First lap
        $last = $this->getLap(0)->getTrackPoint(0)->getAltitude();        
        
        // Loop through each lap and point and add it all up
        foreach($this->laps as $lap)
        {
            foreach($lap->getTrackPoints() as $point)
            {
                                
                if ($point->getAltitude() > $last)
                {
                    $result['ascent'] += ($point->getAltitude() - $last);
                }
                elseif ($point->getAltitude() < $last)
                {
                    $result['descent'] += ($last - $point->getAltitude());
                }
                
                $last = $point->getAltitude();
                
            }
        }        
       
        return $result;
        
    }
    
    /**
     * Get an array of splits, in miles
     * @return type
     */
    public function getSplits($type){
        
        if ($type == 'k'){
            $distance = Converter::convertKilometresToMetres(1);
        } else {
            $distance = Converter::convertMilesToMetres(1);
        }
        $splits = array();
        $diff = 0;
        
        foreach($this->laps as $lap)
        {
            
            foreach($lap->getTrackPoints() as $key => $point)
            {
                
                if ( ($point->getDistance() - $diff) >= $distance)
                {
                    $splits[] = $key;
                    $diff = $point->getDistance();
                }
                
            }
            
        }
        
        // Get the last split, even if it's not a full mile
        if ($point->getDistance() > $diff)
        {
            $splits[] = $key;
        }
        
        return $splits;
        
    }
    
    
}
