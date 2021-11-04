<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Admin\Entities\BrandSlider;
use Modules\Admin\Http\Requests\CreateSliderRequest;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $rows = BrandSlider::all();
        return view('admin::slider.index', compact('rows'));
    }

    public function create()
    {
        return view('admin::slider.create');
    }


    public function store(CreateSliderRequest $request)
    {
        $input = $request->except('slider');
        $slider=BrandSlider::create($input);
        $slider->update([
            'slider'=>$request['slider']
        ]);
        return redirect()->route('admin.slider.index');
    }


    public function edit($id)
    {
        $row = BrandSlider::findOrFail($id);
        return view('admin::slider.edit', compact('row'));
    }


    public function update(CreateSliderRequest $request, $id)
    {
        $row = BrandSlider::findOrFail($id);
        $input = $request->validated();
        $row->update($input);
        return redirect()->route('admin.slider.index');
    }


    public function destroy($id)
    {
        $row = BrandSlider::findOrFail($id);
        $row->delete();
        return redirect()->back()->with('deleted', 'تم الحذف بنجاح');
    }

    public function ban($id): object
    {
        $row = BrandSlider::find($id);
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
        $row = BrandSlider::find($id);
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
