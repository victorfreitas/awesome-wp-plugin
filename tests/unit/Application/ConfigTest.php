<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Application;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Depends;
use Brain\Monkey;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Application\Config;
use Awesome\Domain\Interfaces\ConfigInterface;
use Awesome\Domain\Interfaces\MapInterface;
use Awesome\Infrastructure\Facades\Container;
use Awesome\Infrastructure\Facades\Plugin;
use Awesome\Presentation\Utils\Plugin as UtilsPlugin;

class ConfigTest extends AbstractUnitTestCase
{
    protected readonly ConfigInterface $config;

    protected function setUp(): void
    {
        parent::setUp();

        $container = new Container();
        $container->bind('plugin', UtilsPlugin::class);
        $container->boot();

        $this->config = new Config(pluginFile: \env('plugin.file'));
    }

    #[Test]
    #[TestDox(text: 'Must test the config main requirements')]
    public function configClass(): void
    {
        $reflected = new \ReflectionClass(Config::class);

        $this->assertTrue($reflected->isFinal());
        $this->assertTrue($reflected->implementsInterface(ConfigInterface::class));
        $this->assertTrue($reflected->hasMethod('boot'));
        $this->assertTrue($reflected->getMethod('boot')->isPublic());
        $this->assertTrue($reflected->hasProperty('pluginFile'));
        $this->assertTrue($reflected->getProperty('pluginFile')->isReadOnly());
        $this->assertTrue($reflected->hasProperty('map'));
        $this->assertTrue($reflected->getProperty('map')->isReadOnly());
    }

    #[Test]
    #[TestDox(text: 'Must test the config instance and their interfaces')]
    #[Depends(methodName: 'configClass')]
    public function config(): void
    {
        $reflected = new \ReflectionClass(Config::class);
        $map = $this->createMock(MapInterface::class);
        $map->method('get')->willReturn('foo/bar.php');
        /**
         * Configuration interface.
         *
         * @var ConfigInterface
         */
        $config = $reflected->newInstance(pluginFile: 'foo/bar.php', map: $map);

        $this->assertTrue($reflected->getProperty('pluginFile')->isInitialized($config));
        $this->assertTrue($reflected->getProperty('map')->isInitialized($config));
        $this->assertSame('foo/bar.php', $config->pluginFile());
        $this->assertTrue(
            $reflected->getProperty('map')->getValue($config) instanceof MapInterface
        );
    }

    #[Test]
    #[TestDox(text: 'Must test the config boot method and initial values')]
    #[Depends(methodName: 'config')]
    public function boot(): void
    {
        Monkey\Functions\expect('admin_url')
            ->twice()
            ->with('admin.php?page=' . \env('plugin.slug'))
            ->andReturnFirstArg();

        $config = new Config(pluginFile: \env('plugin.file'));

        $config->boot();

        $this->assertEquals(\env('plugin.title'), $config->get(name: 'plugin.title'));
        $this->assertEquals(\env('plugin.file'), $config->get(name: 'plugin.file'));
        $this->assertEquals(\env('plugin.file'), $config->pluginFile());
        $this->assertEquals(\env('plugin.basename'), $config->get(name: 'plugin.basename'));
        $this->assertEquals(\env('plugin.slug'), $config->get(name: 'plugin.slug'));
        $this->assertEquals(\env('plugin.version'), $config->get(name: 'plugin.version'));
        $this->assertEquals(
            Plugin::adminUrl(page: \env('plugin.slug')),
            $config->get(name: 'plugin.page.url')
        );
        $this->assertEquals(
            'plugin_action_links_' . \env('plugin.basename'),
            $config->get(name: 'plugin.action_links')
        );
    }

    #[Test]
    #[TestDox(text: 'Must test the config set and get methods')]
    #[Depends(methodName: 'config')]
    public function settingAndGetting(): void
    {
        $this->config->set(name: 'plugin.role', value: 'subscription');
        $this->config->set(name: 'plugin.since', value: 2024);
        $this->assertEquals('subscription', $this->config->get(name: 'plugin.role'));
        $this->assertEquals(2024, $this->config->get(name: 'plugin.since'));
    }

    #[Test]
    #[TestDox(text: 'Must test the config has method')]
    #[Depends(methodName: 'config')]
    public function has(): void
    {
        $this->config->set(name: 'foo', value: 'bar');
        $this->assertTrue($this->config->has(name: 'foo'));
        $this->assertFalse($this->config->has(name: 'baz'));
    }

    #[Test]
    #[TestDox(text: 'Must test the config pathFromRoot method')]
    #[Depends(methodName: 'config')]
    public function pathFromRoot(): void
    {
        $this->assertNull($this->config->pathFromRoot(name: 'unknown'));
        $this->assertNotEmpty($this->config->pathFromRoot(name: 'controllers'));
    }

    #[Test]
    #[TestDox(text: 'Must test the config fromRoot method')]
    #[Depends(methodName: 'config')]
    public function fromRoot(): void
    {
        $this->assertIsArray($this->config->fromRoot(name: 'controllers'));
        $this->assertNull($this->config->fromRoot(name: 'unknown'));
    }

    #[Test]
    #[TestDox(text: 'Must test the config pluginFile method')]
    #[Depends(methodName: 'config')]
    public function pluginFile(): void
    {
        $this->assertEquals(\env('plugin.file'), $this->config->pluginFile());
    }

    #[Test]
    #[TestDox(text: 'Must test the config rootPath method')]
    #[Depends(methodName: 'config')]
    public function rootPath(): void
    {
        $this->assertEquals(
            \plugin_dir_path($this->config->pluginFile()),
            $this->config->rootPath()
        );
    }

    #[Test]
    #[TestDox(text: 'Must test the config version method')]
    #[Depends(methodName: 'config')]
    public function version(): void
    {
        $this->config->set(name: 'plugin.version', value: '1.0.0');
        $this->assertEquals('1.0.0', $this->config->version());
    }

    #[Test]
    #[TestDox(text: 'Must test the config external method')]
    #[Depends(methodName: 'config')]
    public function external(): void
    {
        $this->assertEquals(PHP_INT_MAX, $this->config->external('PHP_INT_MAX'));
        $this->assertEquals(DIRECTORY_SEPARATOR, $this->config->external('DIRECTORY_SEPARATOR'));
        $this->assertGreaterThanOrEqual('8.3', $this->config->external('PHP_VERSION'));
        $this->assertEquals('default', $this->config->external('UNKNOWN_NAME', 'default'));
    }

    #[Test]
    #[TestDox(text: 'Must test the config isExternal method')]
    #[Depends(methodName: 'config')]
    public function isExternal(): void
    {
        $this->assertTrue($this->config->isExternal('PHP_VERSION'));
        $this->assertTrue($this->config->isExternal('PHP_INT_MAX'));
        $this->assertFalse($this->config->isExternal('UNKNOWN_NAME'));
    }
}
