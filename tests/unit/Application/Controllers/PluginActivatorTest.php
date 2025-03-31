<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Application\Controllers;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Brain\Monkey\Actions;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Application\Controllers\PluginActivator;
use Awesome\Domain\Interfaces\ActionInterface;
use Awesome\Domain\Interfaces\ConfigInterface;
use Awesome\Domain\Interfaces\ControllerInterface;
use Awesome\Domain\Interfaces\DatabaseManagerInterface;
use Awesome\Infrastructure\Attributes\On;
use Awesome\Infrastructure\Facades\Container;

final class PluginActivatorTest extends AbstractUnitTestCase
{
    #[Test]
    #[TestDox('Must validate the plugin activator class')]
    public function pluginActivatorClass(): void
    {
        $reflected = new \ReflectionClass(PluginActivator::class);

        $this->assertTrue($reflected->isFinal());
        $this->assertTrue($reflected->isReadOnly());
        $this->assertTrue($reflected->implementsInterface(ControllerInterface::class));
    }

    #[Test]
    #[TestDox('Must validate the activate method')]
    #[Depends('pluginActivatorClass')]
    public function activate(): void
    {
        $config = $this->createMock(ConfigInterface::class);
        $databaseManager = $this->createMock(DatabaseManagerInterface::class);
        $action = $this->createMock(ActionInterface::class);

        $config->expects($this->once())
            ->method('fromRoot')
            ->with($this->equalTo('queries'))
            ->willReturn('query');

        $config->expects($this->once())
            ->method('get')
            ->with('plugin.file', null)
            ->willReturn(env('plugin.file'));

        $databaseManager->expects($this->once())
            ->method('createTable')
            ->with($this->equalTo('query'))
            ->willReturn(['created']);

        $action->expects($this->once())
            ->method('registerActivation')
            ->willReturnCallback(
                static function (string $file, \Closure $callback) use ($action): ActionInterface {
                    \register_activation_hook($file, $callback);

                    return $action;
                }
            );

        $container = new Container();

        $container->bind(accessor: 'config', concrete: static fn () => $config);
        $container->bind(accessor: 'database.manager', concrete: static fn () => $databaseManager);
        $container->bind(accessor: 'action', concrete: static fn () => $action);
        $container->boot();

        $reflected = new \ReflectionClass(PluginActivator::class);
        $method = $reflected->getMethod('activate');

        $this->assertTrue($method->isPublic());
        $this->assertTrue($method->hasReturnType());
        $this->assertEquals('void', $method->getReturnType()->getName());

        $attributes = $method->getAttributes(On::class, \ReflectionAttribute::IS_INSTANCEOF);

        $this->assertCount(1, $attributes);

        $hookArguments = $attributes[0]->getArguments();

        $this->assertCount(1, $hookArguments);
        $this->assertTrue(isset($hookArguments['event']));
        $this->assertInstanceOf(\BackedEnum::class, $hookArguments['event']);

        $hook = $attributes[0]->newInstance();
        $instance = $reflected->newInstance();
        $action = 'activate_' . env('plugin.basename');

        Actions\expectAdded($action)
            ->once();

        Actions\expectDone($action)
            ->once()
            ->whenHappen($method->getClosure($instance));

        $hook->add(\Closure::fromCallable('__return_null'));

        \do_action($action);
    }

    #[Test]
    #[TestDox('Must validate the deactivate method')]
    #[Depends('pluginActivatorClass')]
    public function deactivate(): void
    {
        $config = $this->createMock(ConfigInterface::class);
        $action = $this->createMock(ActionInterface::class);

        $config->expects($this->once())
            ->method('get')
            ->with('plugin.file', null)
            ->willReturn(env('plugin.file'));

        $action->expects($this->once())
            ->method('registerDeactivation')
            ->willReturnCallback(
                static function (string $file, \Closure $callback) use ($action): ActionInterface {
                    \register_deactivation_hook($file, $callback);

                    return $action;
                }
            );

        $container = new Container();

        $container->bind(accessor: 'config', concrete: static fn () => $config);
        $container->bind(accessor: 'action', concrete: static fn () => $action);
        $container->boot();

        $reflected = new \ReflectionClass(PluginActivator::class);
        $method = $reflected->getMethod('deactivate');

        $this->assertTrue($method->isPublic());
        $this->assertTrue($method->hasReturnType());
        $this->assertEquals('void', $method->getReturnType()->getName());

        $attributes = $method->getAttributes(On::class, \ReflectionAttribute::IS_INSTANCEOF);

        $this->assertCount(1, $attributes);

        $hookArguments = $attributes[0]->getArguments();

        $this->assertCount(1, $hookArguments);
        $this->assertTrue(isset($hookArguments['event']));
        $this->assertInstanceOf(\BackedEnum::class, $hookArguments['event']);

        $hook = $attributes[0]->newInstance();
        $instance = $reflected->newInstance();
        $action = 'deactivate_' . env('plugin.basename');

        Actions\expectAdded($action)
            ->once();

        Actions\expectDone($action)
            ->once()
            ->whenHappen($method->getClosure($instance));

        $hook->add(\Closure::fromCallable('__return_null'));

        \do_action($action);
    }
}
