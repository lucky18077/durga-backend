<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierUsers extends Model
{
    protected $primaryKey = "id";
    protected $table = "supplier_users";
    public function supplier_role()
    {
        return $this->belongsTo(SupplierRole::class, 'role_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(SupplierUsers::class, 'parent_id');
    }

    // Get the children of this user
    public function children()
    {
        return $this->hasMany(SupplierUsers::class, 'parent_id');
    }
}
