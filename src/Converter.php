<?php

namespace Waddle;

abstract class Converter
{
    
    public static function convertMetresPerSecondToMilesPerHour($val){
        return ($val * 2.23694);
    }
    
    public static function convertMetresPerSecondToKilometresPerHour($val){
        return ($val * 3.6);
    }
    
    public static function convertMetresToKilometres($val){
        return ($val / 1000);
    }
    
    public static function convertMetresToMiles($val){
        return ($val / 1609.34);
    }
    
    public static function convertMetresToFeet($val){
        return ($val * 3.28084);
    }
    
    public static function convertMilesToMetres($val){
        return ($val * 1609.34);
    }
    
    public static function convertKilometresToMetres($val){
        return ($val * 1000);
    }
    
    public static function convertSecondsToHumanReadable($val){
        return sprintf( "%02d:%02d:%02d", ($val / 3600), ($val / 60 % 60), ($val % 60) );        
    }
    
    
    
}