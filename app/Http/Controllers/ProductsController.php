<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGalley;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
// use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function kategori()
    {
        $category =  Category::all();
        return view('admin.kategori produk.index', compact('category'));
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'string'
        ]);


        Category::create([
            'name' => $request->name,
        ]);
        return redirect('/kategori')->with('status', 'Data berhasil di Simpan');
    }
    public function index()
    {
        $kategori = Category::all();
        $product = Product::with('category')->get();
        // $store = Store::where('cust_id', Auth::user()->cust_id)->first();

        return view('admin.produk.index', compact('product', 'kategori'));
    }
    public function indexSeller($id)
    {
        $seller = User::findOrFail($id);
        // dd($seller);
        $kategori = Category::all();
        $store = Store::select('id')->where('cust_id', Auth::user()->cust_id)->first();
        // dd($store);
        $product = Product::with('category')->where('store_id', $store->id)->get();

        return view('admin.produk.index', compact('product', 'kategori',));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Auth::user()->cust_id;
        $store = Store::where('cust_id', $data)->first();
        Product::create([
            'nama_product' => $request->name,
            'category_id' => $request->category,
            'slug' => Str::slug($request->name),
            'harga_product' => $request->harga_product,
            'stock_product' => $request->stock_product,
            'description' => $request->description,
            'long_description' => $request->long_desc,
            'berat' => $request->berat,
            'store_id' => $store->id
        ]);

        $id = Product::select('id_product')->orderBy('id_product', 'desc')->first();
        // $tgl = Carbon::now()->format("Y-m-d H:i:s");
        $detail = [];
        $i = 0;

        foreach ($request->photo as $key) {
            $file = $request->file('photo');
            $name = $file[$i]->getClientOriginalName();

            $filePath = $file[$i]->storeAs('images/product', $name, 'public');

            $detail[] = [
                'photo' => $name,
                'product_id' => $id->id_product,
                'is_default' => 1,
            ];
            // $photo = array_merge([$detail, $resizeImage]);
            $i++;
        }

        // dd($detail);
        ProductGalley::insert($detail);

        return back()->with('status', 'Data berhasil Di Tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Product::findOrFail($id);
        $gallery = ProductGalley::with('product')->where('product_id', $id)->get();

        return view('admin.produk.gallery', compact('produk', 'gallery'));
    }

    public function storeGallery(Request $request)
    {
        $product = $request->product_id;
        $isdefault = $request->is_default;

        $detail = [];
        $i = 0;

        foreach ($request->photo as $key) {
            $file = $request->file('photo');
            $name = $file[$i]->getClientOriginalName();

            $filePath = $file[$i]->storeAs('images/product', $name, 'public');

            // $resizedImage = $this->_resizeImage($file, $name);

            // $smallImageFilePath = 'images/product/small/' . $name;
            // $path = public_path('storage/images/product/small' . $name);
            // $smallImageFile = Image::make($file[$i])->fit(135, 141);;
            $detail[] = [
                'photo' => $name,
                'product_id' => $product,
                'is_default' => $isdefault
            ];
            $i++;
        }
        // dd($photo);
        ProductGalley::insert($detail);

        return back()->with('status', 'Data berhasil Di Tambahkan');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Product::findOrFail($id)->update([
            'nama_product' => $request->name,
            'category_id' => $request->category,
            'harga_product' => $request->harga_product,
            'stock_product' => $request->stock_product,
            'description' => $request->description,
            'long_description' => $request->long_desc,
            'berat' => $request->berat
        ]);

        return back()->with('status', 'Data Berhasil di Ubah');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        ProductGalley::findOrFail($id)->update([
            'is_default' => $request->is_default
        ]);

        return back()->with('status', 'Data berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();

        ProductGalley::where('product_id', $id)->delete();

        return back()->with('status', 'Data berhasil di Hapus');
    }

    public function destroyGallery($id)
    {
        $data = ProductGalley::findOrFail($id);
        // Storage::disk('public')->delete("/images/product" . "/" . $data->photo);
        $data->delete();

        return back()->with('status', 'Data berhasil di Hapus');
    }

    // private function _resizeImage($file, $name)
    // {
    //     $resizedImage = [];

    //     $smallImageFilePath = 'images/product/small/' . $name;
    //     $smallImageFile = Image::make($file)->fit(135, 141)->stream();
    //     if (Storage::put('public/' . $smallImageFilePath, $smallImageFile)) {
    //         $resizedImage['small'] = $smallImageFilePath;
    //     }

    //     $mediumImageFilePath = 'images/product/medium/' . $name;
    //     $size = explode('x', ProductGalley::MEDIUM);
    //     list($width, $height) = $size;

    //     $mediumImageFile = Image::make($file)->fit($width, $height)->stream();
    //     if (Storage::put('public/' . $mediumImageFilePath, $mediumImageFile)) {
    //         $resizedImage['medium'] = $mediumImageFilePath;
    //     }

    //     $largeImageFilePath = 'images/product/large/' . $name;
    //     $size = explode('x', ProductGalley::LARGE);
    //     list($width, $height) = $size;

    //     $largeImageFile = Image::make($file)->fit($width, $height)->stream();
    //     if (Storage::put('public/' . $largeImageFilePath, $largeImageFile)) {
    //         $resizedImage['large'] = $largeImageFilePath;
    //     }

    //     $extraLargeImageFilePath  = 'images/product/xlarge/' . $name;
    //     $size = explode('x', ProductGalley::EXTRA_LARGE);
    //     list($width, $height) = $size;

    //     $extraLargeImageFile = Image::make($file)->fit($width, $height)->stream();
    //     if (Storage::put('public/' . $extraLargeImageFilePath, $extraLargeImageFile)) {
    //         $resizedImage['extra_large'] = $extraLargeImageFilePath;
    //     }

    //     return $resizedImage;
    // }
}
