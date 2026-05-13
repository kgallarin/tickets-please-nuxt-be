<?php

namespace App\Http\Filters\Api\v1;

class AuthorFilter extends QueryFilter {
    protected $sortable = [
        'name',
        'email',
        'updated_at',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];

    public function include($value) {
        return $this->builder->with($value);
    }

    // query set of ids where we can use the database column: whereIn('id')
    public function id($value) {
        // return $this->builder->where('id', $value);
        return $this->builder->whereIn('id', explode(',', $value));
    }

    // we can filter based upon a partial email
    public function email($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('email', 'like', $likeStr);
    }

    // same above for name
    public function name($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('name', 'like', $likeStr);
    }

    public function updatedAt($value) {
        $dates = explode(',', $value);

        if(count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }

    public function createdAt($value) {
        $dates = explode(',', $value);

        if(count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }
}
