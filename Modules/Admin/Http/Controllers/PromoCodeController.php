<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\CreatePromoCodeRequest;

class PromoCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $rows = PromoCode::all();
        return view('admin::promo_code.index', compact('rows'));
    }

    public function create()
    {
        return view('admin::promo_code.create');
    }


    public function store(CreatePromoCodeRequest $request)
    {
        $input = $request->validated();
        PromoCode::create($input);
        return redirect()->route('admin.promo_code.index');
    }


    public function edit($id)
    {
        $row = PromoCode::findOrFail($id);
        return view('admin::promo_code.edit', compact('row'));
    }


    public function update(CreatePromoCodeRequest $request, $id)
    {
        $row = PromoCode::findOrFail($id);
        $input = $request->validated();
        $row->update($input);
        return redirect()->route('admin.promo_code.index');
    }


    public function destroy($id)
    {
        $row = PromoCode::findOrFail($id);
        $row->delete();
        return redirect()->back()->with('deleted', 'تم الحذف بنجاح');
    }

    public function ban($id): object
    {
        $row = PromoCode::find($id);
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
        $row = PromoCode::find($id);
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
