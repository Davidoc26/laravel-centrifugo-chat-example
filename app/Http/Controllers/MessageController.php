<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageGetRequest;
use App\Http\Resources\MessageCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageController extends Controller
{
    public function getMessages(MessageGetRequest $request) : ResourceCollection
    {
        return new MessageCollection($request->user()->getMessagesWith($request->get('receiver_id')));
    }
}
