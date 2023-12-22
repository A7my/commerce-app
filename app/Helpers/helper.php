<?php
namespace App\Helpers;
use Illuminate\Http\JsonResponse;
class helper
{

function ResponseJson($status,$message,$data=null):JsonResponse{
    $response=[
        'status'=>$status,
        'message'=>$message,
        'data'=>$data
    ];
    return response()->json($response);
}
}
