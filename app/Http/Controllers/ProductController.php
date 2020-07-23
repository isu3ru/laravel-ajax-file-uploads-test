<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        $title = $request->title;
        $serial_no = $request->serial_no;
        $image1 = $request->file('image1')->store('public/uploads');
        $image2 = $request->file('image2')->store('public/uploads');

        // persist data
        Product::create([
           'title' => $title,
           'serial_no' => $serial_no,
           'image1' => basename($image1),
           'image2' => basename($image2),
        ]);

        return ['status' => 'success'];
    }

    public function getProducts()
    {
        return Product::all();
    }
}
