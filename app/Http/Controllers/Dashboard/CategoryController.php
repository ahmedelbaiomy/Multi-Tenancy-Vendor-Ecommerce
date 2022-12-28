<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::with('_parent')->orderBy('id','DESC')->get();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $categories = Category::select('id','parent_id')->orderBy('id','DESC')->get();
            return view('dashboard.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if (!$request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        } else {
            $request->request->add(['is_active' => 1]);
        }

        if($request -> type == 1) //main category
        {
            $request->request->add(['parent_id' => null]);
        }

            DB::beginTransaction();
            $category = Category::create($request->all());
            $category->name = $request->name;
            $category->save();
            DB::commit();

        return redirect()->route('admin.categories')->with(['success' => __('created successfully')]);

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
        $category = Category::find($id);
        $categories = Category::select('id','parent_id')->orderBy('id','DESC')->get();

        if (!$category)
                return redirect()->route('admin.categories')->with(['error' => __('admin\dashboard.category not found')]);
            return view('dashboard.categories.edit', compact(['category','categories']));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if (!$request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        } else {
            $request->request->add(['is_active' => 1]);
        }

        if($request -> type == CategoryType::mainCategory) //main category
        {
            $request->request->add(['parent_id' => null]);
        }


        if (!$category) {
            return redirect()->back()->with(['error' => __('category not found')]);
        } else {
            DB::beginTransaction();
            $category->update($request->all());
            $category->name = $request->name;
            $category->save();
            DB::commit();

            return redirect()->route('admin.categories')->with(['success' => __('updated successfully')]);

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
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with(['error' => __('category not found')]);
        } else {
            $category->delete();
            return redirect()->back()->with(['success' => __('deleted successfully')]);
        }
    }
}
