<?php

namespace Bolt\Extension\Mborn319\Formstack\Tests;

use Bolt\Tests\BoltUnitTest;
use Bolt\Extension\Mborn319\Formstack\FormstackExtension;

/**
 * FormstackExtension testing class.
 *
 * @author Michael Born <mborn319@gmail.com>
 */
class ExtensionTest extends BoltUnitTest
{
    /**
     * Ensure that the Formstack extension loads correctly.
     */
    public function testExtensionBasics()
    {
        $app = $this->getApp(false);
        $extension = new FormstackExtension($app);

        $name = $extension->getName();
        $this->assertSame($name, 'Formstack');
        $this->assertInstanceOf('\Bolt\Extension\ExtensionInterface', $extension);
    }

    public function testExtensionComposerJson()
    {
        $composerJson = json_decode(file_get_contents(dirname(__DIR__) . '/composer.json'), true);

        // Check that the 'bolt-class' key correctly matches an existing class
        $this->assertArrayHasKey('bolt-class', $composerJson['extra']);
        $this->assertTrue(class_exists($composerJson['extra']['bolt-class']));

        // Check that the 'bolt-assets' key points to the correct directory
        $this->assertArrayHasKey('bolt-assets', $composerJson['extra']);
        $this->assertSame('web', $composerJson['extra']['bolt-assets']);
    }
}
