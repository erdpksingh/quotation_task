<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class quotationController extends Controller
{

public function index(request $request){



    // try {
    //     $token = $request->bearerToken();
    //     $user = JWTAuth::parseToken()->authenticate();
    // } catch (JWTException $e) {
    //     return response()->json(['error' => 'Invalid or missing token'], 401);
    // }



    $request->validate([
        "age" => "required",
        "currency_id" => "required",
        "start_date" => "required",
        "end_date" => "required"
    ]);
 
    $ages = explode(',', $request->age);
    $fixedRate = 3;
    
    $ageLoad = [
        '18-30' => 0.6,
        '31-40' => 0.7,
        '41-50' => 0.8,
        '51-60' => 0.9,
        '61-70' => 1.0,
    ];

    
    $total = 0;

    $startDate = $request->start_date;
    $startDateTime = new \DateTime($startDate);
    
    $endDate = $request->end_date;
    $endDateTime = new \DateTime($endDate);

    $tripLength = $startDateTime->diff($endDateTime)->days + 1;
    foreach ($ages as $age) {

        foreach ($ageLoad as $ageRange => $loadFactor) {          
            $rangeValues = explode('-', $ageRange);
            $minAge = $rangeValues[0];
            $maxAge = $rangeValues[1];
    
          
            if ($age >= $minAge && $age <= $maxAge) {
                $cost = $fixedRate * $loadFactor * $tripLength;
                $total = ($total + $cost);
                $found = true;
            }
        }
    }
    
    return response()->json([
        'total' => number_format($total, 2),
        'currency_id' => $request->currency_id,
        'quotation_id' => rand(1, 1000), 
        'status' => 'success',
    ]);
        
  }
}
