<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Enum\EnumStatus;

class Product extends Model
{
    protected $fillable = [
        'name',
        'value',
        'store_id',
        'active'
    ];

    protected $appends = [
        'statusName',
    ];

    public function getStatusNameAttribute()
    {
        return EnumStatus::STATUS[$this->active];
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }


}
