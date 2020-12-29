<?php

namespace App\Http\Controllers; 
use App\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function showAllProduct()
    {
        return response()->json(Product::all());
    }

    public function showOneProduct($id)
    {
        return response()->json(Product::find($id));
    }

    // public function create(Request $request)
    // {


    //     $this->validate($request, [
    //         'name' => 'required',
    //         'code' => 'required|numeric',
    //         'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
    //         'category' => 'required',  
    //     ]);
        
    //     $product = Product::create($request->all());

    //     return response()->json($product, 201);
    // }


    // public function createTwo(Request $request)
    // {

    //     $response = null;
    //     $product = (object) ['image' => ""];

    //     // $this->validate($request, [
    //     //     'name' => 'required',
    //     //     'code' => 'required|numeric',
    //     //     'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
    //     //     'category' => 'required',  
    //     // ]);
        
    //     // $product = Product::create($request->all());
    //     // $image = $request->file('image');
    //     // return response()->json(file_get_contents($request->image));
    //     // $avatar = $request->file('image');
    //     // return response()-> $avatar;
        
    //     // $product = Product::create($request->all());

    //     // return response()->json($product, 201);

    //     if ($request->hasFile('image')) {
           

    //           $original_filename = $request->file('image')->getClientOriginalName();
    //            $original_filename_arr = explode('.', $original_filename);
    //          $file_ext = end($original_filename_arr);

    //          $destination_path = base_path().'\public\images';
    //            //return response()->json(  $destination_path);
    //         $image = 'U-' . time() . '.' . $file_ext;
    //     //    return response()->json($image);
    //     //    return response()->json($original_filename_arr);
    //     // return File::put($path , $data);
    //                  if ($request->file('image')->put( $destination_path, $image)) {
    //                      $product->image = '/public/images/' . $image;
    //                      response()->json($product);
    //                 } else {
    //                      response()->json('Cannot upload file');
    //                   }
    //        return response()->json('File   found !! ');
    //      } else {
    //         //  return response()->json('File not found');
    //    } 
    //     // return response()->json($request->image, 201);
    // }

    public function create(Request $request) {
    $response = null;
    $productImage = (object) ['image' => ""];


        
    if ($request->hasFile('image')) {
        $original_filename = $request->file('image')->getClientOriginalName();
        $original_filename_arr = explode('.', $original_filename);
        $file_ext = end($original_filename_arr);
        $destination_path = base_path().'\public\images';
        $reqimage = 'U-' . time() . '.' . $file_ext;

        if ($request->file('image')->move($destination_path, $reqimage)) {
            $productImage->image =  url().'/images/'. $reqimage;
            // return response()->json($productImage);
        } else {
            return response()->json('Cannot upload file');
        }
    } else {
        return response()->json('File not found');
    }

    $this->validate($request, [
        'name' => 'required',
        'code' => 'required|numeric',
        'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
        'category' => 'required',  
    ]);
    $name = $request->name;
    $code = $request->code;
    $description = $request->description;
    $price = $request->price;
    $category = $request->category;
    $image = $reqimage; 
    $product = Product::create([
        'name' => $name,
        'description' => $description,
        'code' => $code,
        'price' => $price,
        'category' => $category,
        'image' => $productImage->image,
    
    ]);
    return response()->json($product, 201);
}
    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json($product, 200);
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
