<?php

use Orchestra\Testbench\TestCase;

use Fenos\Notifynder\Models\Notification;
use Fenos\Tests\Models\User;
use Fenos\Notifynder\Facades\Notifynder;
use Fenos\Notifynder\NotifynderServiceProvider;

/**
 * Class TestCaseDB
 */
abstract class TestCaseDB extends TestCase {

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            NotifynderServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Notifynder' => Notifynder::class
        ];
    }

    /**
     * Setup the DB before each test.
     */
    public function setUp()
    {
        parent::setUp();

        app('db')->beginTransaction();

        $this->migrate(realpath(__DIR__.'/../src/migrations'));
        $this->migrate(realpath(__DIR__.'/migrations'));

        // Set up the User Test Model
        app('config')->set('notifynder.notification_model', Notification::class);
        app('config')->set('notifynder.model', User::class);

    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', array(
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ));
    }

    /**
     * Rollback transactions after each test.
     */
    public function tearDown()
    {
        app('db')->rollback();
    }

    /**
     * Get application timezone.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return string|null
     */
    protected function getApplicationTimezone($app)
    {
        return 'UTC';
    }

    /**
     * Migrate the migrations files
     *
     * @param string $path
     */
    private function migrate($path)
    {
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => $path
        ]);
    }
}