<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Application\Hooks;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Brain\Monkey\Filters;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Application\Hooks\Filter;
use Awesome\Domain\Interfaces\FilterInterface;

class FilterTest extends AbstractUnitTestCase
{
    private readonly FilterInterface $filter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filter = new Filter();
    }

    #[Test]
    #[TestDox('Must add a new filter')]
    public function addFilter(): void
    {
        Filters\expectAdded('add')->once();

        $this->filter->add(hook: 'add', callback: '__return_null', priority: 3);

        $this->assertSame(3, $this->filter->has('add', '__return_null'));
    }

    #[Test]
    #[TestDox('Must remove a filter')]
    public function removeFilter(): void
    {
        Filters\expectAdded('body_class')->once();
        Filters\expectRemoved('body_class')->once();

        $this->filter->add(hook: 'body_class', callback: '__return_null', priority: 3);

        $this->assertSame(3, $this->filter->has('body_class', '__return_null'));

        $this->filter->remove(hook: 'body_class', callback: '__return_null', priority: 3);

        $this->assertFalse($this->filter->has('body_class', '__return_null'));
    }

    #[Test]
    #[TestDox('Must remove all filters')]
    public function removeAllFilters(): void
    {
        Filters\expectAdded('locale')->twice();
        Filters\expectRemoved('locale')->twice();

        $this->filter->add(hook: 'locale', callback: '__return_true', priority: 1);
        $this->filter->add(hook: 'locale', callback: '__return_false', priority: 7);

        $this->assertSame(1, $this->filter->has('locale', '__return_true'));
        $this->assertSame(7, $this->filter->has('locale', '__return_false'));

        $this->filter->removeAll(hook: 'locale', priority: 1);

        $this->assertFalse($this->filter->has('locale', '__return_true'));
        $this->assertSame(7, $this->filter->has('locale', '__return_false'));

        $this->filter->removeAll(hook: 'locale', priority: 7);

        $this->assertFalse($this->filter->has('locale', '__return_false'));
    }

    #[Test]
    #[TestDox('Must return the current filter')]
    public function applyFilter(): void
    {
        Filters\expectApplied('something')
            ->once()
            ->with('Foo')
            ->andReturn('Bar');

        Filters\expectApplied('something_else')
            ->twice()
            ->with(\Mockery::anyOf('Bar', 'Baz'))
            ->andReturn('baz', 'bar');

        Filters\expectApplied('some_closure')
            ->once()
            ->with(['bar' => 'Dummy Text'])
            ->andReturnUsing(static function (array $args): array {
                return [...$args, 'baz' => 'Some Text'];
            });

        $somethingBar = $this->filter->apply(hook: 'something', value: 'Foo');
        $somethingElseBaz = $this->filter->apply(hook: 'something_else', value: 'Bar');
        $somethingElseBar = $this->filter->apply(hook: 'something_else', value: 'Baz');
        $someBar = $this->filter->apply(hook: 'some_closure', value: ['bar' => 'Dummy Text']);

        $this->assertSame('Bar', $somethingBar);
        $this->assertSame('baz', $somethingElseBaz);
        $this->assertSame('bar', $somethingElseBar);
        $this->assertSame(['bar' => 'Dummy Text', 'baz' => 'Some Text'], $someBar);
    }

    #[Test]
    #[TestDox('Must validate the current filter')]
    public function currentFilter(): void
    {
        Filters\expectApplied('body')
            ->once()
            ->with('Lorem Ipsum')
            ->andReturnUsing(function (): bool {
                return $this->filter->current() === 'body';
            });

        Filters\expectApplied('title')
            ->once()
            ->with('Dummy Title')
            ->andReturnUsing(function (): bool {
                return $this->filter->current() === 'title';
            });

        $this->assertTrue($this->filter->apply(hook: 'body', value: 'Lorem Ipsum'));
        $this->assertTrue($this->filter->apply(hook: 'title', value: 'Dummy Title'));
    }

    #[Test]
    #[TestDox('Must validate did filter')]
    public function didFilter(): void
    {
        Filters\expectAdded('body_class')
            ->once();

        Filters\expectApplied('body_class')
            ->twice()
            ->with(\Mockery::anyOf('foo', 'bar'))
            ->andReturn('bar', 'baz');

        $this->filter->add(hook: 'body_class', callback: '__return_null', priority: 3);

        $this->assertSame('bar', $this->filter->apply(hook: 'body_class', value: 'foo'));
        $this->assertSame('baz', $this->filter->apply(hook: 'body_class', value: 'bar'));
        $this->assertSame(2, $this->filter->did('body_class'));
    }

    #[Test]
    #[TestDox('Must apply ref array')]
    public function applyRefArrayFilter(): void
    {
        Filters\expectApplied('body_class')
            ->once()
            ->with('foo', ['bar'])
            ->andReturnUsing(static function (string $value, array $values): string {
                return implode(' ', [$value, ...$values, 'baz']);
            });

        $bodyClass = $this->filter->applyRefArray(hook: 'body_class', args: ['foo', ['bar']]);

        $this->assertSame('foo bar baz', $bodyClass);
    }
}
