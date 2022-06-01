<?php

namespace SilverStripe\Serve\Tests;

use BadMethodCallException;
use SilverStripe\Serve\ServerFactory;
use SilverStripe\Serve\PortChecker;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
{
    public function testStartStop()
    {
        $factory = new ServerFactory(BASE_PATH);

        $server = $factory->launchServer([
            'bootstrapFile' => dirname(__FILE__) . '/serve-bootstrap.php',
            'host' => 'localhost',
            'preferredPort' => '3000',
        ]);

        // Server is immediately started
        $this->assertTrue(PortChecker::isPortOpen('localhost', $server->getPort()));

        // Test a "stable" URL available via the framework module, that isn't tied to an environment type
        $content = file_get_contents($server->getURL());

        // Check that the login form exists on the displayed page
        $this->assertStringContainsString('Hello World!', $content);

        // When it stops, it stops listening
        $server->stop();

        $this->assertFalse(PortChecker::isPortOpen('localhost', $server->getPort()));
    }

    public function testStartTwiceFails()
    {
        $factory = new ServerFactory(realpath(__DIR__ . '/..'));
        $server = $factory->launchServer([
            'host' => 'localhost',
            'preferredPort' => '3000',
        ]);

        // Start fails because the server is already started
        $this->expectException('LogicException');
        $server->start();
    }

    public function testStopTwiceFails()
    {
        $factory = new ServerFactory(BASE_PATH);
        $server = $factory->launchServer([
            'host' => 'localhost',
            'preferredPort' => '3000',
        ]);

        $server->stop();

        // Stop a 2nd fails because the server is already stopped
        $this->expectException('LogicException');
        $server->stop();
    }

    public function testPreferredPortFindsAnOpenPort()
    {
        $factory = new ServerFactory(BASE_PATH);
        $server1 = $factory->launchServer([
            'host' => 'localhost',
            'preferredPort' => '3000',
        ]);

        $server2 = $factory->launchServer([
            'host' => 'localhost',
            'preferredPort' => '3000',
        ]);

        $this->assertNotEquals($server1->getPort(), $server2->getPort());

        $this->assertTrue(PortChecker::isPortOpen('localhost', $server1->getPort()));
        $this->assertTrue(PortChecker::isPortOpen('localhost', $server2->getPort()));
    }
}
