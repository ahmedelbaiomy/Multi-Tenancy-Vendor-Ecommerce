<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\SliderRequest;
use App\Models\Image;
use App\Models\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class SliderController extends Controller
{

    public function uploadImages()
    {
        $photos = Slider::all();
        return view('dashboard.sliders.create')->withPhotos($photos);
    }

    public function storeImages(Request $request){
        $file = $request->file('dzfile');
        if (isset($file)){
            $fileName= uploadImage('sliders', $file);
        }
        return response()->json([
            'name'=>$fileName,
        ]);
    }

    public function storeImagesDB(SliderRequest $request){
        if($request->has('photos') && count($request->photos) > 0){
            foreach ($request->photos as $photo){
                Slider::create([
                    'photo'=>$photo,
                ]);
            }
        }
        return redirect()->route('admin.sliders.create')->with(['success' => __('updated successfully')]);
    }

    public function deleteImage($img){
        $image = Slider::where('photo',$img)->first();
        if (!$image) {
            return redirect()->back()->with(['error' => __('image not found')]);
        } else {
            DB::beginTransaction();
            if (File::exists(public_path('/assets/images/sliders/'.$image->photo))) {
                File::delete(public_path('/assets/images/sliders/'.$image->photo));
            }
            $image->delete();
            DB::commit();
            return redirect()->back()->with(['success' => __('deleted successfully')]);
        }
    }
}
