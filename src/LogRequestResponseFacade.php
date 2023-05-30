<?php

namespace Aymanalhattami\LogRequestResponse;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aymanalhattami\LogRequestResponse\Skeleton\SkeletonClass
 */
class LogRequestResponseFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'log-request-response';
    }
}
