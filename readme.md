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
