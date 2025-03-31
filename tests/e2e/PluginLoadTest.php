<?php

/**
 * Plugin load test.
 *
 * @package Awesome\Tests\E2e
 * @since   1.0.0
 */

declare(strict_types=1);

namespace Awesome\Tests\E2e;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Depends;
use Awesome\Tests\Shared\AbstractDatabaseTestCase;
use Awesome\Tests\Shared\Util;
use Awesome\Infrastructure\Facades\App;
use Awesome\Domain\Interfaces\ControllerInterface;
use Awesome\Tests\Shared\WpdbInterface;

use function Awesome\config;

// @phpcs:disable WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_putenv

class PluginLoadTest extends AbstractDatabaseTestCase
{
    protected function setUp(): void
    {
        putenv('WP_DEBUG=true');
        putenv('WP_DEBUG_LOG=true');
        putenv('WP_CONTENT_DIR=' . ABSPATH . '/.cache');

        parent::setUp();
        parent::setupExtraFunctions();
        Util::setupPluginBoot();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        putenv('WP_DEBUG');
        putenv('WP_DEBUG_LOG');
        putenv('WP_CONTENT_DIR');
    }

    #[Test]
    #[TestDox('Must test the plugin after loader via setUp method')]
    public function afterPluginLoad(): void
    {
        $this->assertSame('default', config('non_existent_config', 'default'));
        $this->assertSame(\env('plugin.version'), config('plugin.version'));
        $this->assertSame(\env('plugin.title'), config('plugin.title'));
        $this->assertSame(\env('plugin.slug'), config('plugin.slug'));
        $this->assertSame(\env('plugin.basename'), config('plugin.basename'));
        $this->assertSame(\env('plugin.file'), config('plugin.file'));
        $this->assertTrue(\has_action('wp_mail_succeeded'));
        $this->assertTrue(\has_action('activate_' . config('plugin.basename')));
        $this->assertTrue(\has_action('deactivate_' . config('plugin.basename')));
        $this->assertTrue(\has_filter('admin_body_class'));
        $this->assertTrue(\has_filter('plugin_action_links_' . config('plugin.basename')));
        $this->assertTrue(\has_action('admin_enqueue_scripts'));
        $this->assertTrue(\has_action('admin_menu'));
    }

    #[Test]
    #[TestDox('Must test the controllers instances of ControllerInterface')]
    public function controllersIsInstanceOfControllerInterface(): void
    {
        $controllers = App::config()->fromRoot('controllers');

        $this->assertIsArray($controllers);
        $this->assertNotEmpty($controllers);

        foreach ($controllers as $controller) {
            $reflected = new \ReflectionClass($controller);

            $this->assertTrue($reflected->implementsInterface(ControllerInterface::class));
        }
    }

    #[Test]
    #[TestDox('Must test the database table query')]
    public function dbQueryCheck(): string
    {
        global $wpdb;

        $wpdb = $this->getMockBuilder(WpdbInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wpdb->expects($this->once())
            ->method('get_charset_collate')
            ->willReturn('default character set utf8mb4 collate=utf8mb4_unicode_ci');

        $wpdb->expects($this->once())
            ->method('__get')
            ->with('prefix')
            ->willReturn('wp_');

        $query = App::config()->fromRoot('queries');

        $this->assertIsString($query);
        $this->assertNotEmpty($query);
        $this->assertTrue(
            \str_starts_with($query, 'CREATE TABLE IF NOT EXISTS `wp_awesome`')
        );

        $wpdb = null;

        return $query;
    }

    #[Test]
    #[TestDox('Must test the database query execution if db connection is available')]
    #[Depends('dbQueryCheck')]
    public function dbQueryExecute(string $query): void
    {
        $conn = $this->connection();

        if ($conn) {
            $conn->prepare($query)->execute();

            $stmt = $conn->prepare('describe wp_awesome;');

            $this->assertTrue($stmt->execute());

            $conn->prepare('drop table wp_awesome;')->execute();

            $this->assertSame(11, $stmt->rowCount());
            $this->expectException(\PDOException::class);
            $this->expectExceptionCode('42S02');

            $conn->prepare('describe wp_awesome;')->execute();
        }

        // If the connection is not PDO just pass the test.
        $this->assertTrue(true);
    }
}
