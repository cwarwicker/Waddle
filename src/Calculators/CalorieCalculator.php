<?php

namespace Waddle\Calculators;

class CalorieCalculator
{
    // Approx Metabolic Equivalent Task score, per Mph (Running)
    const MET_PER_MPH = (10 / 6);
    const MET_PER_KMPH = (10 / 9.65606);

    // If I add more activity types, their MET adjustment constants can go here
    const MET_TYPE_RUNNING = 1;

    /**
     * Calculate the MET from an average speed (mph)
     * @param float $avgSpeed
     * @param float $activity
     * @return float
     */
    public static function calculateMETFromMPH($avgSpeed, float $activity = self::MET_TYPE_RUNNING)
    {
        return round((self::MET_PER_MPH * $avgSpeed) * $activity, 1);
    }

    /**
     * Calculate the MET from an average speed (kmph)
     * @param float $avgSpeed
     * @param float $activity
     * @return float
     */
    public static function calculateMETFromKMPH($avgSpeed, float $activity = self::MET_TYPE_RUNNING)
    {
        return round((self::MET_PER_KMPH * $avgSpeed) * $activity, 1);
    }

    /**
     * Calculate calories burned, from a MET score, weight and activity duration
     * @param float $mets
     * @param float $weightInKG
     * @param float $timeInHours
     * @return float
     */
    public static function calculateCaloriesBurned(float $mets, float $weightInKG, float $timeInHours)
    {
        return floor($mets * $weightInKG * $timeInHours);
    }
}