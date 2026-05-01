<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceApartment extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'maintenance_apartment';

    // Define the fillable properties (columns you want to mass assign)
    protected $fillable = [
        'maintenance_management_id',
        'apartment_management_id',
        'cost',
        'payment_date',
        'payment_proof',
        'paid_status',
    ];

    /**
     * Get the maintenance management record associated with this apartment.
     */
    public function maintenanceManagement()
    {
        return $this->belongsTo(MaintenanceManagement::class, 'maintenance_management_id');
    }

    /**
     * Get the apartment associated with this maintenance apartment record.
     */
    public function apartment()
    {
        return $this->belongsTo(ApartmentManagement::class, 'apartment_management_id');
    }

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'apartment_tenant', 'apartment_id', 'tenant_id');
    }

    public function paymentGateways(): HasOne
    {
        return $this->hasOne(PaymentGatewayCredential::class, 'society_id', 'society_id')->withoutGlobalScopes();
    }


}
