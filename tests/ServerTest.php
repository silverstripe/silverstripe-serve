<?php

namespace SilverStripe\Serve\Tests;

use SilverStripe\Serve\ServerFactory;
use SilverStripe\Serve\PortChecker;

class ServerTest extends \PHPUnit_Framework_TestCase
{
    public function testStartStop()
    {
        $factory = new ServerFactory(realpath(__DIR__ . '/..'));

        if (file_exists(BASE_PATH . '/vendor/silverstripe/framework/tests/behat/serve-bootstrap.php')) {
            // SS4
            $bootstrapFile = 'vendor/silverstripe/framework/tests/behat/serve-bootstrap.php';
        } else {
            // SS3
            $bootstrapFile = 'framework/tests/behat/serve-bootstrap.php';
        }

        $server = $factory->launchServer([
            'bootstrapFile' => $bootstrapFile,
            'host' => 'localhost',
            'preferredPort' => '3000',
        ]);

        // Server is immediately started
        $this->assertTrue(PortChecker::isPortOpen('localhost', $server->getPort()));

        // Test a "stable" URL available via the framework module, that isn't tied to an environment type
        $content = file_get_contents($server->getURL() . 'Security/login');

        // Check that the login form exists on the displayed page
        $this->assertContains('MemberLoginForm_LoginForm', $content);

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
        $this->setExpectedException('LogicException');
        $server->start();
    }

    public function testStopTwiceFails()
    {
        $factory = new ServerFactory(realpath(__DIR__ . '/..'));
        $server = $factory->launchServer([
            'host' => 'localhost',
            'preferredPort' => '3000',
        ]);

        $server->stop();

        // Stop a 2nd fails because the server is already stopped
        $this->setExpectedException('LogicException');
        $server->stop();
    }

    public function testPreferredPortFindsAnOpenPort()
    {
        $factory = new ServerFactory(realpath(__DIR__ . '/..'));
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
