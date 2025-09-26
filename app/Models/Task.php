<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use App\Traits\CommonQueryScopes; 


class Task extends Model
{  
    use HasFactory,CommonQueryScopes;

    protected $fillable = ['title', 'description', 'status', 'due_date', 'project_id', 'assigned_to', 'created_by'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
