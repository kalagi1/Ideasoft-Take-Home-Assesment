<?php 

namespace App\Http\Responses;

class BaseResponses{
    public static function update($success){
        if($success){
            return response()->json([
                "success" => true,
                "message" => "Başarıyla güncellediniz"
            ]);
        }
    }

    public static function delete($success){
        if($success){
            return response()->json([
                "success" => true,
                "message" => "Başarıyla sildiniz"
            ]);
        }
    }
}