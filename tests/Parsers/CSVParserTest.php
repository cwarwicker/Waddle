<?php

namespace Waddle\Parsers;

class CSVParserTest extends \PHPUnit\Framework\TestCase
{
    
    public $parser, $activity;
    
    public function setUp(): void {
        $this->parser = new \Waddle\Parsers\CSVParser();
        $this->activity = $this->parser->parse( __DIR__ . '/../run.csv' );
    }
    
    public function testActivityStartTime(){
        $this->assertEquals(null, $this->activity->getStartTime('Y-m-d H:i:s'));
    }
    
    public function testActivityLaps(){
        $this->assertEquals(1, count($this->activity->getLaps()));
    }
    
    public function testActivityTotalDistance(){
        $this->assertEquals(4824.94, $this->activity->getTotalDistance()); # This calculates a different value to the value given by TCX
    }
    
    public function testActivityTotalDuration(){
        $this->assertEquals(1423, $this->activity->getTotalDuration()); # This calculates a different value to the value given by TCX
    }
    
    public function testActivityAveragePacePerMile(){
        $this->assertEquals('00:07:54', $this->activity->getAveragePacePerMile()); # This calculates a different value to the value given by TCX
    }
    
    public function testActivityAveragePacePerKilometre(){
        $this->assertEquals('00:04:54', $this->activity->getAveragePacePerKilometre());
    }
    
    public function testActivityAverageSpeedMPH(){
        $this->assertEquals(7.58, round($this->activity->getAverageSpeedInMPH(), 2)); # This calculates a different value to the value given by TCX
    }
    
    public function testActivityAverageSpeedKPH(){
        $this->assertEquals(12.21, round($this->activity->getAverageSpeedInKPH(), 2)); # This calculates a different value to the value given by TCX
    }
    
    public function testActivityTotalCalories(){
        $this->assertEquals(373, $this->activity->getTotalCalories()); # Not able to calculate this, as GPX does not support it
    }
    
    public function testActivityMaxSpeedMPH(){
        $this->assertEquals(10.45, round($this->activity->getMaxSpeedInMPH(), 2)); # This calculates a different value to the value given by TCX
    }
    
    public function testActivityMaxSpeedKPH(){
        $this->assertEquals(16.81, round($this->activity->getMaxSpeedInKPH(), 2)); # This calculates a different value to the value given by TCX
    }
    
    public function testActivityTotalAscent(){
        $result = $this->activity->getTotalAscentDescent();
        $this->assertEquals(50.9, $result['ascent']);
    }
    
    public function testActivityTotalDescent(){
        $result = $this->activity->getTotalAscentDescent();
        $this->assertEquals(50.2, $result['descent']);
    }
    
    public function testActivitySplitsInMiles(){
        $this->assertEquals(3, count($this->activity->getSplits('mi')));
    }
    
    public function testActivitySplitsInKilometres(){
        $this->assertEquals(5, count($this->activity->getSplits('k')));
    }
    
}