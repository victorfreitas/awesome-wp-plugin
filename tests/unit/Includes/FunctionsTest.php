<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Includes;

use Awesome\Domain\Interfaces\ConfigInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Depends;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Domain\Interfaces\ViewInterface;
use Awesome\Infrastructure\Facades\Container;

use function Awesome\config;
use function Awesome\createView;
use function Awesome\env;

class FunctionsTest extends AbstractUnitTestCase
{
    #[Test]
    #[TestDox(text: 'Must test the config function')]
    public function functions(): void
    {
        $this->assertTrue(function_exists('Awesome\config'));
        $this->assertTrue(function_exists('Awesome\createView'));
        $this->assertTrue(function_exists('Awesome\env'));
    }

    #[Test]
    #[TestDox(text: 'Must test the createView function')]
    #[Depends(methodName: 'functions')]
    public function createView(): void
    {
        $view = $this->createMock(ViewInterface::class);

        $view->expects($this->once())
            ->method('render')
            ->willReturn('<h1>View content</h1>');

        $closure = createView($view);
        ob_start();
        $closure();
        $output = ob_get_clean();

        $this->assertSame('<h1>View content</h1>', $output);
    }

    #[Test]
    #[TestDox(text: 'Must test the config function')]
    #[Depends(methodName: 'functions')]
    public function configDefaults(): void
    {
        $container = new Container();
        $config = $this->createMock(ConfigInterface::class);

        $config->expects($this->once())
            ->method('get')
            ->with('app.name', null)
            ->willReturnArgument(1);
        $container->bind('config', static fn () => $config);
        $container->boot();

        $this->assertNull(config(name: 'app.name'));
    }

    #[Test]
    #[TestDox(text: 'Must test the env function')]
    #[Depends(methodName: 'functions')]
    public function envDefaults(): void
    {
        $this->assertSame('foo', env(name: 'UNKNOWN_ENV', defaults: 'foo'));
        $this->assertTrue(env(name: 'UNKNOWN_ENV', defaults: 'true'));
        $this->assertTrue(env(name: 'UNKNOWN_ENV', defaults: 'True'));
        $this->assertTrue(env(name: 'UNKNOWN_ENV', defaults: 'TRUE'));
        $this->assertFalse(env(name: 'UNKNOWN_ENV', defaults: 'false'));
        $this->assertFalse(env(name: 'UNKNOWN_ENV', defaults: 'False'));
        $this->assertFalse(env(name: 'UNKNOWN_ENV', defaults: 'FALSE'));
        $this->assertNull(env(name: 'UNKNOWN_ENV', defaults: 'null'));
        $this->assertNull(env(name: 'UNKNOWN_ENV', defaults: 'Null'));
        $this->assertNull(env(name: 'UNKNOWN_ENV', defaults: 'NULL'));
    }
}
