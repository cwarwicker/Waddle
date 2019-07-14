<?php

namespace Waddle;

use Exception;

abstract class Parser
{
    abstract public function parse($file);

    /**
     * Check if file is available
     * @param string $pathname
     * @throws Exception
     */
    protected function checkForFile($pathname)
    {
        if (!is_file($pathname)) {
            throw new Exception("Could not load file: {$pathname}");
        }
    }

    /**
     * Calculate the distance in KM, between two lat/lon points
     * @param float $fromLat
     * @param float $toLat
     * @param float $fromLon
     * @param float $toLon
     * @param int $earthRadius
     * @return float
     */
    protected function calculateDistanceBetweenLatLon($fromLat, $toLat, $fromLon, $toLon, $earthRadius = 6373)
    {
        $latDelta = deg2rad($toLat - $fromLat);
        $lonDelta = deg2rad($toLon - $fromLon);

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2),2) + cos(deg2rad($fromLat)) * cos(deg2rad($toLat)) * pow(sin($lonDelta / 2), 2)));

        $distance = $angle * $earthRadius;

        return Converter::convertKilometresToMetres($distance);
    }
}
