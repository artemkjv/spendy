<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'account',
        'team',
        'team_position',
        'traffic_source',
        'traffic_vertical',
    ];

    public static function paginate() {
        return self::query()
            ->orderByDesc('id')
            ->paginate()
            ->appends(request()->except('page'));
    }

}
