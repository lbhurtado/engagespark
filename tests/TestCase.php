<?php

namespace LBHurtado\EngageSpark\Tests;

use LBHurtado\EngageSpark\EngageSparkServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [EngageSparkServiceProvider::class];
    }
}
