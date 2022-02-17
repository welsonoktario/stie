<?php

namespace App\Models;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TenagaKependidikan extends Model
{
    use HasFactory;

    protected $table = 'tenaga_kependidikans';
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'staff_id'
    ];
    protected $guarded = [];

    public function staff(){
        return $this->belongsTo(Staff::class);
    }
}
