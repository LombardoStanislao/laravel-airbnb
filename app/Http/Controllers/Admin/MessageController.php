<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Message;
use App\Apartment;

class MessageController extends Controller
{
    public function index() {
        $user = Auth::user();
        $apartmentIds = $user->apartments()->pluck('id');

        $userMessages = Message::whereIn('apartment_id', $apartmentIds)->get();

        $data = [
            'messages' => $userMessages
        ];

        return view('admin.messages.index', $data);
    }

    public function show(Message $message) {
        if($message) {
            $data = [
                'message' => $message
            ];
            return view('admin.messages.show', $data);
        } else {
            abort(404);
        }
    }
}
