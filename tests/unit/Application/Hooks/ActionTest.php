<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Application\Hooks;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Brain\Monkey;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Application\Hooks\Action;
use Awesome\Domain\Interfaces\ActionInterface;

class ActionTest extends AbstractUnitTestCase
{
    private readonly ActionInterface $action;

    protected function setUp(): void
    {
        parent::setUp();

        $this->action = new Action();
    }

    #[Test]
    #[TestDox('Must add a new action')]
    public function addAction(): void
    {
        Monkey\Actions\expectAdded('add')->once();

        $this->action->add(hook: 'add', callback: '__return_null', priority: 3);

        $this->assertSame(3, $this->action->has('add', '__return_null'));
    }

    #[Test]
    #[TestDox('Must remove an action')]
    public function removeAction(): void
    {
        Monkey\Actions\expectAdded('remove')->once();
        Monkey\Actions\expectRemoved('remove')->once();

        $this->action->add(hook: 'remove', callback: '__return_null', priority: 12);

        $this->assertSame(12, $this->action->has('remove', '__return_null'));

        $this->action->remove(hook: 'remove', callback: '__return_null', priority: 12);

        $this->assertFalse($this->action->has('remove', '__return_null'));
    }

    #[Test]
    #[TestDox('Must remove all actions')]
    public function removeAllActions(): void
    {
        Monkey\Actions\expectAdded('remove')->twice();
        Monkey\Actions\expectRemoved('remove')->twice();

        $this->action->add(hook: 'remove', callback: '__return_true', priority: 10);
        $this->action->add(hook: 'remove', callback: '__return_false', priority: 12);

        $this->assertSame(10, $this->action->has('remove', '__return_true'));
        $this->assertSame(12, $this->action->has('remove', '__return_false'));

        $this->action->removeAll(hook: 'remove', priority: 10);

        $this->assertFalse($this->action->has('remove', '__return_true'));
        $this->assertSame(12, $this->action->has('remove', '__return_false'));

        $this->action->removeAll(hook: 'remove', priority: 12);

        $this->assertFalse($this->action->has('remove', '__return_false'));
    }

    #[Test]
    #[TestDox('Must return the current action')]
    public function currentAction(): void
    {
        $callback = function (): void {
            if ($this->action->current() !== 'admin_init') {
                throw new \RuntimeException('Invalid current action');
            }

            echo 'Dummy Text';
        };

        $this->expectOutputString('Dummy Text');

        Monkey\Actions\expectDone('admin_init')->once()->whenHappen($callback);

        $this->action->emit('admin_init');
    }

    #[Test]
    #[TestDox('Must emit and did an action')]
    public function emitDidAction(): void
    {
        $this->action->emit(hook: 'something');
        $this->action->emit(hook: 'something_args', args: 'arg1');
        $this->action->emit(hook: 'something_args', args: 'arg1', args2: 'arg2');
        $this->action->emitRefArray(hook: 'something_ref', args: ['arg1', 'arg2']);

        $this->assertSame(1, $this->action->did('something'));
        $this->assertSame(2, $this->action->did('something_args'));
        $this->assertSame(1, $this->action->did('something_ref'));
    }

    #[Test]
    #[TestDox('Must register an activation hook')]
    public function registerActivation(): void
    {
        Monkey\Actions\expectAdded('activate_foo/bar.php')->once();

        $callback = function (): void {
            $this->assertSame('activate_foo/bar.php', $this->action->current());

            echo 'Activated';
        };

        $this->expectOutputString('Activated');

        Monkey\Actions\expectDone('activate_foo/bar.php')->once()->whenHappen($callback);

        $this->action->registerActivation(file: 'foo/bar.php', callback: $callback);
        $this->action->emit('activate_foo/bar.php');
    }

    #[Test]
    #[TestDox('Must register a deactivation hook')]
    public function registerDeactivation(): void
    {
        Monkey\Actions\expectAdded('deactivate_foo/bar.php')->once();

        $callback = function (): void {
            $this->assertSame('deactivate_foo/bar.php', $this->action->current());

            echo 'Deactivated';
        };

        $this->expectOutputString('Deactivated');

        Monkey\Actions\expectDone('deactivate_foo/bar.php')->once()->whenHappen($callback);

        $this->action->registerDeactivation(file: 'foo/bar.php', callback: $callback);
        $this->action->emit('deactivate_foo/bar.php');
    }

    #[Test]
    #[TestDox('Must load the textdomain')]
    public function loadTextdomain(): void
    {
        Monkey\Actions\expectAdded('unload_textdomain')->once();
        Monkey\Actions\expectAdded('load_textdomain')->once();
        Monkey\Functions\expect('unload_textdomain')
            ->once()
            ->with(env('plugin.slug'))
            ->andReturnUsing(function (string $domain, bool $reloadable = false): bool {
                $this->action->emit('unload_textdomain', $domain, $reloadable);

                return true;
            });
        Monkey\Functions\expect('load_plugin_textdomain')
            ->once()
            ->with(
                env('plugin.slug'),
                false,
                \plugin_basename(\dirname(env('plugin.file'))) . '/i18n/languages'
            )
            ->andReturnUsing(function (string $domain): bool {
                $this->action->emit('load_textdomain', $domain, $domain . '-en_US.mo');

                return true;
            });

        $domain = env('plugin.slug');
        $handler = function (): void {
            $loaded = $this->action->loadTextdomain(file: env('plugin.file'));

            if (! $loaded) {
                throw new \RuntimeException('Textdomain not loaded');
            }

            echo 'true';
        };

        $this->expectOutputString('true');

        Monkey\Actions\expectDone('init')->once()->whenHappen($handler);
        Monkey\Actions\expectDone('unload_textdomain')->once()->with($domain, false);
        Monkey\Actions\expectDone('load_textdomain')->once()->with($domain, "{$domain}-en_US.mo");

        $this->action->add(hook: 'unload_textdomain', callback: '__return_true');
        $this->action->add(hook: 'load_textdomain', callback: '__return_true');

        $this->action->emit('init');
    }
}
