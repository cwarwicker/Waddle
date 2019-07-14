<?php

namespace Waddle;

abstract class Converter
{
    /**
     * Convert metres per second, to miles per hour
     * @param float $val
     * @return float
     */
    public static function convertMetresPerSecondToMilesPerHour($val)
    {
        return ($val * 2.23694);
    }

    /**
     * Convert metres per second, to kilometres per hour
     * @param float $val
     * @return float
     */
    public static function convertMetresPerSecondToKilometresPerHour($val)
    {
        return ($val * 3.6);
    }

    /**
     * Convert metres to kilometres
     * @param float $val
     * @return float
     */
    public static function convertMetresToKilometres($val)
    {
        return ($val / 1000);
    }

    /**
     * Convert metres to miles
     * @param float $val
     * @return float
     */
    public static function convertMetresToMiles($val)
    {
        return ($val / 1609.34);
    }

    /**
     * Convert metres to feet
     * @param float $val
     * @return float
     */
    public static function convertMetresToFeet($val)
    {
        return ($val * 3.28084);
    }

    /**
     * Convert miles to metres
     * @param float $val
     * @return float
     */
    public static function convertMilesToMetres($val)
    {
        return ($val * 1609.34);
    }

    /**
     * Convert kilometres to metres
     * @param float $val
     * @return float
     */
    public static function convertKilometresToMetres($val)
    {
        return ($val * 1000);
    }

    /**
     * Convert hours, minutes, seconds, to an hour decimal
     * e.g. 00 30 00 = 0.5 hours
     * @param int $h
     * @param int $m
     * @param int $s
     * @return float
     */
    public static function convertHoursMinutesSecondsToDecimal($h, $m, $s)
    {
        $total = 0;
        $total += $h;
        $total += ((1 / 60) * $m);
        $total += ((1 / 3600) * $s);

        return $total;
    }

    /**
     * Convert seconds to a human readable hh:mm:ss
     * @param float $val
     * @return string
     */
    public static function convertSecondsToHumanReadable($val)
    {
        return sprintf("%02d:%02d:%02d", ($val / 3600), ($val / 60 % 60), ($val % 60));
    }

    /**
     * Convert the hh:mm:ss human readable time, back into seconds
     * @param string $val
     * @return float
     */
    public static function convertHumanReadableToSeconds($val)
    {
        $explode = explode(":", $val);
        return ($explode[0] * 3600) + ($explode[1] * 60) + $explode[2];
    }
}