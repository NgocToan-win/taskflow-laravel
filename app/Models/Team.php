<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'created_by'];

    // Một nhóm có nhiều thành viên (users)
    public function members()
    {
        return $this->belongsToMany(User::class, 'team_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    // Lấy thông tin người trưởng nhóm (người tạo)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}