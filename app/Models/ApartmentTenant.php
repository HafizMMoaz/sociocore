<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApartmentTenant extends Model
{
    use HasFactory;

    protected $table = 'apartment_tenant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'apartment_id',
    ];

    /**
     * Get the tenant associated with this record.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the apartment associated with this record.
     */
    public function apartment()
    {
        return $this->belongsTo(ApartmentManagement::class);
    }
}
