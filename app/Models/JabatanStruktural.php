<?php

namespace App\Models;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JabatanStruktural extends Model
{
    use HasFactory;

    protected $table = 'jabatan_strukturals';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_jabatan',
        'keterangan'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }


}
