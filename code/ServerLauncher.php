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
     * @param string $bootstrapFile Optional; a bootstrap file to load into the runtime
     */
    public function run($host, $port, $path, $hash = null, $bootstrapFile = null)
    {

        $bin = (new PhpExecutableFinder)->find(false);

        $base = __DIR__;
        $command = "'{$bin}' -S {$host}:{$port} -t '{$path}' '{$base}/server-handler.php'";

        if ($hash) {
            $command = "SERVE_HASH=" . escapeshellarg($hash) . " $command";
        }

        if ($bootstrapFile) {
            $command = "SERVE_BOOTSTRAP_FILE=" . escapeshellarg($bootstrapFile) . " $command";
        }

        print "Server running at http://{$host}:{$port} for $path...\n";

        passthru($command);
    }
}
