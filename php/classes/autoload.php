<?php
/**
 * PSR-4 Compliant Autoloader
 *
 * This will dynamically load classes by resolving the prefix and class name.
 *
 * @param string $class fully qualified class name to load
 */
spl_autoload_register(function($class) {
	/**
	 * CONFIGURABLE PARAMETERS
	 * prefix: the prefix for all the classes (e.g., the namespace)
	 * baseDir: the base directory for all classes (default = current directory)
	 */
	$prefix = "FoodTruckFinder\\Capstone";
	$baseDir = __DIR__;

	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if(strcmp($prefix, $class) !== 0) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$className = substr($class, $len);

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $baseDir . str_replace("\\", "/", $className) . "php";

	//if the file exists, require it
	if(file_exists($file)) {
		require_once($file);
	}
});