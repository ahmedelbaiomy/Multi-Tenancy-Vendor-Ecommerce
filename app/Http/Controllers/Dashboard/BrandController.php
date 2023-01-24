<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class BrandController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        return view('dashboard.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        return view('dashboard.brands.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        if (!$request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        } else {
            $request->request->add(['is_active' => 1]);
        }

        DB::beginTransaction();
        $brand = Brand::create($request->except('photo'));
        $fileName ='';
        if($request->has('photo')){
            $fileName = uploadImage('brands',$request->photo);
        }
        $brand->photo = $fileName;
        $brand->name = $request->name;
        $brand->save();
        DB::commit();

        return redirect()->route('admin.brands')->with(['success' => __('created successfully')]);

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
    public function edit($id)
    {
        $brand = Brand::find($id);
        if (!$brand)
            return redirect()->route('admin.brands')->with(['error' => __('admin\dashboard.brand not found')]);
        return view('dashboard.brands.edit', compact('brand'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::find($id);



        if (!$brand) {
            return redirect()->back()->with(['error' => __('brand not found')]);
        } else {
            DB::beginTransaction();
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }
            if($request->has('photo')){
                $fileName = uploadImage('brands',$request->photo);
                $brand->photo = $fileName;

            }
            $brand->update($request->except('photo'));
            $brand->name = $request->name;
            $brand->save();
            DB::commit();

            return redirect()->route('admin.brands')->with(['success' => __('updated successfully')]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->back()->with(['error' => __('brand not found')]);
        } else {
            $fileName = explode("/",$brand->photo)[6];
            $folder = explode("/",$brand->photo)[5];
            DB::beginTransaction();
            if (File::exists(public_path('/assets/images/'.$folder.'/'.$fileName))) {
                File::delete(public_path('/assets/images/'.$folder.'/'.$fileName));
            }
            $brand->delete();
            DB::commit();
            return redirect()->back()->with(['success' => __('deleted successfully')]);
        }
    }
}
