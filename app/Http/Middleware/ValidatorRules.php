<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidatorRules extends Validator
{
    protected static function GetRulesByTable(String $table)
    {
        $_rulesArray = Array();
        switch ($table) {
            case 'client_stats':
                $_rulesArray = [
                    'instance' => 'required|min:3',
                ];
                break;

            default:
                $_rulesArray =  [];
                break;
        }
        return $_rulesArray;
    }

    public static function MakeValidate(Request $request, String $table)
    {
        return self::make($request->all(), self::GetRulesByTable($table));
    }
}
