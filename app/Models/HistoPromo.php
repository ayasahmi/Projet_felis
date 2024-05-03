<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoPromo extends Model
{
    use HasFactory;
    protected $table = 'Histo_promo';
    public $timestamps = false;
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'PromotionID');
    }

    public function historique()
    {
        return $this->belongsTo(Historique::class, 'HistoriqueID');
    }
}
