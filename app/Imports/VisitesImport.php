<?php
namespace App\Imports;

use App\Models\Visite;
use Maatwebsite\Excel\Concerns\ToModel;

class VisitesImport implements ToModel
{
    public function model(array $row)
    {
        return new Visite([
            'date_planifiee'   => $row[0],
            'heure_debut'      => $row[1],
            'heure_fin'        => $row[2],
            'pointeID'         => $row[3],
            'UtilisateurID'    => $row[4],
            'statut'           => 'planifiee',
        ]);
    }
}
