<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\CarouselSeller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CarouselsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carousels = Carousel::all();
        return view('admin.carousel.index', compact('carousels'));
    }

    public function indexSeller($id)
    {
        $user = User::findOrFail($id);
        $store = Store::select('id')->where('cust_id', $user->cust_id)->first();
        $carousels = CarouselSeller::where('store_id', $store->id)->get();

        return view('admin.carousel.seller', compact('carousels', 'store'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|max:4096',
        ]);

        if ($request->has('photo')) {
            $file = $request->file('photo');
            $name = time() . '_' . $file->getClientOriginalName();

            // Image::make($file)->resize(1054, 236)->save('public/images/carousel/' . $name);
            $filePath = $file->storeAs('images/carousel', $name, 'public');

            $carousels = new Carousel([
                'photo' => $name,
                'is_default' => $request->is_default
            ]);
            $carousels->save();
        }

        return back()->with('status', 'Carousel Berhasil Di Tambahkan');
    }

    public function storeSeller(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $store = Store::select('id')->where('cust_id', $user->cust_id)->first();

        $request->validate([
            'photo' => 'required|max:4096',
        ]);

        if ($request->has('photo')) {
            $file = $request->file('photo');
            $name = time() . '_' . $file->getClientOriginalName();

            // Image::make($file)->resize(1054, 236)->save('public/images/carousel/' . $name);
            $filePath = $file->storeAs('images/carousel/seller', $name, 'public');
            // dd($name);
            $carousels = new CarouselSeller([
                'store_id' => $store->id,
                'photo' => $name,
                'is_default' => $request->is_default
            ]);
            $carousels->save();
        }
        return back()->with('status', 'Carousel Berhasil Di Tambahkan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Carousel::findOrFail($id)->update([
            'is_default' => $request->is_default
        ]);

        return back()->with('status', 'Data Berhasil di Ubah');
    }

    public function updateSeller(Request $request, $id)
    {
        CarouselSeller::findOrFail($id)->update([
            'is_default' => $request->is_default
        ]);

        return back()->with('status', 'Data Berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
