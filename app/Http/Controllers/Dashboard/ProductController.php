<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Product::select('id','slug','price','is_active','created_at')->get();
        return view('dashboard.products.general.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['brands'] = Brand::active()->select('id')->orderBy('id','DESC')->get();
        $data['tags'] = Tag::select('id')->orderBy('id','DESC')->get();
        $data['categories'] = Category::active()->select('id')->orderBy('id','DESC')->get();

        return view('dashboard.products.general.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        if (!$request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        } else {
            $request->request->add(['is_active' => 1]);
        }

        $product = Product::create([
            'slug'=>$request->slug,
            'brand_id'=>$request->brand_id,
            'is_active'=>$request->is_active,
            'price'=>$request->price,
            'special_price'=>$request->special_price,
            'special_price_type'=>$request->special_price_type,
            'special_price_start'=>$request->special_price_start,
            'special_price_end'=>$request->special_price_end,
            'sku'=>$request->sku,
            'manage_stock'=>$request->manage_stock,
            'in_stock'=>$request->in_stock,
            'qty'=>$request->qty,
        ]);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->save();

        //product categories
        $product->categories()->attach($request->categories);
        //product tags
        $product->tags()->attach($request->tags);

        DB::commit();

        return redirect()->route('admin.products')->with(['success' => __('created successfully')]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $product = Product::find($id);
        $data = [];
        $data['selectedCategories'][]=[];
        $data['selectedTags'][]=[];
        foreach ($product->categories as $category)
        {
            $data['selectedCategories'][] =$category->pivot->category_id;
        }
        foreach ($product->tags as $tag)
        {
            $data['selectedTags'][] =$tag->pivot->tag_id;
        }
        $data['brands'] = Brand::active()->select('id')->orderBy('id','DESC')->get();
        $data['tags'] = Tag::select('id')->orderBy('id','DESC')->get();
        $data['categories'] = Category::active()->select('id')->orderBy('id','DESC')->get();

        if (!$product)
            return redirect()->route('admin.products')->with(['error' => __('admin\dashboard.product not found')]);
        return view('dashboard.products.general.edit', compact('product'))->with($data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);

        DB::beginTransaction();
        if (!$request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        } else {
            $request->request->add(['is_active' => 1]);
        }

        $product->update([
            'slug'=>$request->slug,
            'brand_id'=>$request->brand_id,
            'is_active'=>$request->is_active,
            'price'=>$request->price,
            'special_price'=>$request->special_price,
            'special_price_type'=>$request->special_price_type,
            'special_price_start'=>$request->special_price_start,
            'special_price_end'=>$request->special_price_end,
            'sku'=>$request->sku,
            'manage_stock'=>$request->manage_stock,
            'in_stock'=>$request->in_stock,
            'qty'=>$request->qty,
        ]);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->save();

        //product categories
        $product->categories()->sync($request->categories);
        //product tags
        $product->tags()->sync($request->tags);

        DB::commit();

        return redirect()->route('admin.products')->with(['success' => __('updated successfully')]);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with(['error' => __('category not found')]);
        } else {
            DB::beginTransaction();

            $product->delete();
            $img = Image::where('product_id',$id)->get();
            if(empty($img)){
                $img->delete();
            }
            DB::commit();

            return redirect()->back()->with(['success' => __('deleted successfully')]);
        }
    }
    public function uploadImages($id)
    {
        $photos = Image::where('product_id',$id)->get();
        return view('dashboard.products.images.create')->withId($id)->withPhotos($photos);
    }

    public function storeImages(Request $request){
        $file = $request->file('dzfile');
        if (isset($file)){
           $fileName= uploadImage('products', $file);
        }
        return response()->json([
            'name'=>$fileName,
        ]);
    }

    public function storeImagesDB(ProductImageRequest $request){
        if($request->has('photos') && count($request->photos) > 0){
            foreach ($request->photos as $photo){
                Image::create([
                    'product_id'=>$request->product_id,
                    'photo'=>$photo,
                ]);
            }
        }
        return redirect()->route('admin.products')->with(['success' => __('updated successfully')]);
    }

    public function deleteImage($img){
        $img = Image::where('photo',$img)->first();

        if (!$img) {
            return redirect()->back()->with(['error' => __('image not found')]);
        } else {
            DB::beginTransaction();
            if (File::exists(public_path('/assets/images/products/'.$img->photo))) {
                File::delete(public_path('/assets/images/products/'.$img->photo));
            }
            $img->delete();
            DB::commit();
            return redirect()->back()->with(['success' => __('deleted successfully')]);
        }
    }

}
