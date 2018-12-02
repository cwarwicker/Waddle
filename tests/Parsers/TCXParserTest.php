<?php

namespace Waddle\Parsers;

class TXCParserTest extends \PHPUnit\Framework\TestCase
{
    public $parser;
    
    public function setUp() {
        $this->parser = new \Waddle\Parsers\TCXParser();
    }

    public function testDetectsNamespace() {
        $reflector = new \ReflectionClass($this->parser );
		$method = $reflector->getMethod('detectsNamespace');
		$method->setAccessible(true);
        $method->invokeArgs($this->parser, [simplexml_load_file(__DIR__ . '/../run_garmin.tcx')]);

        $reflector = new \ReflectionClass($this->parser);
		$property = $reflector->getProperty('nameNSActivityExtensionV2');
		$property->setAccessible(true);
 
		$this->assertEquals('ns3', $property->getValue($this->parser)); 
    }

    public function testDetectsNamespaceSeveralParse() {
        $reflector = new \ReflectionClass($this->parser );
		$method = $reflector->getMethod('detectsNamespace');
		$method->setAccessible(true);

        $reflector = new \ReflectionClass($this->parser);
        $property = $reflector->getProperty('nameNSActivityExtensionV2');
        
        $method->invokeArgs($this->parser, [simplexml_load_file(__DIR__ . '/../run_garmin.tcx')]);
		$property->setAccessible(true);
        $this->assertEquals('ns3', $property->getValue($this->parser)); 
        
        $method->invokeArgs($this->parser, [simplexml_load_file(__DIR__ . '/../run.tcx')]);
		$property->setAccessible(true);
		$this->assertEquals('x', $property->getValue($this->parser)); 
    }

    private function getActivity() {
        return $this->parser->parse( __DIR__ . '/../run.tcx' );
    }
    
    public function testActivityLaps(){
        $this->assertEquals(1, count($this->getActivity()->getLaps()));
    }
    
    public function testActivityTotalDistance(){
        $this->assertEquals(4824.94, $this->getActivity()->getTotalDistance());
    }
    
    public function testActivityTotalDuration(){
        $this->assertEquals(1424, $this->getActivity()->getTotalDuration());
    }
    
    public function testActivityAveragePacePerMile(){
        $this->assertEquals('00:07:54', $this->getActivity()->getAveragePacePerMile());
    }
    
    public function testActivityAveragePacePerKilometre(){
        $this->assertEquals('00:04:55', $this->getActivity()->getAveragePacePerKilometre());
    }
    
    public function testActivityAverageSpeedMPH(){
        $this->assertEquals('7.58', round($this->getActivity()->getAverageSpeedInMPH(), 2));
    }
    
    public function testActivityAverageSpeedKPH(){
        $this->assertEquals('12.20', round($this->getActivity()->getAverageSpeedInKPH(), 2));
    }
    
    public function testActivityTotalCalories(){
        $this->assertEquals(372, $this->getActivity()->getTotalCalories());
    }
    
    public function testActivityMaxSpeedMPH(){
        $this->assertEquals('10.45', round($this->getActivity()->getMaxSpeedInMPH(), 2));
    }
    
    public function testActivityMaxSpeedKPH(){
        $this->assertEquals('16.81', round($this->getActivity()->getMaxSpeedInKPH(), 2));
    }
    
    public function testActivityTotalAscent(){
        $result = $this->getActivity()->getTotalAscentDescent();
        $this->assertEquals(50.9, $result['ascent']);
    }
    
    public function testActivityTotalDescent(){
        $result = $this->getActivity()->getTotalAscentDescent();
        $this->assertEquals(50.2, $result['descent']);
    }
    
    public function testActivitySplitsInMiles(){
        $this->assertEquals(3, count($this->getActivity()->getSplits('mi')));
    }
    
    public function testActivitySplitsInKilometres(){
        $this->assertEquals(5, count($this->getActivity()->getSplits('k')));
    }
    
}