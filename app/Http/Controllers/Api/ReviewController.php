<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Review;
class ReviewController extends Controller
{
/**
 * @OA\Post(
 *     path="/api/product/rating",
 *     summary="add product rating",
 *     tags={"Products"},
 *     security={{"bearer_token":{}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="product_id",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="rating",
 *                     type="double"
 *                 ),
 *                 @OA\Property(
 *                     property="comments",
 *                     type="string"
 *                 ),
 *                 example={"product_id":"1", "rating": "3.5","comments":"This product looks fine"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Examples(example="result", value={"status": true,"message": "product review added successfully"}, summary="An result object.")
 *         )
 *     )
 * )
 */
public function create(Request $request){
    try{

        $user = $request->user();
        $product = Product::find( $request->product_id );
        if(!$product){
            return response()->json(['status' => false,'message' =>'Product not found'], 400);
        }

        $review = Review::where(['product_id'=> $request->prodcut_id, 'user_id'=> $user->id])->first();
        if(!$review){
            return response()->json(['status' => false,'message' =>'You already added review for this product.'], 400);
        }

        Review::create(array_merge($request->all(), ['user_id' => $user->id]));

        return response()->json(['status' => true,'message' => 'Product review added successfully.'], 201);
    } catch (\Throwable $th) {
        \Log::error($th->getMessage());
        return response()->json(['status' => false,'message' => $th->getMessage()], 500);
    }
}
}
