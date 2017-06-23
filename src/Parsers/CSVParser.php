<?php

namespace Waddle\Parsers;

use Waddle\Parser;
use Waddle\Activity;
use Waddle\Lap;
use Waddle\TrackPoint;

class CSVParser extends Parser
{
 
    private $headers = array();
    
    /**
     * Parse the CSV file
     * @param type $file
     * @return Activity
     * @throws \Exception
     */
    public function parse($file)
    {
        
        // Check that the file exists
        if (!is_file($file)){
            throw new \Exception("Could not load file: {$file}");
        }
        
        // Load the CSV data
        $handle = fopen($file, 'r');
        if (!$handle){
            throw new \Exception("Unable to open file: {$file}");
        }
        
        // Get the headers from the first row
        $this->headers = fgetcsv($handle);
                
        // Create a new activity instance
        $activity = new Activity();
        
        // CSV does not contain a start time, so cannot set that
        
        // We will treat all track points as being lap 1, even if they have a different lap number, for easier parsing
        $lap = new \Waddle\Lap();
        
        $maxSpeed = 0;
        
        // Now loop through the track points
        while ($row = fgetcsv($handle))
        {
            if ($row[$this->getHeaderKey('lapNumber')] > 0)
            {
                $trackPoint = $lap->addTrackPoint( $this->parseTrackPoint($row) );
                if ($trackPoint->getSpeed() > $maxSpeed)
                {
                    $maxSpeed = $trackPoint->getSpeed();
                }
                $lastRow = $row;
            }
        }
                        
        // Now do the totals calculations for the lap
        if ($this->getHeaderKey('time') !== false){
            $lap->setTotalTime( (float)$lastRow[$this->getHeaderKey('time')] );
        }
        
        if ($this->getHeaderKey('distance') !== false){
            $lap->setTotalDistance( (float)$lastRow[$this->getHeaderKey('distance')] );
        }
        
        if ($this->getHeaderKey('calories') !== false){
            $lap->setTotalCalories( (float)$lastRow[$this->getHeaderKey('calories')] );
        }
        
        $lap->setMaxSpeed($maxSpeed);
        
        $activity->addLap($lap);
                        
        // Finally return the activity object
        return $activity;
                
        
    }
    
    
    
    /**
     * Parse the track point
     * @param type $trackPointNode
     * @return \Waddle\TrackPoint
     */
    protected function parseTrackPoint($trackPointRow)
    {
        
        $point = new TrackPoint();
        
        // CSV format does not store the time, so can't do that
        
        if ($this->getHeaderKey('lat') !== false && $this->getHeaderKey('lon') !== false){
            $point->setPosition( array('lat' => (float)$trackPointRow[$this->getHeaderKey('lat')], 'lon' => (float)$trackPointRow[$this->getHeaderKey('lon')]) );
        }
        
        if ($this->getHeaderKey('elevation') !== false){
            $point->setAltitude( (float)$trackPointRow[$this->getHeaderKey('elevation')] );
        }
        
        if ($this->getHeaderKey('distance') !== false){
            $point->setDistance( (float)$trackPointRow[$this->getHeaderKey('distance')] );
        }
        
        if ($this->getHeaderKey('speed') !== false){
            $point->setSpeed( (float)$trackPointRow[$this->getHeaderKey('speed')] );
        }
        
        if ($this->getHeaderKey('heartRate') !== false){
            $point->setHeartRate( (float)$trackPointRow[$this->getHeaderKey('speed')] );
        }
                
        if ($this->getHeaderKey('calories') !== false){
            $point->setCalories( (float)$trackPointRow[$this->getHeaderKey('calories')] );
        }
        
        return $point;
        
    }
    
    /**
     * Get the key of a specific header
     * @param string $header
     * @param array $headers
     * @return type
     */
    private function getHeaderKey(string $header){
        return array_search($header, $this->headers);        
    }
    
    
}