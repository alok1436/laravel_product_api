<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
class UserController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/user",
     * summary="Get logged in user",
     * tags={"Auth"},
     * security={{"bearer_token":{}}},
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
        return response()->json(['status' => true,'data' => $request->user()]);
    } 
}
