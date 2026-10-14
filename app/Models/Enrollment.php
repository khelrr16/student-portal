<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_session_id',
        'reference_code',
        'first_name',
        'middle_name',
        'last_name',
        'extension_name',
        'sex',
        'birthday',
        'birthplace',
        'nationality',
        'civil_status',
        'religion',
        'contact_number',
        'address',
        'lrn',
        'last_school_attended',
        'last_year_attended',
        'highest_educational_attained',
        'shs_level',
        'strand',
    ];

    protected function casts(): array
    {
        return [
            'birthday' => 'date',
        ];
    }

    public function admissionSession(): BelongsTo
    {
        return $this->belongsTo(AdmissionSession::class);
    }

    public function fullName(): string
    {
        return collect([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
            $this->extension_name,
        ])->filter()->implode(' ');
    }
}
