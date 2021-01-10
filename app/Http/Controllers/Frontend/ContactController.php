<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Notifications\ContactNotification;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contactPage()
    {
        return view('frontend.contact');
    }

    public function contactPost(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|min:3|max:250',
            'phone' => 'required|string|numeric|digits_between:6,30',
            'email' => 'required|string|email|max:250',
            'subject' => 'required|string|min:3|max:250',
            'message' => 'required|string|min:10|max:1000'
        ]);

        $user = new \App\Models\User();
        $user->notify(new ContactNotification());

        return redirect()->back()->with('success','Votre message a été envoyé avec succès! Notre équipe compétente vous répondra sans délai. Merci');
    }
}
