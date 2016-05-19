<?php

namespace SilverStripe\Serve;

use BuildTask;
use SS_HTTPRequest;
use Symfony\Component\Process\PhpExecutableFinder;

class Task extends BuildTask
{
    /**
     * @var string
     */
    protected $title = "Development Server";

    /**
     * @var string
     */
    protected $description = "Connects the PHP development server to SilverStripe.";

    /**
     * @var bool
     */
    protected $enabled = true;

    /**
     * @inheritdoc
     *
     * @param SS_HTTPRequest $request
     */
    public function run($request)
    {
        $path = __DIR__;
        $bin = (new PhpExecutableFinder)->find(false);

        $root = SERVE_ROOT;
        $host = SERVE_HOST;
        $port = SERVE_PORT;

        print "Server running at http://{$host}:{$port}\n";

        passthru("'{$bin}' -S {$host}:{$port} -t '{$root}' '{$path}/server.php'");
    }
}
