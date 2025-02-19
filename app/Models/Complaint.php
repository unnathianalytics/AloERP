<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    //

    protected $fillable = [
        'patient_id',
        'case_no',
        'case_date',
        'case_detail',
        'medication',
        'lab_reports',
        'uploads',
        'user'
    ];

    protected $casts = [
        'uploads' => 'array',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function scopeNewCaseNumber(): string
    {
        $count = $this->whereYear(
            'created_at',
            '=',
            Carbon::now()->year,
        )->count() + 1;
        return "CS" . Carbon::now()->year . '/' . $count;
    }
}
