<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;

class RoleHelper
{

    public static function SuperAdmin()
    {
        if (Auth::guard('api')->check() && (Auth::guard('api')->user()->role == 1)) {
            return true;
        }

        return false;
    }
    
    public static function Admin()
    {
        if (Auth::guard('api')->check() && (Auth::guard('api')->user()->role == 2)) {
            return true;
        }

        return false;
    }
  
}
