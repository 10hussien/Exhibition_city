<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function addFavourite($id)
    {
        Favourite::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $id,
        ]);
        return response()->json(__('words.Added to favorites'));
    }
    public function allFavouriteForUser()
    {
        $user = User::find(Auth::id());
        $favourite = $user->favourite;
        return response()->json($favourite);
    }

    public function allFavouriteForProduct($id)
    {
        $product = Product::find($id);
        $favourite = $product->favourite;
        return response()->json($favourite);
    }
}
