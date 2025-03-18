<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'doctor_id', 'patient_id', 'appointment_time', 'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'appointment_time' => 'datetime',
    ];

    /**
     * Relationship to the Doctor model.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Relationship to the Patient model.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Set default status to pending.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (!$appointment->status) {
                $appointment->status = 'pending'; // Default status
            }
        });
    }
}
