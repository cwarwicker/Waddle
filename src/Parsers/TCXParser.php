<?php

namespace Waddle\Parsers;

use Waddle\Parser;
use Waddle\Activity;
use Waddle\Lap;
use Waddle\TrackPoint;

class TCXParser extends Parser
{
    
    /**
     * Parse the TCX file
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
        
        // Create a new activity instance
        $activity = new Activity();
        
        // Load the XML in the TCX file
        $data = simplexml_load_file($file);
        if (!isset($data->Activities->Activity)){
            throw new \Exception("Unable to find valid activity in file contents");
        }
        
        // Parse the first activity
        $activityNode = $data->Activities->Activity[0];
        $activity->setStartTime( new \DateTime( (string)$activityNode->Id ) );
        
        // Now parse the laps
        // There should only be 1 lap, but they are stored in an array just in case this ever changes
        foreach($activityNode->Lap as $lapNode)
        {
            $activity->addLap( $this->parseLap($lapNode) );
        }
                
        // Finally return the activity object
        return $activity;
                
        
    }
    
    /**
     * Parse the lap XML
     * @param type $lapNode
     * @return \Waddle\Lap
     */
    protected function parseLap($lapNode)
    {
        
        $lap = new Lap();
        $lap->setTotalTime( (float)$lapNode->TotalTimeSeconds );
        $lap->setTotalDistance( (float)$lapNode->DistanceMeters );
        $lap->setMaxSpeed( (float)$lapNode->MaximumSpeed );
        $lap->setTotalCalories( (float)$lapNode->Calories );
                
        // Loop through the track points
        foreach( $lapNode->Track->Trackpoint as $trackPointNode )
        {
            $lap->addTrackPoint( $this->parseTrackPoint($trackPointNode) );
        }
                        
        return $lap;

    }
    
    /**
     * Parse the XML of a track point
     * @param type $trackPointNode
     * @return \Waddle\TrackPoint
     */
    protected function parseTrackPoint($trackPointNode)
    {
        
        $point = new TrackPoint();
        $point->setTime( new \DateTime( (string)$trackPointNode->Time ) );
        $point->setPosition( array('lat' => (float)$trackPointNode->Position->LatitudeDegrees, 'lon' => (float)$trackPointNode->Position->LongitudeDegrees) );
        $point->setAltitude( (float)$trackPointNode->AltitudeMeters );
        $point->setDistance( (float)$trackPointNode->DistanceMeters );
                
        if (isset($trackPointNode->Extensions->children('x', true)->TPX->children()->Speed))
        {
            $point->setSpeed( (float)$trackPointNode->Extensions->children('x', true)->TPX->children()->Speed );
        }
        
        return $point;
        
    }
    
    
}