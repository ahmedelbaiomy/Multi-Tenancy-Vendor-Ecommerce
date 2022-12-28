<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\OptionRequest;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Option;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\isEmpty;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $options = Option::with(['product' => function ($prod) {
            $prod->select('id');
        }, 'attribute' => function ($attr) {
            $attr->select('id');
        }])->select('id', 'attribute_id', 'product_id', 'price')->get();
        return view('dashboard.options.index', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['products'] = Product::active()->select('id')->orderBy('id', 'DESC')->get();
        $data['attributes'] = Attribute::select('id')->orderBy('id', 'DESC')->get();

        return view('dashboard.options.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OptionRequest $request)
    {
        DB::beginTransaction();

        $option = Option::create([
            'price' => $request->price,
            'product_id' => $request->product_id,
            'attribute_id' => $request->attribute_id,
        ]);
        $option->name = $request->name;

        $option->save();

        DB::commit();

        return redirect()->route('admin.options')->with(['success' => __('created successfully')]);

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
    public function edit($id, Request $request)
    {
        $option = Option::find($id);
        $data = [];

        $data['products'] = Product::active()->select('id')->orderBy('id', 'DESC')->get();
        $data['attributes'] = Attribute::select('id')->orderBy('id', 'DESC')->get();

        if (!$option)
            return redirect()->route('admin.options')->with(['error' => __('admin\dashboard.option not found')]);
        return view('dashboard.options.edit', compact('option'))->with($data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OptionRequest $request, $id)
    {
        $option = Option::find($id);

        DB::beginTransaction();

        $option->update([
            'price' => $request->price,
            'product_id' => $request->product_id,
            'attribute_id' => $request->attribute_id,
        ]);
        $option->name = $request->name;

        $option->save();

        DB::commit();

        return redirect()->route('admin.options')->with(['success' => __('updated successfully')]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $option = Option::find($id);
        if (!$option) {
            return redirect()->back()->with(['error' => __('option not found')]);
        } else {

            $option->delete();


            return redirect()->back()->with(['success' => __('deleted successfully')]);
        }
    }


}
