<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
  
class ImageController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index()
    {
        return view('image.index');
    }
    
    /**
     * handle upload file
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $image_name = time().'.'.$request->image->extension();  
     
        $path = Storage::disk('s3')->put('images/1', $request->image);
        $path = Storage::disk('s3')->url($path);

        // here you need to store image path in database
    
        return redirect()->back()
            ->with('success', 'Image uploaded successfully.')
            ->with('image', $path); 
    }
}