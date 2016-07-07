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

        $hash = getenv("SERVE_HASH");
        $path = getenv("SERVE_PATH");
        $host = getenv("SERVE_HOST");
        $port = getenv("SERVE_PORT");

        $command = "'{$bin}' -S {$host}:{$port} -t '{$path}' '{$path}/server.php'";

        if ($hash) {
            $command .= " SERVE_HASH={$hash}";
        }

        print "Server running at http://{$host}:{$port}\n";

        passthru($command);
    }
}
