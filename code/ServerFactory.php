<?php

namespace SilverStripe\Serve;

use BuildTask;
use SS_HTTPRequest;
use Symfony\Component\Process\PhpExecutableFinder;

/**
 * Start a SilverStripe server
 */
class ServerFactory
{
    /**
     * Create a new Server object
     *
     * The following options are allowed:
     *  - host: The host to listen on. Defaults to '0.0.0.0'
     *  - preferredPort: The port that is preferred. If the port is taken, the next available will be used
     *  - bootstrapFile: A PHP file to include in the server's bootstrap
     *
     * @param array $options Options for the server
     * @return Server
     */
    public function launchServer($options)
    {
        $bin = (new PhpExecutableFinder)->find(false);

        $host = empty($options['host']) ? '0.0.0.0' : $options['host'];
        $port = $options['preferredPort'];
        $path = BASE_PATH;

        $base = __DIR__;
        $command = escapeshellcmd($bin) .
            ' -S ' . escapeshellarg($host . ':' . $port) .
            ' -t ' . escapeshellarg($path) . ' ' .
            escapeshellarg($base . '/server-handler.php');

        if (!empty($options['bootstrapFile'])) {
            $command = "SERVE_BOOTSTRAP_FILE=" . escapeshellarg($options['bootstrapFile']) . " $command";
        }

        echo $command;
        return new Server($command, $host, $port);
    }
}
