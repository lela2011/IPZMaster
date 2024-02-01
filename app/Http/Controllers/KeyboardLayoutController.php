<?php

namespace App\Http\Controllers;

use App\Models\KeyboardLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KeyboardLayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the types
        $keyboardLayouts = KeyboardLayout::orderBy('name')->paginate(20);

        // display the index page
        return view('admin.keyboardLayout.index', compact('keyboardLayouts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // display the create form
        return view('admin.keyboardLayout.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('keyboard_layouts', 'name')]
        ],[
            'name.required' => 'Keyboard Layout name is required',
            'name.unique' => 'Keyboard Layout name already exists'
        ]);

        // create
        KeyboardLayout::create($formdata);

        // redirect to index page
        return redirect()->route('keyboard-layout.index')->with('message', 'Keyboard Layout created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KeyboardLayout $keyboardLayout)
    {
        // display the edit form
        return view('admin.keyboardLayout.edit', compact('keyboardLayout'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KeyboardLayout $keyboardLayout)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('keyboard_layouts', 'name')->ignore($keyboardLayout->id)]
        ],[
            'name.required' => 'Keyboard Layout name is required',
            'name.unique' => 'Keyboard Layout name already exists'
        ]);

        // update the  type
        $keyboardLayout->update($formdata);

        // redirect to index page
        return redirect()->route('keyboard-layout.index')->with('message', 'Keyboard Layout updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KeyboardLayout $keyboardLayout)
    {
        // delete the type
        $keyboardLayout->delete();

        // redirect to type index
        return redirect()->route('keyboard-layout.index')->with('message', 'Keyboard Layout deleted successfully');
    }
}
