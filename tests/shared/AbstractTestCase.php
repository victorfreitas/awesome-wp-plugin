<?php

declare(strict_types=1);

namespace Awesome\Tests\Shared;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    protected function setupExtraFunctions(): void
    {
        Monkey\Functions\stubTranslationFunctions();
        Monkey\Functions\stubEscapeFunctions();
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}
