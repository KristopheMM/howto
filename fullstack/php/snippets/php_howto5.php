################################################################
#
#   GuzzleHttp Promises
#
################################################################

// http://docs.guzzlephp.org/en/latest/quickstart.html
// http://docs.guzzlephp.org/en/stable/faq.html
// https://www.youtube.com/watch?v=4J7p0CZ0aQ4

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

// ------------------------------------------------------------------------------------
//  Send an asynchronous request.
// ------------------------------------------------------------------------------------
$client = new \GuzzleHttp\Client();
// start request
$promise = $client->getAsync('http://loripsum.net/api')->then(
	function ($response) {
	   return $response->getStatusCode(). PHP_EOL;
	},
	function ($exception) {
	   return $exception->getMessage(). PHP_EOL;
	}
);
// do other things
echo '<b>This will not wait for the previous request to finish to be displayed!</b>'. PHP_EOL;
// wait for request to finish and display its response
$response = $promise->wait();
echo $response;

// ------------------------------------------------------------------------------------
// Send an synchronous request.
// ------------------------------------------------------------------------------------
$client = new GuzzleHttp\Client();
$res    = $client->request('GET', 'http://httpbin.org/get', [  /*'auth' => ['user', 'pass']*/]);
echo $res->getStatusCode() . PHP_EOL; // "200"
//echo $res->getHeader('content-type')[0].PHP_EOL; // 'application/json; charset=utf8'
//echo $res->getBody().PHP_EOL;
// Send an asynchronous request.
$request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
$promise = $client->sendAsync($request)->then(
	function ($response) {
	   echo 'I completed! ' . $response->getStatusCode() . PHP_EOL;
	}, function ($response) {
   echo 'Not completed! ' . $response->getStatusCode() . PHP_EOL;
}
);
$promise->wait();

// ------------------------------------------------------------------------------------
// request an asynchronous request.
// ------------------------------------------------------------------------------------
$client  = new GuzzleHttp\Client();
$promise = $client->requestAsync('GET', 'http://httpbin.org/get');
$promise->then(
	function ($response) {
	   echo 'Got a response! ' . $response->getStatusCode() . PHP_EOL;
	},
	function ($response) {
	   echo 'Got no response! ' . $response->getStatusCode() . PHP_EOL;
	}
);
$promise->wait();


// ------------------------------------------------------------------------------------
// request an asynchronous request.
// ------------------------------------------------------------------------------------
$client = new Client();
$requests = function ($total) {
   $uri = 'http://httpbin.org/get';
   for ($i = 0; $i < $total; $i++) {
	  yield new Request('GET', $uri);
   }
};
$pool = new Pool($client, $requests(3), [
	'concurrency' => 5,
	'fulfilled' => function (Response $response, $index) {
	   // this is delivered each successful response
	   echo 'Got a fulfilled! ' . $response->getStatusCode() . PHP_EOL;
	},
	'rejected' => function (RequestException $reason, $index) {
	   // this is delivered each failed request
	   echo 'Got a rejected! ' . $reason->getMessage() . PHP_EOL;
	},
]);
// Initiate the transfers and create a promise
$promise = $pool->promise();
// Force the pool of requests to complete.
$promise->wait();



// ------------------------------------------------------------------------------------
// request an asynchronous request.
// ------------------------------------------------------------------------------------
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

$curl = new CurlMultiHandler;
$handler = HandlerStack::create($curl);
$client = new Client(['handler' => $handler]);

$p = $client
	->getAsync('http://google.com')
	->then(
		function (ResponseInterface $res) {
		   echo 'google response: ' . $res->getStatusCode() . PHP_EOL;
		},
		function (\Exception $e) {
		   echo $e->getMessage() . PHP_EOL;
		}
	);
while ($p->getState() === 'pending') {
   $curl->tick();
   //do some other stuff here or just
   sleep(1);
}
$p->wait();




/* GuzzleHttp installation
---------------------------------------------

 Did you mean one of these?
      guzzlehttp/psr7
      guzzlehttp/ring
      guzzle/guzzle
      guzzlehttp/guzzle
      guzzlehttp/streams

composer require guzzlehttp/psr7
composer require guzzlehttp/guzzle
composer require guzzlehttp/streams

---------------------------------------------
*/

require 'vendor/autoload.php';

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
// ------------------------------------------------------------------------------------
// request an asynchronous request.
// ------------------------------------------------------------------------------------
try{
    $client  = new GuzzleHttp\Client();
    $promise = $client->requestAsync('GET', 'http://httpbin.org/get');
    $promise->then(
        function ($response) {
           echo  $response->getStatusCode(). PHP_EOL;
        },
        function ($exception) {
           echo $exception->getMessage(). PHP_EOL;
        }
    );
    $promise->wait();
}
catch(Exception $e){
    echo $e->getMessage();
}


