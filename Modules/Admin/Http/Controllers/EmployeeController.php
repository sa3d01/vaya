<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\BrandOwner;
use Modules\Admin\Entities\Location;
use Modules\Admin\Http\Requests\CreateBrandOwnerRequest;
use Modules\Admin\Http\Requests\EditBrandOwnerRequest;
use Modules\Brand\Entities\BrandEmployee;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $rows = BrandEmployee::where('type','technical')->get();
        return view('admin::brand_employee.index', compact('rows'));
    }

    public function create()
    {
        return view('admin::brand_employee.create');
    }


    public function store(CreateBrandOwnerRequest $request)
    {
        $input=$request->except('avatar');
        $brand_owner=BrandOwner::create($input);
        try {
            if ($request['avatar']){
                $brand_owner->update(['avatar'=>$request['avatar']]);
            }
        }catch (\Exception $e){

        }

        return redirect()->route('admin.brand_owner.index');
    }


    public function show($id)
    {
        $row = BrandOwner::findOrFail($id);
        return view('admin::brand_owner.show', compact('row'));
    }


    public function edit($id)
    {
        $row = BrandOwner::findOrFail($id);
        return view('admin::brand_owner.edit', compact('row'));
    }


    public function update(EditBrandOwnerRequest $request, $id)
    {
        $row = BrandOwner::findOrFail($id);
        $input=$request->validated();
        $row->update($input);
        return redirect()->route('admin.brand_owner.index');

    }


    public function destroy($id)
    {
        $row = BrandOwner::findOrFail($id);
        $row->delete();
        return redirect()->back()->with('deleted', 'تم الحذف بنجاح');
    }

    public function ban($id): object
    {
        $row = BrandOwner::find($id);
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
        $row = BrandOwner::find($id);
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
