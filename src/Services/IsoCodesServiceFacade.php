<?php

namespace Limanweb\IsoCodes\Services;

use Illuminate\Support\Facades\Facade;
use Limanweb\IsoCodes\Services\IsoCodesService;

class IsoCodesServiceFacade extends Facade
{
    protected static function getFacadeAccessor() { return IsoCodesService::class; }
}
