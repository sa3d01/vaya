<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Location;
use Modules\Admin\Http\Requests\CreateBrandRequest;
use Modules\Admin\Http\Requests\CreateLocationRequest;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $rows = Location::all();
        return view('admin::location.index', compact('rows'));
    }

    public function create()
    {
        return view('admin::location.create');
    }


    public function store(CreateLocationRequest $request)
    {
        $input = $request->validated();
        Location::create($input);
        return redirect()->route('admin.location.index');
    }


    public function edit($id)
    {
        $row = Location::findOrFail($id);
        return view('admin::location.edit', compact('row'));
    }


    public function update(CreateLocationRequest $request, $id)
    {
        $row = Location::findOrFail($id);
        $input = $request->validated();
        $row->update($input);
        return redirect()->route('admin.location.index');
    }


    public function destroy($id)
    {
        $row = Location::findOrFail($id);
        $row->delete();
        return redirect()->back()->with('deleted', 'تم الحذف بنجاح');
    }

    public function ban($id): object
    {
        $row = Location::find($id);
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
        $row = Location::find($id);
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
