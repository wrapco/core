<?php
/**
 * 2018-12-02 Dmitry Fedyuk https://www.upwork.com/fl/mage2pro
 * `array_column` does not work correctly on the wrapco.com.au and inkyco.com.au servers for an unknowm reason.
 * The servers use PHP 7.0.32: https://www.wrapco.com.au/i.php
 * My function solves the problems:
 * 1) «Fix the categories control on the backend product pages»:
 * https://www.upwork.com/ab/f/contracts/21179310
 * https://www.upwork.com/ab/f/contracts/21179293
 * 2) «Fix the "Your search returned no results" issue»:
 * https://www.upwork.com/ab/f/contracts/21179309
 * https://www.upwork.com/ab/f/contracts/21179213
 * @param array(string => mixed) $a
 * @param string $column
 * @param string|null $key [optional]
 * @return array(string => mixed)
 */
function wrapco_array_column(array $a, $column, $key = null) {
	$r = [];
	foreach ($a as $v) {
		if (null === $key) {
			$r[]= $v[$column];
		}
		else {
			$r[$v[$key]] = $v[$column];
		}
	}
	return $r;
}