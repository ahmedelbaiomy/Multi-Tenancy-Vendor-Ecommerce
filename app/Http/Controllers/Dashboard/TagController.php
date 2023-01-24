<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class TagController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        Alert::success('this is message index', 'success');
        toast('Success Toast','success')->autoClose(5000);

        $tags = Tag::orderBy('id', 'DESC')->get();
        return view('dashboard.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::orderBy('id', 'DESC')->get();
        return view('dashboard.tags.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {

        DB::beginTransaction();
        $tag = Tag::create($request->all());
        $tag->name = $request->name;
        $tag->save();
        DB::commit();

        return redirect()->route('admin.tags')->with(['success' => __('created successfully')]);

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
        $tag = Tag::find($id);
        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => __('admin\dashboard.tag not found')]);
        return view('dashboard.tags.edit', compact('tag'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return redirect()->back()->with(['error' => __('tag not found')]);
        } else {
            DB::beginTransaction();

            $tag->update($request->all());
            $tag->name = $request->name;
            $tag->save();
            DB::commit();

            return redirect()->route('admin.tags')->with(['success' => __('updated successfully')]);

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
        $tag = Tag::find($id);
        if (!$tag) {
            return redirect()->back()->with(['error' => __('tag not found')]);
        } else {
            $tag->delete();
            return redirect()->back()->with(['success' => __('deleted successfully')]);
        }
    }
}
