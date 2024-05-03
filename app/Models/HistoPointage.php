<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoPointage extends Model
{
    use HasFactory;
    protected $table = 'Histo_pointage';
    public $timestamps = false;

    public function pointage()
    {
        return $this->belongsTo(Pointage::class, 'PointageID');
    }

    public function historique()
    {
        return $this->belongsTo(Historique::class, 'HistoriqueID');
    }
}
