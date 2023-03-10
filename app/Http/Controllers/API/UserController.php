<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function produk(Request $request)
    {
        try
        {
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            $products = Product::when($request->search, function($query) use($request) {
                $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('description', 'like', '%'.$request->search.'%')
                ->orWhere('type', 'like', '%'.$request->search.'%')
                ->orWhere('price', 'like', '%'.$request->search.'%')
                ->orWhere('material', 'like', '%'.$request->search.'%')
                ->orWhere('color', 'like', '%'.$request->search.'%')
                ->orWhere('size', 'like', '%'.$request->search.'%')
                ->orWhere('brand', 'like', '%'.$request->search.'%');
            })->get();
            
            $products_map = [];

            foreach($products as $product) {
                $products_map[] = [
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
                    'distance' => round($this->haversine($latitude, $longitude, $product->admin->latitude, $product->admin->longitude), 2),
                ];
            }

            $products_map = collect($products_map)->sortBy('distance')->values()->all();

            $products_map2 = [];

            foreach($products_map as $product) {
                $products_map2[] = [
                    'id' => $product['id'],
                    'photo' => $product['photo'],
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'type' => $product['type'],
                    'price' => $product['price'],
                    'material' => $product['material'],
                    'color' => $product['color'],
                    'size' => $product['size'],
                    'brand' => $product['brand'],
                    'admin_name' => $product['admin_name'],
                    'distance' => $product['distance'].' km',
                ];
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $products_map2,
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $e->getMessage(),
            ]);
        }
    }

    public function produk_detail(Request $request, $id)
    {
        try
        {
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            $product = Product::with('admin')->find($id);
            $product->photo = url('product/' . $product->photo);
            $product->distance = round($this->haversine($latitude, $longitude, $product->admin->latitude, $product->admin->longitude), 2).' km';
            $product->latitude = $latitude;
            $product->longitude = $longitude;

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $product,
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $e->getMessage(),
            ]);
        }
    }

    public function toko(Request $request)
    {
        try
        {
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            $admins = Admin::get();
            
            $admins_map = [];

            foreach($admins as $admin) {
                $admins_map[] = [
                    'id' => $admin->id,
                    'photo' => url('admin/' . $admin->photo),
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'phone' => $admin->phone,
                    'address' => $admin->address,
                    'latitude' => $admin->latitude,
                    'longitude' => $admin->longitude,
                    'distance' => round($this->haversine($latitude, $longitude, $admin->latitude, $admin->longitude), 2).' km',
                ];
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $admins_map,
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $e->getMessage(),
            ]);
        }
    }

    public function toko_detail(Request $request, $id)
    {
        try
        {
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            $admin = Admin::find($id);
            $admin->photo = url('admin/' . $admin->photo);
            $admin->distance = round($this->haversine($latitude, $longitude, $admin->latitude, $admin->longitude), 2).' km';

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $admin,
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $e->getMessage(),
            ]);
        }
    }

    public function toko_produk(Request $request, $id)
    {
        try
        {
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            $products = Product::where('admin_id', $id)->get();
            
            $products_map = [];

            foreach($products as $product) {
                $products_map[] = [
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
                'message' => 'success',
                'data' => $products_map,
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $e->getMessage(),
            ]);
        }
    }

    function haversine($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        if($latitudeFrom == null || $longitudeFrom == null || $latitudeTo == null || $longitudeTo == null)
        {
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
}
