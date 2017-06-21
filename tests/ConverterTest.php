<?php

namespace Waddle;

class ConverterTest extends \PHPUnit\Framework\TestCase
{
        
    public function testConvertMetresPerSecondToMilesPerHour(){
        $this->assertEquals(2.23694, \Waddle\Converter::convertMetresPerSecondToMilesPerHour(1));
    }
    
    public function testConvertMetresPerSecondToKilometresPerHour(){
        $this->assertEquals(3.6, \Waddle\Converter::convertMetresPerSecondToKilometresPerHour(1));
    }
    
    public function testConvertMetresToKilometres(){
        $this->assertEquals(1, \Waddle\Converter::convertMetresToKilometres(1000));
    }
    
    public function testConvertMetresToMiles(){
        $this->assertEquals(1, \Waddle\Converter::convertMetresToMiles(1609.34));
    }
    
    public function testConvertMetresToFeet(){
        $this->assertEquals(3.28084, \Waddle\Converter::convertMetresToFeet(1));
    }
    
    public function testConvertMilesToMetres(){
        $this->assertEquals(1609.34, \Waddle\Converter::convertMilesToMetres(1));
    }
    
    public function testConvertKilometresToMetres(){
        $this->assertEquals(1000, \Waddle\Converter::convertKilometresToMetres(1));
    }
    
    public function testHumanReadableSeconds(){
        $this->assertEquals('05:04:54', \Waddle\Converter::convertSecondsToHumanReadable(18294));
    }
    
    
}