# SilverStripe Serve

A simple dev task, to start a development server for your SilverStripe app.

## Getting started

```sh
$ composer require silverstripe/serve
$ framework/sake dev/build flush=1
$ vendor/bin/serve
```

This will start the server at `http://localhost:8080`.

You can override the host/port:

```sh
$ vendor/bin/serve --host 127.0.0.1 --port 8000
```

![](serve.gif)

## Opening a browser

You can add the `--open` argument to open a new browser window with the new server.

```sh
$ vendor/bin/serve --open
```


## Including a bootstrap file

The bootstrap-file argument lets you include a custom PHP file after
composer has been loaded (which includes Silverstripe’s Constants.php)
but before main.php has been loaded.

This can be used for any number of things, but the primary use-case
is to pull in any stub code & config that wouldn’t normally be included
by SilverStripe in the current execution session, such as test stubs.

```sh
$ vendor/bin/serve --bootstrap-file tests/serve-bootstrap.php
```

## Using as a library

You can also use serve as a library, to start a SilverStripe server
from some other tool such as a test suite:

Assuming that `BASE_PATH` is defined, you can use it like this:

```php
use SilverStripe\Serve\ServerFactory;

$factory = new ServerFactory();

$server = $factory->launchServer([
    'host' => 'localhost',
    'preferredPort' => 3000,
]);

// Print the contents of the homepage
echo file_get_contents($server->getURL());

// Stop the server when you're done with it
$server->stop();
```

If `BASE_PATH` is not defined, e.g. if you are not running a SapphireTest,
you can provide an alternative path to the factory constructor:

```php
$factory = new ServerFactory(realpath(__DIR__ . '/../'));
```

launchServer allows the following options to be passed to it:

 * **host:** The host to listen on, defaulting to 0.0.0.0
 * **preferredPort:** The preferred port. If this port isn't available, the next
   highest one will be used
 * **bootstrapFile:** The bootstrap file, as described above
