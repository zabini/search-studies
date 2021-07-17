<?php

namespace App\Http\Controllers;

use App\Domains\Core\Application\GetComposition;
use App\MessageBus;
use Illuminate\Http\Request;

class CompositionController extends Controller
{

    /**
     * @param MessageBus $messageBus
     */
    public function __construct(private MessageBus $messageBus)
    {
    }

    /**
     * @param string $id
     * @param Request $request
     * @return void
     */
    public function get(string $id, Request $request)
    {
        return $this->messageBus->dispatch(new GetComposition($id));
    }
}
