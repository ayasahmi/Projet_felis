<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoVisiteData extends Model
{
    use HasFactory;
    protected $table = 'histo_visite_data';
    public $timestamps = false;
    public function visiteData()
    {
        return $this->belongsTo(VisiteData::class, 'ImageID');
    }

    public function historique()
    {
        return $this->belongsTo(Historique::class, 'HistoriqueID');
    }
}
