<?php


namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class BugController extends Controller
{

    public function post(Request $request)
    {
        $req = $request->all();

        $text = 'User: ' . \Auth::id() . "\r\n";
        foreach ($req as $field => $value) {
            $text .= $field . ': ' . $value . "\r\n";
        }

        Mail::raw($text, function ($message) {
            $message->to(config('mail.admin', 'My Lord'));
            $message->subject('BUG');
        });
        return response()->json(['success' => ['Message sent!']]);
    }
}
