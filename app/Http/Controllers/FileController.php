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

        // get the signed in user
        $user = Auth::user();

        // store the file in the public storage
        $file = $request->file('file');
        // set a new filename
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
        // set the subdirectory
        $subdir = request()->session()->get('mode', 'user') == 'admin' ? 'admin' : $user->uid;
        // store the file
        $path = $file->storeAs('uploads/' . $subdir, $fileName, 'public');

        // create a new file entry in the database
        $user->files()->create([
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

    // downloads a file from the server
    public function secure(string $filePath) {
        // retrieves the secure storage base path
        $basePath = realpath(Storage::disk('secure')->path(''));
        // retrieves the real file path
        $realFilePath = realpath(Storage::disk('secure')->path($filePath));

        // check if the file path is valid
        if($basePath === false || $realFilePath === false) {
            // return 404
            return abort(404);
        }

        // check if the file path is inside the secure storage
        if(strpos($realFilePath, $basePath) !== 0) {
            // return 404
            return abort(404);
        }

        // check if the file exists
        if (Storage::disk('secure')->exists($filePath)) {
            //return the file
            return response()->file($realFilePath);
        } else {
            // return 404
            return abort(404);
        }
    }
}
