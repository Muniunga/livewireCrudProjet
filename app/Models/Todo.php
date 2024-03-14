<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
     protected  $guarded = [];
    // static public function getTodo()
    // {
    //     $return = self::select('todos.*');

    //     $return = $return->orderBy('id', 'desc')
    //         ;

    //     return $return;
    // }
}
