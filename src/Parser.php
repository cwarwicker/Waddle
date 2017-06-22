<?php

namespace Waddle;

abstract class Parser
{
    
    abstract public function parse($file);
    
    /**
     * Calculate the distance in KM, between two lat/lon points
     * @param type $fromLat
     * @param type $toLat
     * @param type $fromLon
     * @param type $toLon
     * @param type $earthRadius
     * @return type
     */
    protected function calculateDistanceBetweenLatLon($fromLat, $toLat, $fromLon, $toLon, $earthRadius = 6373)
    {
                
        $latDelta = deg2rad($toLat - $fromLat);
        $lonDelta = deg2rad($toLon - $fromLon);
        
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos(deg2rad($fromLat)) * cos(deg2rad($toLat)) * pow(sin($lonDelta / 2), 2)));

        $distance = $angle * $earthRadius;

        return \Waddle\Converter::convertKilometresToMetres($distance);
        
    }
    
}
