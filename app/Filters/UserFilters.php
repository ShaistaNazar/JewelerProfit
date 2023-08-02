<?php

namespace App\Filters;

use Carbon\Carbon;

class UserFilters extends QueryFilters
{
    public function name($value)
    {
        $names = preg_split('/[\s]+/', $value);

        if (!isset($names[1])) {
            return $this->builder->where(function ($query) use ($value) {
                $query
                    ->where('FirstName', 'like', '%' . $value . '%')
                    ->orWhere('LastName', 'like', '%' . $value . '%');
            });
        }

        return $this->builder->where(function ($query) use ($names) {
            $query
                ->where('FirstName', 'like', '%' . $names[0] . '%')
                ->where('LastName', 'like', '%' . $names[1] . '%');
        });
    }
    
    
}
