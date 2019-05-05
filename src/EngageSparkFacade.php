<?php

namespace LBHurtado\EngageSpark;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LBHurtado\EngageSpark\Skeleton\SkeletonClass
 */
class EngageSparkFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'engagespark';
    }
}
