<?php

namespace Statamic\Events;

use Illuminate\Http\Response;

class ResponseCreated extends Event
{
    /**
     * @var Response
     */
    public $response;

    public $data;

    public function __construct(Response $response, $data)
    {
        $this->response = $response;
        $this->data = $data;
    }
}
