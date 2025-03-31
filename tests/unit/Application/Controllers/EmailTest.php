<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Application\Controllers;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Brain\Monkey\Actions;
use Awesome\Application\Controllers\Email;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Domain\Interfaces\ControllerInterface;
use Awesome\Infrastructure\Attributes\Action;
use PHPUnit\Framework\Attributes\Depends;

class EmailTest extends AbstractUnitTestCase
{
    #[Test]
    #[TestDox('Must validate the class')]
    public function emailClass(): void
    {
        $reflected = new \ReflectionClass(Email::class);

        $this->assertTrue($reflected->isFinal());
        $this->assertTrue($reflected->isReadOnly());
        $this->assertTrue($reflected->implementsInterface(ControllerInterface::class));
    }

    #[Test]
    #[TestDox('Must validate the handleMailSuccess method')]
    #[Depends('emailClass')]
    public function handleMailSuccess(): void
    {
        Actions\expectAdded('wp_mail_succeeded')
            ->once();

        $reflected = new \ReflectionClass(Email::class);
        $method = $reflected->getMethod('handleMailSuccess');

        $this->assertTrue($method->isPublic());
        $this->assertTrue($method->hasReturnType());
        $this->assertSame('void', $method->getReturnType()->getName());

        $attributes = $method->getAttributes(Action::class, \ReflectionAttribute::IS_INSTANCEOF);

        $this->assertCount(1, $attributes);

        $hook = $attributes[0]->newInstance();
        $instance = $reflected->newInstance();

        $hook->add(\Closure::fromCallable('__return_null'));

        Actions\expectDone('wp_mail_succeeded')
            ->once()
            ->with(['data'])
            ->whenHappen($method->getClosure($instance));

        \do_action('wp_mail_succeeded', ['data']);
    }

    #[Test]
    #[TestDox('Must validate the handleMailError method')]
    #[Depends('emailClass')]
    public function handleMailError(): void
    {
        Actions\expectAdded('wp_mail_failed')
            ->once();

        $reflected = new \ReflectionClass(Email::class);
        $method = $reflected->getMethod('handleMailError');

        $this->assertTrue($method->isPublic());
        $this->assertTrue($method->hasReturnType());
        $this->assertSame('void', $method->getReturnType()->getName());

        $attributes = $method->getAttributes(Action::class, \ReflectionAttribute::IS_INSTANCEOF);

        $this->assertCount(1, $attributes);

        $hook = $attributes[0]->newInstance();
        $instance = $reflected->newInstance();

        $hook->add(\Closure::fromCallable('__return_null'));

        Actions\expectDone('wp_mail_failed')
            ->once()
            ->with(['error'])
            ->whenHappen($method->getClosure($instance));

        \do_action('wp_mail_failed', ['error']);
    }
}
