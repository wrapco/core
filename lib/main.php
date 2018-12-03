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
 * 2018-12-03
 * The @used-by \Magento\Quote\Model\Quote\TotalsReader::convert() calls array_column() in an incorrect way:
 * 		if (count(wrapco_array_column($total, 'code')) > 0) {
 * $total has the following structure in this case:
 * Array
 *	(
 *		[code] => subtotal
 *		[title] => Magento\Framework\Phrase Object ()
 *		[value] => 518.1800
 *	)
 * This way of calling is incorrect because it violates the array_column() specification:
 * http://php.net/manual/en/function.array-column.php
 * The specification says about the first argument:
 * «A multi-dimensional array or an array of objects from which to pull a column of values from.»
 * $total is not a multi-dimensional array nor an array of objects.
 * @param array(string => mixed) $a
 * @param string $column
 * @param string|null $key [optional]
 * @return array(string => mixed)
 */
function wrapco_array_column(array $a, $column, $key = null) {
	$r = [];
	foreach ($a as $v) {
		/**
		 * 2018-12-03
		 * The @used-by \Magento\Quote\Model\Quote\TotalsReader::convert() calls array_column() in an incorrect way:
		 * 		if (count(wrapco_array_column($total, 'code')) > 0) {
		 * $total has the following structure in this case:
		 * Array
		 *	(
		 *		[code] => subtotal
		 *		[title] => Magento\Framework\Phrase Object ()
		 *		[value] => 518.1800
		 *	)
		 * This way of calling is incorrect because it violates the array_column() specification:
		 * http://php.net/manual/en/function.array-column.php
		 * The specification says about the first argument:
		 * «A multi-dimensional array or an array of objects from which to pull a column of values from.»
		 * $total is not a multi-dimensional array nor an array of objects.
		 * As I checked in a PHP debugger, a properly working array_column() function
		 * returns an empty array in this case. So I do the same.
		 */
		if (!is_array($v)) {
			$r = [];
			break;
		}
		else if (null === $key) {
			$r[]= $v[$column];
		}
		else {
			$r[$v[$key]] = $v[$column];
		}
	}
	return $r;
}