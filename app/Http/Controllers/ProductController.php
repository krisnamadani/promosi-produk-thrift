<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data['data'] = Product::all();
        $data['admin'] = Admin::all();

        return view('product', $data);
    }

    public function store(Request $request)
    {
        $photo = $request->file('photo');
        $photo_name = time() . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path('product'), $photo_name);
        
        $data = [
            'admin_id' => $request->admin_id,
            'photo' => $photo_name,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'price' => $request->price,
            'material' => $request->material,
            'color' => $request->color,
            'size' => $request->size,
            'brand' => $request->brand,
        ];

        Product::create($data);

        return response()->json([
            'status' => 'success',
            'title' => 'Tersimpan!',
            'message' => 'Data telah disimpan.',
            'icon' => 'success',
        ]);
    }

    public function edit(Request $request)
    {
        $data = Product::find($request->id);

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $data = Product::where('id', $request->id)->first();

        if ($request->file('photo')) {
            $photo = $request->file('photo');
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('product'), $photo_name);

            $data->photo = $photo_name;
        }

        $data->name = $request->name;
        $data->description = $request->description;
        $data->type = $request->type;
        $data->price = $request->price;
        $data->material = $request->material;
        $data->color = $request->color;
        $data->size = $request->size;
        $data->brand = $request->brand;

        $data->save();

        return response()->json([
            'status' => 'success',
            'title' => 'Diperbarui!',
            'message' => 'Data telah diperbarui.',
            'icon' => 'success',
        ]);
    }

    public function delete(Request $request)
    {
        $data = Product::find($request->id);

        $data->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Terhapus!',
            'message' => 'Data telah dihapus.',
            'icon' => 'success',
        ]);
    }
}
