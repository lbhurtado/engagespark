<?php

namespace LBHurtado\EngageSpark\Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Schema\Blueprint;
use LBHurtado\EngageSpark\EngageSparkServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
	protected $testUser;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
        $this->testUser = User::first();
    }

    /**
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [EngageSparkServiceProvider::class];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $this->initializeDirectory($this->getTempDirectory());

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => $this->getTempDirectory().'/database.sqlite',
            'prefix' => '',
        ]);
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('engagespark.api_key', 'b3867ab758b3fea05a4f40124e0e4f52c399ed12');
        $app['config']->set('engagespark.org_id', '7858');
    }


    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        file_put_contents($this->getTempDirectory().'/database.sqlite', null);

        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile');
        });
        
        $this->createUser(['mobile' => '+639173011987']);
    }

    /**
     * Initialize the directory.
     *
     * @param string $directory
     */
    protected function initializeDirectory($directory)
    {
        if (File::isDirectory($directory)) {
            File::deleteDirectory($directory);
        }

        if (! File::exists($directory)) {
            File::makeDirectory($directory);
        }
    }

    /**
     * @param  string $suffix
     * @return string
     */
    public function getTempDirectory($suffix = '')
    {
        return __DIR__.'/temp'.($suffix == '' ? '' : '/'.$suffix);
    }

    /**
     * @param  array  $attributes
     * @return \NotificationChannels\WebPush\Test\User
     */
    public function createUser(array $attributes)
    {
        return User::create($attributes);
    }

    // /**
    //  * @param  \NotificationChannels\WebPush\Test\User $user
    //  * @param  string $endpoint
    //  * @return \NotificationChannels\WebPush\PushSubscription
    //  */
    // public function createSubscription($user, $endpoint = 'endpoint')
    // {
    //     $sub = $this->app[PushSubscription::class]->forceFill([
    //         'user_id' => $user->id,
    //         'endpoint' => $endpoint,
    //         'public_key' => 'key',
    //         'auth_token' => 'token',
    //     ]);
    //     $sub->save();
    //     return $sub;
    // }

    protected function seeInConsoleOutput($expectedText)
    {
        $consoleOutput = $this->app[Kernel::class]->output();
        $this->assertContains($expectedText, $consoleOutput, "Did not see `{$expectedText}` in console output: `$consoleOutput`");
    }
}
