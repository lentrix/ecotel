<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Log extends Model
{
    // use HasFactory;

    protected $fillable = ['user_id','description','table','ref_no'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function getReferenceObjectAttribute() {
        return DB::table($this->table)->where('id', $this->ref_no)->first();
    }
}
