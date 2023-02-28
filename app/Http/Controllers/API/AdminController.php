<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function tambah_produk(Request $request)
    {
        try
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
    
            $product = Product::create($data);
    
            return response()->json([
                'status' => 201,
                'message' => 'product created',
                'data' => $product,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'product failed to create',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function register(Request $request)
    {
        try
        {
            $photo = $request->file('photo');
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('admin'), $photo_name);
            
            $data = [
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'photo' => $photo_name,
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'phone' => $request->phone,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ];
    
            $admin = Admin::create($data);
    
            return response()->json([
                'status' => 201,
                'message' => 'admin created',
                'data' => $admin,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'admin failed to create',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function login(Request $request)
    {
        try
        {
            $admin = Admin::where('email', $request->email)->first();
    
            if ($admin) {
                if (password_verify($request->password, $admin->password)) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'login success',
                        'data' => $admin,
                    ]);
                } else {
                    return response()->json([
                        'status' => 401,
                        'message' => 'login failed',
                        'data' => null,
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'login failed',
                    'data' => null,
                ]);
            }
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'login failed',
                'data' => $th->getMessage(),
            ]);
        }
    }
}
