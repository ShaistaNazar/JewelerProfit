<?php

namespace App\Filters;

use Carbon\Carbon;
 
class CustomerFilters extends QueryFilters
{
    public function customer_id($value)
    {
        return $this->builder->where('customer_id', 'like', '%' . $value . '%');
    }

    public function firstname($value)
    {
        return $this->builder->where('firstname', 'like', '%' . $value . '%');
    }

    public function lastname($value)
    {
        return $this->builder->where('lastname', 'like', '%' . $value . '%');
    }

    public function primary_email($value)
    {
        return $this->builder->where('primary_email', 'like', '%' . $value . '%');
    }

    public function cell_phone($value)
    {
        return $this->builder->where('cell_phone', 'like', '%' . $value . '%');
    }
}
