<?php

namespace App\Traits;

trait CommonQueryScopes
{
    // Filter tasks or projects by status
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Search tasks or projects by title
    public function scopeSearchByTitle($query, $title)
    {
        return $query->where('title', 'like', "%$title%");
    }
}
