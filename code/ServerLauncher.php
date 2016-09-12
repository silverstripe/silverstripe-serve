<?php

namespace SilverStripe\Serve;

use BuildTask;
use SS_HTTPRequest;
use Symfony\Component\Process\PhpExecutableFinder;

/**
 * Start a SilverStripe server
 */
class ServerLauncher
{
    /**
     * @param string $host The host to listen on
     * @param string $port The port to listen on
     * @param string $path The web root
     * @param string $hash Optional; a value for SERVE_HASH to pass to the server
     */
    public function run($host, $port, $path, $hash = null)
    {

        $bin = (new PhpExecutableFinder)->find(false);

        $base = __DIR__;
        $command = "'{$bin}' -S {$host}:{$port} -t '{$path}' '{$base}/server-handler.php'";

        if ($hash) {
            $command .= " SERVE_HASH={$hash}";
        }

        print "Server running at http://{$host}:{$port} for $path...\n";

        passthru($command);
    }
}
