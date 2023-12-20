<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // display all files of the logged in user
    public function index() {
        // get all files of the logged in user
        if(request()->session()->get('mode', 'user') == 'admin' && Auth::user()->adminLevel > 0) {
            $files = File::all();
        } else {
            $files = Auth::user()->files()->get();
        }

        // return the view with the files
        return view('file.index', [
            'files' => $files
        ]);
    }

    // uploads a file to the server
    public function upload(Request $request) {
        // validate the request
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120', //allow 5MB max size
        ],[
            'file.required' => 'Please upload a file',
            'file.mimes' => 'Only pdf, doc and docx files are allowed',
            'file.max' => 'Sorry! Maximum allowed size for a document is 5MB',
        ]);

        // store the file in the public storage
        $file = $request->file('file');
        $path = $file->store('uploads', 'public');

        // create a new file entry in the database
        Auth::user()->files()->create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path
        ]);

        // redirect back to the file index page
        return redirect()->back()->with('message', 'File uploaded successfully.');
    }

    // deletes a file from the server
    public function destroy(File $file) {
        $this->authorize('delete', $file);

        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }
        $file->delete();

        // redirect back to the file index page
        return redirect()->back()->with('message', 'File deleted successfully.');
    }
}
