<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/products",
     * summary="Get products",
     * tags={"Products"},
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *
     *    @OA\JsonContent(
     *
     *       @OA\Property(property="status", type="string", example="Success"),
     *       @OA\Property(property="message", type="string", example=""),
     *      ),
     *    )
     * )
     *)
     */
    public function get(Request $request){
        $coll = Product::query();
        if($request->filled('keyword')){
            $keyword = $request->keyword;
            $coll->where('title','like', "%$keyword%");
        }
        $products = $coll->orderBy('title','ASC')->paginate(50);
        return response()->json(['status' => true,'data' => $products]);
    }
/**
 * @OA\Post(
 *     path="/api/product/create",
 *     summary="Create new product",
 *     tags={"Products"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string"
 *                 ),
 *                 example={"title":"Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops", "category": "men's clothing", "price": "109.95","image":"https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg","description":"Your perfect pack for everyday use and walks in the forest. Stash your laptop (up to 15 inches) in the padded sleeve, your everyday"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Examples(example="result", value={"status": true,"message": "product Created Successfully"}, summary="An result object.")
 *         )
 *     )
 * )
 */
    public function create(Request $request){
        try{
            Product::create($request->all());
            return response()->json(['status' => true,'message' => 'Product created successfully.'], 201);
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return response()->json(['status' => false,'message' => $th->getMessage()], 500);
        }
    }
}
