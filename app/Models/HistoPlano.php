<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoPlano extends Model
{
    use HasFactory;
    protected $table = 'Histo_plano';
    public $timestamps = false;

    public function planogramme()
    {
        return $this->belongsTo(Planogramme::class, 'PlanoID');
    }

    public function historique()
    {
        return $this->belongsTo(Historique::class, 'HistoriqueID');
    }
}
