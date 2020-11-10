<?php

namespace SilverStripe\Serve;

use Symfony\Component\Process\PhpExecutableFinder;

/**
 * Start a SilverStripe server
 */
class ServerFactory
{

    /**
     * Path to base folder for this app
     *
     * @var string
     */
    private $path;

    /**
     * Create a new ServerFactory
     *
     * @param string $path The base path of the hosted project. Defaults to BASE_PATH
     */
    public function __construct($path = null)
    {
        $this->path = $path ?: BASE_PATH;
    }

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
        $port = PortChecker::findNextAvailablePort($host, $options['preferredPort']);

        $base = __DIR__;
        $command = escapeshellcmd($bin) .
            ' -S ' . escapeshellarg($host . ':' . $port) .
            ' -t ' . escapeshellarg($this->path) . ' ' .
            escapeshellarg($base . '/server-handler.php');
        if(\DIRECTORY_SEPARATOR !== '\\') {
            $command .= "exec ";
        }

        if (!empty($options['bootstrapFile'])) {
            $command = "SERVE_BOOTSTRAP_FILE=" . escapeshellarg($options['bootstrapFile']) . " $command";
        }

        $server = new Server($command, $host, $port);
        $server->start();

        return $server;
    }
}
