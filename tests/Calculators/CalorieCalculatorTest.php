<?php

namespace Waddle;

use Waddle\Calculators\CalorieCalculator;

class CalorieCalculatorTest extends \PHPUnit\Framework\TestCase
{
        
    public function testCalculateMETFromMPH(){
        $this->assertEquals(16.7, CalorieCalculator::calculateMETFromMPH(10));
    }
    
    public function testCalculateMETFromKMPH(){
        $this->assertEquals(10.4, CalorieCalculator::calculateMETFromKMPH(10));
    }
    
    public function testCalculateCaloriesBurned(){
        $this->assertEquals(297, CalorieCalculator::calculateCaloriesBurned(10, 75, 0.396));
    }
    
    
}