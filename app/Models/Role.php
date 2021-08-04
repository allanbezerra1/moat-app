<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole

{
    use HasFactory;

    const managerId = 1;
    const executorId = 2;

    /**
     * Scope a query to get only given name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterName($query, $filter)
    {
        if (trim($filter)) {
            return $query->where('name', 'like', "%{$filter}%");
        }
        return $query;
    }

    /**
     * Get seller name
     * @return String
     */

    public static function executorName()
    {
        $executor = self::find(self::executorId);

        return $executor->name;
    }

    /**
     * Get manager name
     * @return String
     */

    public static function managerName()
    {
        $manager = self::find(self::managerId);

        return $manager->name;
    }
  }

