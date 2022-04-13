<?php

namespace SilverStripe\Serve;

/**
 * Utility functions to check for available ports
 *
 * This class is not part of this pacakge's public API and may change without warning.
 *
 * @internal
 */
class PortChecker
{
    /**
     * Return true if the given port is open and listening for connections
     *
     * @param string $host The host. If '0.0.0.0' is passed, localhost willl be checked.
     * @param int $port The port to check
     * @return boolean True if the port is open and listening for connections
     */
    public static function isPortOpen($host, $port)
    {
        if ($host === '0.0.0.0') {
            $host = 'localhost';
        }

        $connection = @fsockopen($host ?? '', $port ?? 0);
        if (is_resource($connection)) {
            fclose($connection);
            return true;
        }

        return false;
    }

    /**
     * Return the next available port, starting at $port and going upwards
     *
     * @param string $host The host. If '0.0.0.0' is passed, localhost willl be checked
     * @param int $port The preferred port to start looking at
     * @return int The number of the next available port
     */
    public static function findNextAvailablePort($host, $port)
    {
        while (self::isPortOpen($host, $port)) {
            $port++;
        }

        return $port;
    }
}