// ------------------------------------------------------------------------------------
// Fatal error: Uncaught Error: Class ‘WP_Recovery_Mode_Link_Service’ not found
// Fatal error: Uncaught Error: Class 'FacebookGraphAPIError' not found
// ------------------------------------------------------------------------------------
// FIX: https://www.php.net/manual/en/function.class-exists.php
// class_exists ( string $class_name [, bool $autoload = TRUE ] ) : bool

// Check that the class exists before trying to use it
if (class_exists('MyClass')) {
    $myclass = new MyClass();
}

// Check to see whether the include declared the class
if (!class_exists('MyClass', true)) {
	trigger_error("Unable to load class: 'MyClass' ", E_USER_WARNING);
}


/*
require __DIR__.'/vendor/autoload.php';
use scratchers\nstest\Container;
use scratchers\nstest\MyClass;

$obj = Container::get(MyClass::class);
echo $obj->prop;
*/



##############################################################
/*
static::class vs get_called_class()
self::class vs get_class() vs __CLASS__

Understanding difference between
 __CLASS__, get_class(), and get_called_class() with underlying self/static keyword
*/
##############################################################
/*
https://gist.github.com/surferxo3/0f6f181c2633996ff3815358d360f567
https://www.php.net/manual/en/function.get-called-class.php
https://riptutorial.com/php/example/4661/difference-between---class----get-class---and-get-called-class--
https://www.leaseweb.com/labs/2014/04/static-versus-self-php/
https://arueckauer.github.io/posts/2019/11/self-vs.-static/
https://stackoverflow.com/questions/47798831/difference-staticclass-vs-get-called-class-and-class-vs-get-class-vs-s/49917180
https://belineperspectives.com/2017/03/13/get_classthis-vs-staticclass/
*/
class Foo
{
    public function __invoke()
    {
        echo 'self: ' . self::class . PHP_EOL;
        echo 'static: ' . static::class . PHP_EOL;
        echo 'get_class(): ' . get_class() . PHP_EOL;
        echo 'get_class($this): ' . get_class($this) . PHP_EOL;
        echo 'get_called_class(): ' . get_called_class() . PHP_EOL;
    }
}

class Bar extends Foo{}
(new Bar())();

/*
Output:
self: Foo
static: Bar
get_class(): Foo
get_class($this): Bar
get_called_class(): Bar
*/




/*
https://www.w3schools.com/php/func_array_filter.asp
https://www.php.net/manual/de/function.array-filter.php
*/

array_filter ( $array2, 'trim' );
array_map ( $array2, 'trim' );



/* Extract EMAIL */
$email = "youremail@somedomain.com";
$domain_name = substr(strrchr($email, "@"), 1);
$domain_name1 = explode("@",$email)[1];
echo "<br>Domain name is :" . $domain_name;
echo "<br>Domain name is :" . $domain_name1;







/*
PHP Worker Performance Benchmarking and Test Results
https://pagely.com/blog/php-worker-performance-benchmarking/
https://github.com/pagely/php-worker-benchmarking
*/

// Benchmarking Encrypt and decrypt a string 50,000 times.
while ( $times_run < 50000 ) {
    $encrypted = openssl_encrypt( $string, $method, $key, null, $iv );
    $decrypted = openssl_decrypt( $encrypted, $method, $key, null, $iv );
    $times_run++;
}


// Benchmarking Environment
//
// #!/bin/bash
// mkdir -p reports
//
// # “num-cores cpuset”
// for row in “1 0” “2 0-1”
// do
//     set — $row
//     cores=$1
//     cpuset=$2
//     for worker in {1,2,8,50,100,200}
//     do
//         pworker=$(printf “%03d” $worker)
//         pcores=$(printf “%02d” $cores)
//         file=reports/${pcores}core-${pworker}worker.txt
//         json=reports/${pcores}core-${pworker}worker.json
//         if [[ ! -f $file ]]
//         then
//             ./run-php.sh $cpuset $worker $file
//             ./run-bench.sh 3 $worker $json >> $file
//         fi
//     done
// done

##############################################################
# singleton
##############################################################
/*
https://www.thewebhatesme.com/allgemein/php-entwurfsmuster-singleton/
https://phpenthusiast.com/blog/the-singleton-design-pattern-in-php
https://refactoring.guru/design-patterns/singleton/php/example#
https://www.thewebhatesme.com/allgemein/php-entwurfsmuster-singleton/
https://sourcemaking.com/design_patterns/singleton/php/1#
https://daylerees.com/php-patterns-singleton/
https://www.php-einfach.de/experte/codeschnipsel/8761-design-patterns-in-php5/
https://poe-php.de/oop/entwurfsmuster-sinn-und-unsinn-des-singleton
https://designpatternsphp.readthedocs.io/de/latest/Creational/Singleton/README.html#
https://phpenthusiast.com/blog/the-singleton-design-pattern-in-php
https://designpatternsphp.readthedocs.io/de/latest/Creational/Singleton/README.html#

https://www.geeksforgeeks.org/singleton-class-java/
https://javabeginners.de/Design_Patterns/Singleton_-Pattern.php
https://www.journaldev.com/1377/java-singleton-design-pattern-best-practices-examples
*/