<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission

{
    use HasFactory;

    public function scopeFilterName($query, $filter)
    {
        if (trim($filter)) {
            return $query->where('name', 'like', "%{$filter}%");
        }
        return $query;
    }

  }

