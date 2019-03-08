<?php

/*

http://sandbox.onlinephpfunctions.com/
http://www.writephponline.com/
https://www.runphponline.com/
https://paiza.io/projects/-8nCBxIJrewWvIYOsYippw
https://repl.it/languages/php
http://www.compileonline.com/execute_php_online.php
http://phptester.net/

*/


################################################################
#
#    declare(strict_types=1);
#
################################################################

/*
http://php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration.strict
http://php.net/manual/en/functions.returning-values.php#functions.returning-values.type-declaration
http://php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration
*/

################################################################
#
#  check interval
#
################################################################

if(intval(date("H")) >= 7 && intval(date("H")) <= 19){
  	// do not
}

$intDateTimeFrom = strtotime(date("Y-m-d", time()) . " " . "07:00:00");
$intDateTimeTo = strtotime(date("Y-m-d", time()) . " " . "19:00:00");
if (time() >= $intDateTimeFrom && time() <= $intDateTimeTo) {
	// do not
}

################################################################
#
# file_put_contents
#
################################################################
/*
http://php.net/manual/de/context.php
http://php.net/manual/de/function.stream-context-create.php
http://php.net/manual/de/function.file-put-contents.php
*/

file_put_contents($file, $person, FILE_APPEND | LOCK_EX);


################################################################
#
#	array 2 object
#	https://stackoverflow.com/questions/1869091/how-to-convert-an-array-to-object-in-php
#
################################################################

# simplest case
$object = (object) $array;

# loop case
$object = new stdClass();
foreach ($array as $key => $value)
{
    $object->$key = $value;
}

#json style
$object = json_decode(json_encode($array), FALSE);


################################################################
#
# 	datatypes in PHPdoc @param
#
################################################################

The datatype should be a valid PHP type (int, string, bool, etc), a class name for the type of object, or simply "mixed".
Further, you can list multiple datatypes for a single parameter by delimiting them with the pipe (e.g. "@param int|string $p1").

/*
https://manual.phpdoc.org/HTMLSmartyConverter/HandS/phpDocumentor/tutorial_tags.param.pkg.html
https://stackoverflow.com/questions/11663125/two-or-more-datatypes-in-phpdoc-param
http://docs.phpdoc.org/references/phpdoc/tags/param.html
http://docs.phpdoc.org/guides/types.html



https://www.pythonforbeginners.com/system/python-sys-argv
http://php.net/manual/en/reserved.variables.argv.php
http://php.net/manual/en/function.getopt.php
http://php.net/manual/en/reserved.variables.argc.php

http://php.net/manual/de/language.oop5.abstract.php
http://php.net/manual/de/language.oop5.static.php
http://php.net/manual/de/reserved.classes.php
http://php.net/manual/de/language.types.object.php#language.types.object.casting

*/



#----------------------------------
# Error Control Operators sign (@). The @-operator works only on expressions.
#----------------------------------
/*
http://php.net/manual/en/language.operators.errorcontrol.php
http://php.net/manual/de/function.rename.php
*/

#----------------------------------
# @tags
#----------------------------------
// https://docs.phpdoc.org/references/phpdoc/tags/var.html


#----------------------------------
# Checks if the given key or index exists in the array
# http://php.net/manual/de/function.array-key-exists.php
#----------------------------------

$search_array = array('erstes' => 1, 'zweites' => 4);
if (array_key_exists('erstes', $search_array)) {
    echo "Das Element 'erstes' ist in dem Array vorhanden";
}
