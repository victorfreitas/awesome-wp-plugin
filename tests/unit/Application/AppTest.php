<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Application;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Depends;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Domain\Interfaces\ConfigInterface;
use Awesome\Application\App;
use Awesome\Domain\Interfaces\AppInterface;
use Awesome\Domain\Interfaces\ControllerInterface;
use Awesome\Domain\Interfaces\HookRegistrarInterface;
use Awesome\Domain\Interfaces\LoggerInterface;
use Awesome\Infrastructure\Facades\Container;

class AppTest extends AbstractUnitTestCase
{
    private function app(string $envValue = 'test'): AppInterface
    {
        $config = $this->createMock(ConfigInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $config->method('external')->willReturn($envValue);

        return new App(config: $config, logger: $logger);
    }

    #[Test]
    #[TestDox(text: 'Must test the app boot method')]
    #[Depends(methodName: 'mainPropsAndMethods')]
    public function boot(): void
    {
        $config = $this->createMock(ConfigInterface::class);
        $hookRegistrar = $this->createMock(HookRegistrarInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $controller = $this->createStub(ControllerInterface::class);
        $container = new Container();

        $hookRegistrar->expects($this->once())
            ->method('run');
        $config->expects($this->once())
            ->method('fromRoot')
            ->willReturn([$controller]);
        $container->bind(accessor: 'hook.registrar', concrete: static fn () => $hookRegistrar)
            ->boot();

        $app = new App(config: $config, logger: $logger);
        $app->boot();
    }

    #[Test]
    #[TestDox(text: 'Must test the app main props and methods')]
    public function mainPropsAndMethods(): void
    {
        $reflected = new \ReflectionClass(App::class);

        $this->assertTrue($reflected->isFinal());
        $this->assertTrue($reflected->implementsInterface(AppInterface::class));
        $this->assertTrue($reflected->hasMethod('boot'));
        $this->assertTrue($reflected->getMethod('boot')->isPublic());
        $this->assertTrue($reflected->hasProperty('config'));
        $this->assertTrue($reflected->getProperty('config')->isPrivate());
        $this->assertTrue($reflected->getProperty('config')->isReadOnly());
        $this->assertTrue($reflected->getMethod('config')->isPublic());
        $this->assertTrue($reflected->getMethod('config')->hasReturnType());
        $this->assertTrue($reflected->hasProperty('logger'));
        $this->assertTrue($reflected->getProperty('logger')->isPrivate());
        $this->assertTrue($reflected->getProperty('logger')->isReadOnly());
        $this->assertTrue($reflected->getMethod('logger')->isPublic());
        $this->assertTrue($reflected->getMethod('logger')->hasReturnType());
    }

    #[Test]
    #[TestDox(text: 'Must test the app boot method with wrong controller')]
    public function wrongController(): void
    {
        $config = $this->createMock(ConfigInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $wrongController = $this->createStub(ConfigInterface::class);

        $config->expects($this->once())
            ->method('fromRoot')
            ->willReturn([$wrongController]);
        $logger->expects($this->once())
            ->method('critical');

        $app = new App(config: $config, logger: $logger);
        $app->boot();
    }

    #[Test]
    #[TestDox(text: 'Must test the logger method')]
    public function logger(): void
    {
        $this->assertInstanceOf(LoggerInterface::class, $this->app()->logger());
    }

    #[Test]
    #[TestDox(text: 'Must test the app isProduction method')]
    public function isProduction(): void
    {
        $this->assertTrue($this->app('production')->isProduction());
    }

    #[Test]
    #[TestDox(text: 'Must test the app isDevelopment method')]
    public function isDevelopment(): void
    {
        $this->assertTrue($this->app('development')->isDevelopment());
    }

    #[Test]
    #[TestDox(text: 'Must test the app isStaging method')]
    public function isStaging(): void
    {
        $this->assertTrue($this->app('staging')->isStaging());
    }

    #[Test]
    #[TestDox(text: 'Must test the app isTest method')]
    public function isTest(): void
    {
        $this->assertTrue($this->app('test')->isTest());
    }
}
