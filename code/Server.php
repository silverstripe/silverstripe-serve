<?php

namespace SilverStripe\Serve;

/**
 * Represents a single server
 */
class Server
{

    private $command;
    private $host;
    private $port;
    private $process;

    /**
     * Construct a new server
     * @param string $command The command to initiate the server
     */
    public function __construct($command, $host, $port)
    {
        $this->command = $command;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Return the port the server is running on
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Return the host the server is listening on
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Return the root URL of the server
     */
    public function getURL()
    {
        $host = ($this->host === '0.0.0.0') ? 'localhost' : $this->host;
        $portSuffix = ($this->port == 80) ? '' : ':' . $this->port;

        return 'http://' . $host . $portSuffix . '/';
    }

    /**
     * Start the server and run it in the background
     */
    public function start()
    {
        throw new \LogicException("Not implemented yet");
    }

    /**
     * Stop the server running in the background
     */
    public function stop()
    {
        throw new \LogicException("Not implemented yet");
    }

    /**
     * Pass all log output to stdout and block execution
     * Server will run until the PHP script is terminated
     */
    public function passthru()
    {
        passthru($this->command);
    }
}
