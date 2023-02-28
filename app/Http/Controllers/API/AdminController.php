<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        try
        {
            $admin = Admin::where('email', $request->email)->first();
    
            if ($admin) {
                if (password_verify($request->password, $admin->password)) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'success',
                        'data' => $admin,
                    ]);
                } else {
                    return response()->json([
                        'status' => 401,
                        'message' => 'failed',
                        'data' => null,
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'failed',
                    'data' => null,
                ]);
            }
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
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
                'message' => 'success',
                'data' => $admin,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }
    
    public function produk(Request $request)
    {
        try
        {
            $products = Product::where('admin_id', $request->admin_id)->get();

            $products_map = $products->map(function ($product) {
                $product->photo = url('product/' . $product->photo);
                return $product;
            });
    
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $products_map,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function produk_detail($id)
    {
        try
        {
            $product = Product::where('id', $id)->first();

            $product->photo = url('product/' . $product->photo);
    
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $product,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function produk_tambah(Request $request)
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
                'message' => 'success',
                'data' => $product,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function produk_edit(Request $request)
    {
        try
        {
            $product = Product::where('id', $request->id)->first();
    
            if ($request->file('photo')) {
                $photo = $request->file('photo');
                $photo_name = time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('product'), $photo_name);
    
                $product->photo = $photo_name;
            }
    
            $product->name = $request->name;
            $product->description = $request->description;
            $product->type = $request->type;
            $product->price = $request->price;
            $product->material = $request->material;
            $product->color = $request->color;
            $product->size = $request->size;
            $product->brand = $request->brand;
    
            $product->save();
    
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $product,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function produk_hapus(Request $request)
    {
        try
        {
            $product = Product::where('id', $request->id)->first();
    
            $product->delete();
    
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => null,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function profil(Request $request)
    {
        try
        {
            $admin = Admin::where('id', $request->admin_id)->first();

            $admin->photo = url('admin/' . $admin->photo);
    
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $admin,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function profil_edit(Request $request)
    {
        try
        {
            $admin = Admin::where('id', $request->admin_id)->first();
    
            if ($request->file('photo')) {
                $photo = $request->file('photo');
                $photo_name = time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('admin'), $photo_name);
    
                $admin->photo = $photo_name;
            }
    
            $admin->name = $request->name;
            $admin->description = $request->description;
            $admin->address = $request->address;
            $admin->phone = $request->phone;
            $admin->latitude = $request->latitude;
            $admin->longitude = $request->longitude;
    
            $admin->save();
    
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $admin,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => 500,
                'message' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }
}
