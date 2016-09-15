# SilverStripe Serve

A simple dev task, to start a development server for your SilverStripe app.

## Getting started

```sh
$ composer require silverstripe/serve
$ framework/sake dev/build flush=1
$ bin/serve
```

This will start the server at `http://localhost:8080`.

You can override the host/port:

```sh
$ bin/serve --host 127.0.0.1 --port 8000
```

![](serve.gif)

## Including a bootstrap file

The bootstrap-file argument lets you include a custom PHP file after
composer has been loaded (which includes Silverstripe’s Constants.php)
but before main.php has been loaded.

This can be used for any number of things, but the primary use-case
is to pull in any stub code & config that wouldn’t normally be included
by SilverStripe in the current execution session, such as test stubs.

$ bin/serve --bootstrap-file tests/serve-bootstrap.php
```
