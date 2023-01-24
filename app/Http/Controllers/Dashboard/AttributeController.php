<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class AttributeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::orderBy('id', 'DESC')->get();
        return view('dashboard.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes = Attribute::orderBy('id', 'DESC')->get();
        return view('dashboard.attributes.create', compact('attributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeRequest $request)
    {
        DB::beginTransaction();
        $attribute = Attribute::create($request->all());

        $attribute->name = $request->name;
        $attribute->save();
        DB::commit();

        return redirect()->route('admin.attributes')->with(['success' => __('created successfully')]);

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
        $attribute = Attribute::find($id);
        if (!$attribute)
            return redirect()->route('admin.attributes')->with(['error' => __('admin\dashboard.attribute not found')]);
        return view('dashboard.attributes.edit', compact('attribute'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, $id)
    {
        $attribute = Attribute::find($id);



        if (!$attribute) {
            return redirect()->back()->with(['error' => __('attribute not found')]);
        } else {
            DB::beginTransaction();
            $attribute->name = $request->name;
            $attribute->save();
            DB::commit();

            return redirect()->route('admin.attributes')->with(['success' => __('updated successfully')]);

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
        $attribute = Attribute::find($id);
        if (!$attribute) {
            return redirect()->back()->with(['error' => __('attribute not found')]);
        } else {
            $attribute->delete();
            return redirect()->back()->with(['success' => __('deleted successfully')]);
        }
    }
}
