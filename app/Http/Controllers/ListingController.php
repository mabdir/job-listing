<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Listings;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{



    public function index()

    {
    
    $listings = Listings::latest()->filter(request(['tag, search, description']))->paginate(4);
    return view('listings.index', compact('listings'));
    }

    public function show($id)

    {
        $listings = Listings::find($id);
        if($listings){
            return view('listings.show', compact('listings'));
        } else {
            abort('404');
        }
       
    }

    public function create() 
    {
        return view('listings.create');
    }

    public function store(Request $request) 
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('Listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
            
        ]);

        if($request->hasFile('logo')) 
        {
            $formFields['logo'] = $request->file('logo')->store('logos', 
            'public');
        }

        $formFields['user_id'] = auth()->id();

        Listings::create($formFields);
        return redirect('/')->with('message', 'Listing created successfully');       
    }

    public function edit(Listings $listing)

    {
        
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Listings $listing, Request $request) 

    {
        //make sure logged in user is owner

        if($listing->user_id != auth()->id())

        {
            abort(403, 'Unauthorized Action');
        }

        
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
            
        ]);

        if($request->hasFile('logo')) 
        {
            $formFields['logo'] = $request->file('logo')->store('logos', 
            'public');
        }

        

        $listing->update($formFields);
        return back()->with('message', 'Listing created successfully');       
    }

    public function destroy(Listings $listing)
    {
        
        if($listing->user_id != auth()->id())

        {
            abort(403, 'Unauthorized Action');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    public function manage()

    {
        return view('listings.manage', ['listings' => auth()
        ->user()->Listing()->get() ]);
    }
}
