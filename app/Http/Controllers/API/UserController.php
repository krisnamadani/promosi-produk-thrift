<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function home(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $products = Product::get();
        
        $products_with_distance = [];

        foreach($products as $product) {
            $products_with_distance[] = [
                'id' => $product->id,
                'photo' => url('product/' . $product->photo),
                'name' => $product->name,
                'description' => $product->description,
                'type' => $product->type,
                'price' => $product->price,
                'material' => $product->material,
                'color' => $product->color,
                'size' => $product->size,
                'brand' => $product->brand,
                'admin_name' => $product->admin->name,
                'distance' => round($this->haversine($latitude, $longitude, $product->admin->latitude, $product->admin->longitude), 2).' km',
            ];
        }

        return response()->json([
            'status' => 200,
            'message' => 'product list',
            'data' => $products_with_distance,
        ]);
    }

    public function cari(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $search = $request->search;

        $products = Product::where('name', 'like', '%' . $search . '%')
        ->orWhere('description', 'like', '%' . $search . '%')
        ->orWhere('type', 'like', '%' . $search . '%')
        ->orWhere('price', 'like', '%' . $search . '%')
        ->orWhere('material', 'like', '%' . $search . '%')
        ->orWhere('color', 'like', '%' . $search . '%')
        ->orWhere('size', 'like', '%' . $search . '%')
        ->orWhere('brand', 'like', '%' . $search . '%')
        ->get();
        
        $products_with_distance = [];

        foreach($products as $product) {
            $products_with_distance[] = [
                'id' => $product->id,
                'photo' => url('product/' . $product->photo),
                'name' => $product->name,
                'description' => $product->description,
                'type' => $product->type,
                'price' => $product->price,
                'material' => $product->material,
                'color' => $product->color,
                'size' => $product->size,
                'brand' => $product->brand,
                'admin_name' => $product->admin->name,
                'distance' => round($this->haversine($latitude, $longitude, $product->admin->latitude, $product->admin->longitude), 2).' km',
            ];
        }

        return response()->json([
            'status' => 200,
            'message' => 'product list',
            'data' => $products_with_distance,
        ]);
    }

    public function toko(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $admins = Admin::get();

        $admins_with_distance = [];

        foreach($admins as $admin) {
            $admins_with_distance[] = [
                'id' => $admin->id,
                'photo' => url('admin/' . $admin->photo),
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'address' => $admin->address,
                'latitude' => $admin->latitude,
                'longitude' => $admin->longitude,
                'distance' => round($this->haversine($latitude, $longitude, $admin->latitude, $admin->longitude), 2).' km',
                // 'distance' => $this->haversine($latitude, $longitude, $admin->latitude, $admin->longitude),
            ];
        }

        return response()->json([
            'status' => 200,
            'message' => 'admin list',
            'data' => $admins_with_distance,
        ]);
    }

    function haversine($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        if($latitudeFrom == null || $longitudeFrom == null || $latitudeTo == null || $longitudeTo == null) {
            return 0;
        }

        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
        
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        $distance = $angle * 6371;
        
        return $distance;
    }

    public function detail_produk(Request $request, $id)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $product = Product::with('admin')->find($id);
        $product->photo = url('product/' . $product->photo);
        $product->distance = round($this->haversine($latitude, $longitude, $product->admin->latitude, $product->admin->longitude), 2).' km';

        return response()->json([
            'status' => 200,
            'message' => 'product detail',
            'data' => $product,
        ]);
    }

    public function detail_toko(Request $request, $id)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $admin = Admin::find($id);
        $admin->photo = url('admin/' . $admin->photo);
        $admin->distance = round($this->haversine($latitude, $longitude, $admin->latitude, $admin->longitude), 2).' km';

        return response()->json([
            'status' => 200,
            'message' => 'admin detail',
            'data' => $admin,
        ]);
    }

    public function produk_toko(Request $request, $id)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $products = Product::where('admin_id', $id)->get();

        $products_with_distance = [];
        
        foreach($products as $product) {
            $products_with_distance[] = [
                'id' => $product->id,
                'photo' => url('product/' . $product->photo),
                'name' => $product->name,
                'description' => $product->description,
                'type' => $product->type,
                'price' => $product->price,
                'material' => $product->material,
                'color' => $product->color,
                'size' => $product->size,
                'brand' => $product->brand,
                'admin_name' => $product->admin->name,
                'distance' => round($this->haversine($latitude, $longitude, $product->admin->latitude, $product->admin->longitude), 2).' km',
            ];
        }

        return response()->json([
            'status' => 200,
            'message' => 'product list from admin',
            'data' => $products_with_distance,
        ]);
    }
}
