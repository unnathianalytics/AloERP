<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $fillable = [
        'op_number',
        'name',
        'gender',
        'address',
        'mobile',
        'address',
        'dob',
        'occupation',
        'referred_by',
        'image',
        'user'
    ];


    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function scopeNewOpNumber()
    {
        $count = $this->where(
            'created_at',
            '>',
            Carbon::createFromFormat('Y-m-d H:i:s', now())->year,
        )->count() + 1;

        return "OP" . $count . '/' . date('Y');
    }
}
