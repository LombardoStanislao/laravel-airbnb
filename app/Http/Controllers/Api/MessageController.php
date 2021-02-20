<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    public function viewedMessage(Request $request) {
        $messageId = json_decode($request->getContent())->messageId;

        $message = Message::find($messageId);

        $message->is_new = 0;

        $message->update();
        
    }
}
