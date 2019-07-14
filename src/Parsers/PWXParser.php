<?php

namespace Waddle\Parsers;

use DateTime;
use Exception;
use SimpleXMLElement;
use Waddle\Activity;
use Waddle\Lap;
use Waddle\Parser;
use Waddle\TrackPoint;

class PWXParser extends Parser
{
    /**
     * Parse the PWX file
     * @param string $pathname
     * @return Activity
     * @throws Exception
     */
    public function parse($pathname)
    {
        // Check that the file exists
        $this->checkForFile($pathname);

        // Load the XML in the TCX file
        $data = simplexml_load_file($pathname);
        if (!isset($data->workout)) {
            throw new Exception("Unable to find valid activity in file contents");
        }

        $activityNode = $data->workout;

        // Create a new activity instance
        $activity = new Activity();
        $activity->setStartTime(new DateTime((string)$activityNode->time));
        $activity->setType((string)$activityNode->sportType[0]);

        // We will treat all track points as being lap 1, even if they have a different lap number, for easier parsing
        $lap = new Lap();
        $trackPoint = null;

        // Loop through the track points
        foreach ($activityNode->sample as $trackPointNode) {
            $trackPoint = $lap->addTrackPoint($this->parseTrackPoint($trackPointNode));
        }

        // Totals
        // Total Duration
        if (isset($activityNode->summarydata->duration)) {
            $lap->setTotalTime((float)$activityNode->summarydata->duration);
        }

        // Max Speed
        if (isset($activityNode->summarydata->spd['max'])) {
            $lap->setMaxSpeed((float)$activityNode->summarydata->spd['max']);
        }

        // Distance, we have get from the last track point
        $lap->setTotalDistance($trackPoint->getDistance());

        // Doesn't store Calories, so can't do those

        // Add lap to activity
        $activity->addLap($lap);

        // Finally return the activity object
        return $activity;
    }

    /**
     * Parse the XML of a track point
     * @param SimpleXMLElement $trackPointNode
     * @return TrackPoint
     * @throws Exception
     */
    protected function parseTrackPoint($trackPointNode)
    {

        $point = new TrackPoint();

        // Time
        if (isset($trackPointNode->time)) {
            $point->setTime(new DateTime((string)$trackPointNode->time));
        }

        // Latitude/Longitude
        if (isset($trackPointNode->lat) && isset($trackPointNode->lon)) {
            $point->setPosition(['lat' => (float)$trackPointNode->lat, 'lon' => (float)$trackPointNode->lon]);
        }

        // Elevation
        if (isset($trackPointNode->alt)) {
            $point->setAltitude((float)$trackPointNode->alt);
        }

        // Distance
        if (isset($trackPointNode->dist)) {
            $point->setDistance((float)$trackPointNode->dist);
        }

        // Speed
        if (isset($trackPointNode->spd)) {
            $point->setSpeed((float)$trackPointNode->spd);
        }

        return $point;
    }
}