<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\utils\imageupload;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allProduct()
    {
        $all_product = Product::all();
        foreach ($all_product as $product) {
            $product->image = asset('images/' . $product->image);
        }
        return response()->json($all_product);
    }

    public function addProduct(ProductRequest $request, $id)
    {
        $product = $request->all();
        if ($image = $request->file('image')) {
            $product['image'] = (new imageupload)->uploadimage($image);
        }
        $parts = explode(",", $product['data']);
        $convertedData = [];
        foreach ($parts as $part) {
            $keyValue = explode(":", $part);
            $key = trim($keyValue[0]);
            $value = trim($keyValue[1]);
            $convertedData[$key] = $value;
        }
        $product['company_id'] = $id;
        $product['data'] = $convertedData;
        $product['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $product['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        Product::create($product);
        return response()->json(__('words.The product has been added successfully'));
    }

    public function showProduct($id)
    {
        $product = Product::find($id);
        $product->image = asset('images/' . $product->image);
        return response()->json([$product]);
    }


    public function editProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if ($image = $request->file('image')) {
            $product['image'] = (new imageupload)->uploadimage($image);
        } else {
            unset($product['image']);
        }
        if ($request->has('price')) {
            $product->price = $request->input('price');
        }
        if ($request->has('quantity')) {
            $product->quantity = $request->input('quantity');
        }
        if ($request->has('data')) {
            $product->data = $request->input('data');
            $parts = explode(",", $product['data']);
            $convertedData = [];
            foreach ($parts as $part) {
                $keyValue = explode(":", $part);
                $key = trim($keyValue[0]);
                $value = trim($keyValue[1]);
                $convertedData[$key] = $value;
            }
            $product['data'] = $convertedData;
        }
        $update = $product->save();
        if ($update) {
            return response()->json(__('words.product  has been modified'), 200);
        } else {
            return response()->json(__('words.Failed to edit the product'), 500);
        }
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json('success');
    }
}
