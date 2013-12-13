<?php

/**
 * PHCurryDI - A library implementing one function similar to the standard curry
 * function (http://en.wikipedia.org/wiki/Currying) found in functional
 * programming but allows parameters to applied non-sequentially based on name
 * matching. This could be useful for dependency injection...
 */

/**
 * PHCurryDI - A library implementing one function similar to the standard curry
 * function (http://en.wikipedia.org/wiki/Currying) found in functional
 * programming but allows parameters to applied non-sequentially based on name
 * matching. This could be useful for dependency injection...
 *
 * @param Function $func The function that will have it's arguments dependency injected.
 * @param Array $dependencies The dependencies as an Associative Array
 * @return Function
 */
function PHCurryDI($func, $dependencies) {
	
	$argumentInforation = call_user_func(function($f) {
		$reflectionFunc = new ReflectionFunction($f);
		return array_map(
			function($p) {
				return $p->getName();
			},
			$reflectionFunc->getParameters()
		);
	},$func);
	
	$buildArguments = function($callArguments) use ($argumentInforation, $dependencies) {
		$callArgumentsPos = 0;
		$resultArguments = array();
		
		for ($i = 0; $i < sizeof($argumentInforation); $i++) {
			$resultArguments[] = 
				(array_key_exists($argumentInforation[$i], $dependencies)) ?
					$dependencies[$argumentInforation[$i]] :
					$callArguments[$callArgumentsPos++];
		}
		
		while ($callArgumentsPos < sizeof($callArguments)) {
			$resultArguments[] = $callArguments[$callArgumentsPos++];
		}
		
		return $resultArguments;
	};
	
	return function() use (&$func, &$buildArguments) {
		return call_user_func_array($func, $buildArguments(func_get_args()));
	};
	
};
