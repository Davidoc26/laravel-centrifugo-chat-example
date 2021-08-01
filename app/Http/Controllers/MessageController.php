<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\MessageGetRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageCollection;
use App\Models\Message;
use denis660\Centrifugo\Centrifugo;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MessageController extends Controller
{
    public function getMessages(MessageGetRequest $request): ResourceCollection
    {
        return new MessageCollection($request->user()->getMessagesWith($request->get('receiver_id'), orderBy: 'desc'));
    }

    public function send(StoreMessageRequest $request, Centrifugo $centrifugo): Response|HttpException
    {
        try {
            $centrifugo->info();
        } catch (ConnectException $e) {
            throw new HttpException(503);
        }

        $message = Message::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $request->get('receiver_id'),
            'body' => $request->get('body'),
        ]);

        MessageSent::dispatch($message);

        return response('');
    }
}
