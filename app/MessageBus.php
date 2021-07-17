<?php

namespace App;

use App\Domains\Core\Application\GetComposition;
use App\Domains\Core\Application\GetCompositionFinder;
use Illuminate\Support\Facades\App;

class MessageBus
{

    public function dispatch(GetComposition $command)
    {

        $handler = App::make(GetCompositionFinder::class);

        return $handler->handle($command);
    }
}
