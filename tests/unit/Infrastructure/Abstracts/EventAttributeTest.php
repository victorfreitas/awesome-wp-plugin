<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Infrastructure\Abstracts;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Depends;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Domain\Interfaces\HookAttributeInterface;
use Awesome\Domain\Interfaces\InvalidArgumentExceptionInterface;
use Awesome\Infrastructure\Abstracts\EventAttribute;
use Awesome\Infrastructure\Attributes\On;
use Awesome\Tests\Shared\GenericEnum;

class EventAttributeTest extends AbstractUnitTestCase
{
    #[Test]
    #[TestDox('Must validate the abstract event attribute class')]
    public function eventAttributeClass(): void
    {
        $reflected = new \ReflectionClass(On::class);

        $this->assertFalse($reflected->isAbstract());
        $this->assertTrue($reflected->isFinal());
        $this->assertFalse($reflected->isReadOnly());
        $this->assertTrue($reflected->implementsInterface(HookAttributeInterface::class));
        $this->assertTrue($reflected->isSubclassOf(EventAttribute::class));
        $this->assertTrue($reflected->hasMethod('add'));
        $this->assertTrue($reflected->hasMethod('registerActivation'));
        $this->assertTrue($reflected->hasMethod('registerDeactivation'));
        $this->assertTrue($reflected->hasMethod('throwInvalidEventNameNotice'));
        $this->assertTrue($reflected->getMethod('registerActivation')->isProtected());
        $this->assertTrue($reflected->getMethod('registerDeactivation')->isProtected());
        $this->assertTrue($reflected->getMethod('throwInvalidEventNameNotice')->isProtected());
    }

    #[Test]
    #[TestDox('Must validate the add method')]
    #[Depends('eventAttributeClass')]
    public function add(): void
    {
        $reflected = new \ReflectionClass(On::class);
        $method = $reflected->getMethod('add');

        $this->assertTrue($method->isFinal());
        $this->assertTrue($method->isPublic());

        $parameters = $method->getParameters();

        $this->assertCount(1, $parameters);
        $this->assertFalse($parameters[0]->isOptional());
        $this->assertSame('Closure', $parameters[0]->getType()->getName());

        $instance = $reflected->newInstance(event: GenericEnum::Unknown);

        $this->expectException(InvalidArgumentExceptionInterface::class);
        $this->expectExceptionMessage(
            'Invalid attribute event name: ' . GenericEnum::Unknown->value
        );

        $instance->add(\Closure::fromCallable('__return_null'));
    }
}
