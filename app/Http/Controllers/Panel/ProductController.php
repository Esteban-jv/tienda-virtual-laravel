<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\PanelProduct;
use App\Models\Scopes\AvailableScope;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function index()
    {
        return view('products.index')->with([
            'products' => PanelProduct::without('images')->get()
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        /*$rules = [
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:1000'],
            'price' => ['required', 'min:1'],
            'stock' => ['required', 'min:0'],
            'status' => ['required', Rule::in(['available', 'unavailable']),],
        ];
        request()->validate($rules);*/
        /*$product = Product::create([
            'title' => request()->title,
            'description' => request()->description,
            'price' => request()->price,
            'stock' => request()->stock,
            'status' => request()->status,
        ]);*/
        /* Create trabaja con filable del modelo */

//        dd(request()->all(), $request->all(), $request->validated());

        /*if(request()->status == 'available' && request()->stock == 0)
        {
            // no se elimina automáticamente
//            session()->put('error','Si está disponible debe tener stock');
//            session()->flash('error','Si está disponible debe tener stock');

            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors('Si está disponible debe tener stock');
        }*/
        $product = PanelProduct::create($request->validated());
//        session()->flash('success',"Se ha creado el producto {$product->title}");
        // decrapped
//        return $product;

//        return redirect()->back();
//        return redirect()->action('ProductController@index');

        foreach ($request->images as $image) {
            $product->images()->create([
                'path' => 'images/'.$image->store('products','images')
            ]);
        }

        return redirect()
            ->route('products.index')
            ->withSuccess("Se ha agregado el producto {$product->title}");
    }

    public function edit(PanelProduct $product)
    {
        return view('products.edit')->with([
            'product' => $product
        ]);
    }

    public function show(PanelProduct $product)
    {
        return view('products.show')->with([
            'product' => $product
        ]);
    }

    public function update(ProductRequest $request, PanelProduct $product)
    {
        $product->update($request->validated());

        if($request->hasFile('images'))
        {
            // Eliminar los anteriores
            foreach ($product->images as $image)
            {
                $path = storage_path("app/public/{$image->path}");
                File::delete($path);
                $image->delete();
            }

            // Crear imágenes
            foreach ($request->images as $image) {
                $product->images()->create([
                    'path' => 'images/'.$image->store('products','images')
                ]);
            }
        }

        return redirect()
            ->route('products.index')
            ->withSuccess("Se ha editado el producto {$product->title}");
    }

    public function destroy(PanelProduct $product)
    {
        $product->delete();
        return redirect()
            ->route('products.index')
            ->withSuccess("Se ha eliminado el producto {$product->title}");
    }

    public function welcome()
    {
//        \DB::connection()->enableQueryLog();
//        $products = Product::available()->get(); //No es necesario por el scope global
//        $products = Product::with('images')->get(); // Solución en with del modelo (leccion 82)
        $products = Product::all();
        return view('welcome')->with([
            'products' => $products
        ]);
    }
}
