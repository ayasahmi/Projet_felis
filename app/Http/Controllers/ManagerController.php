<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointDeVente;
use App\Models\VisiteData;

class ManagerController extends Controller
{
    public function bibliothequeImages($pointeID)
    {
        $pointDeVente = Pointdevente::findOrFail($pointeID);
        $visiteDatas = VisiteData::where('pointeID', $pointeID)->get();
        $images = $visiteDatas->map(function ($visiteData) {
            return [
                'image_id' => $visiteData->ImageID,
                'url_image' => $visiteData->url_image,
                'type_data' => $visiteData->type_data,
                'date_image' => $visiteData->date_image,
                'facing' => $visiteData->facing,
                'stock' => $visiteData->stock,
                'position_rack' => $visiteData->position_rack
            ];
        });
        $data = [
            'point_de_vente' => [
                'id' => $pointDeVente->id,
                'nom' => $pointDeVente->nom
            ],
            'images' => $images
        ];
        return response()->json($data);
    }
}
