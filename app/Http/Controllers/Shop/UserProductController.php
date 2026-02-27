<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    //Whishlist List
    public function wishlist(Request $request)
    {
        $user = $request->user();

        $wishlist = $user->wishlist()->with('product')->paginate(10);

        return response()->json($wishlist);
    }
}
