<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function user(){
        $this->belongsTo(User::class , 'user_id');
    }
}
