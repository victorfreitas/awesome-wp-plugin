<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Application;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Application\Kernel;
use Awesome\Domain\Interfaces\AppInterface;
use Awesome\Domain\Interfaces\ConfigInterface;
use Awesome\Domain\Interfaces\ContainerInterface;
use Awesome\Domain\Interfaces\LoggerInterface;

class KernelTest extends AbstractUnitTestCase
{
    #[Test]
    #[TestDox('Must test the kernel instantiation and run method')]
    public function instantiateAndRun(): void
    {
        $app = $this->createMock(AppInterface::class);
        $config = $this->createMock(ConfigInterface::class);
        $container = $this->createMock(ContainerInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $container->expects($this->exactly(2))
            ->method('boot');
        $config->expects($this->exactly(2))
            ->method('boot');
        $app->expects($this->exactly(2))
            ->method('boot');
        $logger->expects($this->once())
            ->method('error');

        $kernel = new Kernel(app: $app, config: $config, container: $container, logger: $logger);
        $this->assertTrue($kernel->run());

        $app->method('boot')
            ->willThrowException(new \Exception('Error'));

        $kernel = new Kernel(app: $app, config: $config, container: $container, logger: $logger);
        $this->assertFalse($kernel->run());
    }

    #[Test]
    #[TestDox('Must test the kernel static boot method')]
    public function boot(): void
    {
        $app = $this->createMock(AppInterface::class);
        $config = $this->createMock(ConfigInterface::class);
        $container = $this->createMock(ContainerInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $container->expects($this->exactly(2))
            ->method('bind');
        $container->expects($this->once())
            ->method('boot');
        $config->expects($this->once())
            ->method('boot');
        $app->expects($this->once())
            ->method('boot');
        $logger->expects($this->never())
            ->method('error');

        $result = Kernel::boot(
            context: ['plugin.file' => 'bar/baz.php'],
            createArgs: static fn () => [$app, $config, $container, $logger]
        );
        $this->assertTrue($result);
    }
}
