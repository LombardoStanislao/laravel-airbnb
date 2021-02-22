<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Message;
use App\Apartment;

class MessageController extends Controller
{
    public function index($apartment_id) {

        $apartment = Apartment::where('id', $apartment_id)->first();

        if ($apartment && $apartment->user_id == Auth::user()->id) {
            $messages = Message::where('apartment_id', $apartment->id)->get();

            $data = [
                'messages' => $messages,
                'apartment_id' => $apartment->id
            ];
            return view('admin.messages.index', $data);
        }

        abort(404);
    }

    public function show($id) {
        $message = Message::find($id);

        if($message) {
            $data = [
                'message' => $message,
                'apartment' => $message->apartment
            ];
            return view('admin.messages.show', $data);
        } else {
            abort(404);
        }
    }
}
