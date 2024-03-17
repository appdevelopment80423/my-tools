<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use ZipArchive;

class ImageCompressionController extends Controller
{
    public function index()
    {
        return view('admin.image-compression.index');
    }

    public function compress(Request $request){
        try {
            $files = $request->file('image');
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid().'_image_'.time().'.'.$extension;
                // Compress JPG files using Intervention package
                if ($extension == 'jpg' || $extension == 'jpeg') {
                    $image = Image::make($file);
                    // Adjust quality as needed, ensuring no compromise on quality
                    $image->save(public_path('compressed/' . $fileName), 100);
                }elseif ($extension == 'png') {
                    $pngquant = config('constants.PNGQUANT_PATH');
                    $command =  "$pngquant --quality=70-80 ";

                    // Execute command based on environment
                    // Execute command based on environment
                    if (env('APP_ENV') == 'production') {
                        exec($command . '-o ' . public_path('compressed/' . $fileName) . ' ' . $file->path());
                    } else {
                        shell_exec($command . '-o ' . public_path('compressed/' . $fileName) . ' ' . $file->path());
                    }

                }
            }
            return redirect()->back()->with('success', 'Image compressed successfully.');
        } catch (\Exception $e){
            $bug = $e->getMessage();
            Log::error("ImageCompressionController (compress) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
            return redirect()->back()->with('error', $bug);
        }
    }
}
