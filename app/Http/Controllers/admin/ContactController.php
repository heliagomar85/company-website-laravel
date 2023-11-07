<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::paginate(5);
        return view('dashbord.contact.index',compact('contact'));
    }

    public function create()
    {
       //
    }
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $contact = Contact::findorfail($id);
        return view('dashbord.contact.show',compact('contact'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Contact::destroy($id);
        session()->flash('delete-contact','delete contact successfully');
        return redirect()->route('contact.index');

    }
}
