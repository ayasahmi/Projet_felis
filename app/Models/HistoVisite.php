<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoVisite extends Model
{
    use HasFactory;
    protected $table = 'Histo_visite';
    public $timestamps = false;

    public function visite()
    {
        return $this->belongsTo(Visite::class, 'VisiteID');
    }

    public function historique()
    {
        return $this->belongsTo(Historique::class, 'HistoriqueID');
    }
}
