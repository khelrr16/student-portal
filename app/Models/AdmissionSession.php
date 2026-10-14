<?php

namespace App\Models;

use App\Enums\AdmissionSessionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdmissionSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'deadline',
        'status',
        'public_token',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'status' => AdmissionSessionStatus::class,
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function hasExpired(): bool
    {
        return $this->deadline->isPast();
    }

    public function isOpenForEnrollment(): bool
    {
        return $this->status === AdmissionSessionStatus::ACTIVE && ! $this->hasExpired();
    }

    public function closeIfExpired(): bool
    {
        if ($this->status !== AdmissionSessionStatus::ACTIVE || ! $this->hasExpired()) {
            return false;
        }

        $this->forceFill(['status' => AdmissionSessionStatus::ENDED])->saveQuietly();

        return true;
    }

    public function effectiveStatus(): AdmissionSessionStatus
    {
        return $this->isOpenForEnrollment()
            ? AdmissionSessionStatus::ACTIVE
            : AdmissionSessionStatus::ENDED;
    }
}
