<?php

require 'phcurrydi.php';

class PHCurryDiTest extends PHPUnit_Framework_TestCase
{
    public function testWithNoMatchingArguments()
    {
    	$calculator = function($w, $h, $l) {
			return $w . ' * ' . $h . ' * ' . $l . ' = ' . ($w * $h * $l);
		};
		$dependencies = array('a' => 9, 'b'=>'what');
    	$this->assertEquals(
    		'2 * 3 * 4 = 24',
    		call_user_func(phcurrydi($calculator, $dependencies), 2, 3, 4)
    	);
    }
    
    public function testWithSomeMatchingArguments()
    {
    	$calculator = function($w, $h, $l) {
			return $w . ' * ' . $h . ' * ' . $l . ' = ' . ($w * $h * $l);
		};
		$dependencies = array('h' => 3, 'b'=>'what');
    	$this->assertEquals(
    		'2 * 3 * 4 = 24',
    		call_user_func(phcurrydi($calculator, $dependencies), 2, 4)
    	);
    }
    
    public function testWithExtraArgumentsInOrder()
    {
    	$calculator = function($w, $h, $l) {
    		return implode(' * ', func_get_args());
		};
		$dependencies = array('h' => 3, 'b'=>'what');
    	$this->assertEquals(
    		'2 * 3 * 4 * 5 * 6',
    		call_user_func(phcurrydi($calculator, $dependencies), 2, 4, 5, 6)
    	);
    }
    
    public function testWithAllMatchingArguments()
    {
    	$calculator = function($w, $h, $l) {
			return $w . ' * ' . $h . ' * ' . $l . ' = ' . ($w * $h * $l);
		};
		$dependencies = array('w' => 2, 'h' => 3, 'l'=> 4);
    	$this->assertEquals(
    		'2 * 3 * 4 = 24',
    		call_user_func(phcurrydi($calculator, $dependencies), 9, 8, 7)
    	);
    }
    
}
?>
