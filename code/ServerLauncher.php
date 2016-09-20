<?php

namespace SilverStripe\Serve;

use Symfony\Component\Process\PhpExecutableFinder;

class ServerLauncher
{
    /**
     * @param string $host Host to listen on
     * @param string $port Port to listen on
     * @param string $path Root web directory
     * @param string $hash Hash to pass to the server script (Optional)
     * @param string $bootstrapFile Bootstrap file to load into the runtime (Optional)
     */
    public function run($host, $port, $path, $hash = null, $bootstrapFile = null)
    {
        $bin = (new PhpExecutableFinder)->find(false);

        $command = sprintf(
            "'%s' -S %s:%s -t '%s' '%s/handler.php'",
            $bin, $host, $port, $path, __DIR__
        );

        if (!empty($hash)) {
            $command = sprintf(
                "SERVE_HASH=%s %s",
                escapeshellarg($hash), $command
            );
        }

        if (!empty($bootstrapFile)) {
            $command = sprintf(
                "SERVE_BOOTSTRAP_FILE=%s %s",
                escapeshellarg($bootstrapFile), $command
            );
        }

        print "command: {$command}\n";

        print sprintf(
            "Server running at http://%s:%s for %s...\n",
            $host, $port, $path
        );

        passthru($command);
    }
}
