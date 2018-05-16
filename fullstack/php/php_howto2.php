

############################################################

strip properties of an object that are null?
https://stackoverflow.com/questions/4352203/any-php-function-that-will-strip-properties-of-an-object-that-are-null
https://www.tutorialrepublic.com/faq/how-to-remove-empty-values-from-an-array-in-php.php

############################################################

// --------------
// Strips any false-y values
$object = (object) array_filter((array) $object);
// Strips only null values
$object = (object) array_filter((array) $object, function ($val) {
    return !is_null($val);
});


// --------------
$someObject = (array)$someObject;
array_walk_recursive($someObject, function($v,$k) use (&$someObject) {
    if($someObject[$k] == null) {
        unset($someObject[$k]);
    }
});

$someObject = (object)$someObject;
var_dump($someObject);



// --------------
// Setup
$obj = (object) array('foo' => NULL, 'bar' => 'baz');
// equivalent to array_filter
array_walk($obj, function($v,$k) use ($obj) {
    if(empty($v)) unset($obj->$k);
});
// output
print_r($obj);


// --------------
// filter
$array = array("apple", "", 2, null, -5, "orange", 10, false, "");
var_dump($array);
echo "<br>";

// Filtering the array
$result = array_filter($array);
var_dump($result);














############################################################
#
#	An API with repeating parameters
#	Multiple Query Parameters of Same Name
#	Serializing an Array as a Sequence of Elements
#
############################################################

/*
https://stackoverflow.com/questions/24872088/php-soapclient-multiple-arguments-with-the-same-name
https://stackoverflow.com/questions/37765861/send-data-to-soap-api-involving-repeated-elements-of-same-name
https://www.sitepoint.com/community/t/an-api-with-repeating-parameters/32601/4
https://community.servicenow.com/community?id=community_question&sys_id=0a2347e1dbd8dbc01dcaf3231f96196c
https://community.servicenow.com/community?id=community_question&sys_id=bae98729db5cdbc01dcaf3231f9619e5
https://futurestud.io/tutorials/retrofit-multiple-query-parameters-of-same-name
https://community.smartbear.com/t5/SoapUI-Pro/Res-duplicate-properties-in-REST-request/td-p/39318
https://docs.microsoft.com/en-us/dotnet/standard/serialization/controlling-xml-serialization-using-attributes
https://framework.zend.com/apidoc/2.0/classes/Zend.Soap.Wsdl.html
http://php.net/manual/en/soapclient.soapcall.php
http://php.net/manual/en/soapvar.soapvar.php
https://github.com/GoteoFoundation/goteo-legacy/blob/master/library/pear/SOAP/Client.php
http://php.net/manual/de/soapclient.soapclient.php
http://be2.php.net/manual/en/class.soapfault.php
https://github.com/zendframework/zend-soap/issues/37
https://framework.zend.com/manual/1.12/de/zend.soap.client.html
https://stackoverflow.com/questions/15559056/content-type-application-soapxml-charset-utf-8-was-not-supported-by-service/25302867
https://github.com/artisaninweb/laravel-soap/issues/108
http://php.net/manual/de/function.stream-context-create.php
https://stackoverflow.com/questions/9909232/php-soapclient-stream-context-option
http://www.king-foo.com/2011/09/using-complex-types-with-zendsoap/
https://framework.zend.com/manual/2.3/en/modules/zend.soap.wsdl.html
https://framework.zend.com/manual/2.1/en/modules/zend.validator.identical.html
https://stackoverflow.com/questions/29941570/zend-soap-change-the-default-array-element-name-item-to-class-name-of-complex
https://zendframework.github.io/zend-soap/wsdl/
https://stackoverflow.com/questions/3617398/soapclient-how-to-pass-multiple-elements-with-same-name
https://beberlei.de/2014/01/31/soap_and_php_in_2014.html
---------
*/

public class Group{
    [XmlArrayItem(Type = typeof(Employee)),
    XmlArrayItem(Type = typeof(Manager))]
    public Employee[] Employees;
}
public class Employee{
    public string Name;
}
public class Manager:Employee{
    public int Level;
}

public class Group{
    [XmlElement]
    public Employee[] Employees;
}

// ------------

$this->soapWrapper->add('bsedemo', function ($service) {
  $service
    ->wsdl('http://bsestarmfdemo.bseindia.com/MFOrderEntry/MFOrder.svc?singleWsdl')
    ->trace(true)
    ->header('Content-type','application/soap+xml; charset=utf-8');

});

------------

$a = [
    'properties' => [
        [
          'name' => 'invtype',
          'value' => 'foo'
        ],
        [
          'name' => 'item_number',
          'value' => 'foo'
        ],
    ],
];

------------

$ITEMSITM = new stdClass();
foreach ($parsItem as $item) {
    $ITEMSITM->TITEMSITM[] = $item;
}

$wsdl = 'https://your.api/path?wsdl';
$client = new SoapClient($wsdl);
$multipleSearchValues = [1, 2, 3, 4];
$queryData = ['yourFieldName' => $multipleSearchValues];
$results = $client->YourApiMethod($queryData);
print_r($results);

-----

class Book {
    /** @var string */
    public $title;
    /** @var string */
    public $author;
    /** @var Tag[] */
    public $tags;
}
class Tag {
    /** @var string */
    public $tag;
}

------
$array = ['lets', 'test', 'it'];
$response = new stdClass();
$response->results = $array;


$array = ['lets', 'test', 'it'];
$response = new stdClass();
$response->results = new ArrayObject();
foreach($array as $item) {
  $response->results->append($item);
}


$array = ['lets', 'test', 'it'];
$response = new stdClass();
$response->results = new ArrayObject();
foreach($array as $item) {
    $soapVar = new SoapVar($item,XSD_STRING,NULL,NULL,'result');
    $response->results->append($soapVar);
}

-----


$wsdl = 'https://your.api/path?wsdl';
$client = new SoapClient($wsdl);
$multipleSearchValues = [1, 2, 3, 4];
$queryData = ['yourFieldName' => $multipleSearchValues];
$results = $client->YourApiMethod($queryData);
print_r($results);


$obj = new StdClass();
foreach ($telnums as $telnum) {
    $obj->telnums[] = $telnum;
}

$options = array(
  'createDomainRequest' => array(
    'telnums' => array(
      '10',
      '20',
      '30'
    )
  )
);


$soapClient = new SoapClient($wsdl);
$soapClient->__call('createDomain', array(
    new SoapParam('10', 'telnums'),
    new SoapParam('20', 'telnums'),
    new SoapParam('30', 'telnums'),
));


---------------

$client = new SOAPClient($wsdl, array(
    'classmap' => array(
        'Person' => 'DHL\Intraship\Person',
        // all the other types
    )
));















