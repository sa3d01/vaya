<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\BrandOwner;
use Modules\Admin\Entities\Location;
use Modules\Admin\Http\Requests\CreateBrandRequest;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $rows = Brand::all();
        return view('admin::brand.index', compact('rows'));
    }

    public function create()
    {
        $owners_ids=Brand::pluck('brand_owner_id')->toArray();
        $owners = BrandOwner::whereNotIn('id',$owners_ids)->get();
        $locations = Location::all();
        return view('admin::brand.create', compact('owners', 'locations'));
    }


    public function store(CreateBrandRequest $request)
    {
        $input=$request->except('image');
        $brand=Brand::create($input);
        if ($request['image']){
            $brand->update(['image'=>$request['image']]);
        }
        return redirect()->route('admin.brand.index');
    }


    public function show($id)
    {
        $row = Brand::findOrFail($id);
        return view('admin::brand.show', compact('row'));
    }


    public function edit($id)
    {
        $row = Brand::findOrFail($id);
        $owners_ids=Brand::pluck('brand_owner_id')->toArray();
        $owners = BrandOwner::whereNotIn('id',$owners_ids)->get();
        $locations = Location::all();
        return view('admin::brand.edit', compact('row','owners','locations'));
    }


    public function update(CreateBrandRequest $request, $id)
    {
        $row = Brand::findOrFail($id);
        $input=$request->validated();
        $row->update($input);
        return redirect()->route('admin.brand.index');
    }


    public function destroy($id)
    {
        $row = Brand::findOrFail($id);
        $row->delete();
        return redirect()->back()->with('deleted', 'تم الحذف بنجاح');
    }

    public function ban($id): object
    {
        $row = Brand::find($id);
        $row->update(
            [
                'banned' => 1,
            ]
        );
        $row->refresh();
        $row->refresh();
        return redirect()->back()->with('updated');
    }

    public function activate($id): object
    {
        $row = Brand::find($id);
        $row->update(
            [
                'banned' => 0,
            ]
        );
        $row->refresh();
        $row->refresh();
        return redirect()->back()->with('updated');
    }
}
