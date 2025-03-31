<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit;

use Brain\Monkey;
use Awesome\Tests\Shared\AbstractTestCase;

abstract class AbstractUnitTestCase extends AbstractTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
        parent::setupExtraFunctions();
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}
