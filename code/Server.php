<?php

namespace SilverStripe\Serve;

use LogicException;
use Symfony\Component\Process\Process;

/**
 * Represents a single server
 */
class Server
{
    /**
     * The command to initiate the server
     *
     * @var string
     */
    private $command;

    /**
     * Hostname
     *
     * @var string
     */
    private $host;

    /**
     * Port number
     *
     * @var int
     */
    private $port;

    /**
     * Process being executed
     *
     * @var Process
     */
    private $process;

    /**
     * Construct a new server
     * @param string $command The command to initiate the server
     * @param string $host Hostname
     * @param int $port Port number
     */
    public function __construct($command, $host, $port)
    {
        $this->command = $command;
        $this->host = $host;
        $this->port = $port;
    }

    public function __destruct()
    {
        if ($this->process) {
            $this->stop();
        }
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
        if ($this->process) {
            throw new LogicException("Server already started; cannot start a 2nd time");
        }

        $this->process = new Process($this->command);
        $this->process->setTimeout(3600 * 6);
        $this->process->start();

        // Wait until the the port is open
        $timeout = time() + 30;
        while (time() <= $timeout) {
            if (PortChecker::isPortOpen($this->host, $this->port)) {
                break;
            }

            usleep(10000);
        }

        if (!PortChecker::isPortOpen($this->host, $this->port)) {
            throw new LogicException("Server didn't start on port $this->port for 30 seconds; something is kaput");
        }
    }

    /**
     * Stop the server running in the background
     */
    public function stop()
    {
        if (!$this->process) {
            throw new LogicException("Server not started; cannot stop");
        }

        $this->process->stop(10, SIGINT);
        $this->process = null;

        if (PortChecker::isPortOpen($this->host, $this->port)) {
            throw new LogicException("Server didn't close port $this->port for 30 seconds; something is kaput");
        }
    }

    /**
     * Pass all log output to stdout and block execution
     * Server will run until the PHP script is terminated
     */
    public function passthru()
    {
        if (!$this->process) {
            $this->start();
        }

        $this->process->wait(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
