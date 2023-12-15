<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function send(Request $request)
    {
        $contact = new Contact();
        $contact->name = $request->input("name");
        $contact->email = $request->input("email");
        $contact->text = $request->input("text");
        $contact->save();

        return redirect()->back();
    }
    public function get()
    {
        $contacts = Contact::all();

        return view("admin.contents.contact", compact("contacts"));
    }
}
