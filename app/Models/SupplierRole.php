<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierRole extends Model
{
    protected $primaryKey = "id";
    protected $table = "supplier_role";
    public function supplier_users()
    {
        return $this->hasMany(SupplierUsers::class, 'role_id', 'id');
    }
}
