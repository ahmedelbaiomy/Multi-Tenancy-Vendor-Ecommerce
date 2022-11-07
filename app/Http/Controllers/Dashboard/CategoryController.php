<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
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
    public function index(Request $request)
    {

        if($request->query('type') == 'main'){
            $categories = Category::parent()->orderBy('id','DESC')->get();
            return view('dashboard.categories.index', compact('categories'));
        }elseif ($request->query('type') == 'sub'){
            $categories = Category::child()->orderBy('id','DESC')->get();
            return view('dashboard.subCategories.index', compact('categories'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->query('type') == 'sub'){
            $categories = Category::parent()->orderBy('id','DESC')->get();
            return view('dashboard.subCategories.create', compact('categories'));
        }
        return view('dashboard.categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MainCategoryRequest $request)
    {
        if (!$request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        } else {
            $request->request->add(['is_active' => 1]);
        }

            DB::beginTransaction();
            $category = Category::create($request->all());
            $category->name = $request->name;
            $category->save();
            DB::commit();
        if($request->filled('parent_id')) {
            return redirect()->route('admin.categories',['type'=>'sub'])->with(['success' => __('created successfully')]);
        }
        return redirect()->route('admin.categories',['type'=>'main'])->with(['success' => __('created successfully')]);

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

        if($request->query('type') == 'sub'){
            $categories = Category::parent()->orderBy('id','DESC')->get();
            if (!$category)
                return redirect()->route('admin.categories')->with(['error' => __('admin\dashboard.category not found')]);
            return view('dashboard.subCategories.edit', compact(['category','categories']));
        }elseif ($request->query('type') == 'main'){
            if (!$category)
                return redirect()->route('admin.categories')->with(['error' => __('admin\dashboard.category not found')]);
            return view('dashboard.categories.edit', compact('category'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(MainCategoryRequest $request, $id)
    {

        if (!$request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        } else {
            $request->request->add(['is_active' => 1]);
        }

        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with(['error' => __('category not found')]);
        } else {
            DB::beginTransaction();
            $category->update($request->all());
            $category->name = $request->name;
            $category->save();
            DB::commit();
            if($request->filled('parent_id')) {
                return redirect()->route('admin.categories',['type'=>'sub'])->with(['success' => __('updated successfully')]);
            }
            return redirect()->route('admin.categories',['type'=>'main'])->with(['success' => __('updated successfully')]);

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
