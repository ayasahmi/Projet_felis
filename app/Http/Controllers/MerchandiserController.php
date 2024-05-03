<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visite;
use App\Models\VisiteData;
use App\Models\PointDeVente;
use App\Models\Pointage;
use Illuminate\Support\Facades\Session;

class MerchandiserController extends Controller
{
    public function verifierLocalisation(Request $request)
    {
        return response()->json(['message' => 'Implémentation de la vérification de localisation en cours.']);
    }

    public function consulterPlanning()
    {
        $userId = Session::get('loginID');
        $userLocation = Pointage::where('UtilisateurID', $userId)->latest()->first();
        if (!$userLocation) {
            return response()->json(['error' => 'Localisation non trouvée.'], 404);
        }

        $pointsDeVente = PointDeVente::where('coche_par_admin', true)->pluck('pointeID');
        $visites = Visite::where('UtilisateurID', $userId)
                         ->whereIn('pointeID', $pointsDeVente)
                         ->whereDate('date_planifiee', '>=', now()->toDateString())
                         ->with(['pointDeVente'])
                         ->orderBy('date_planifiee', 'asc')
                         ->get();

        return response()->json(['visites' => $visites]);
    }

    public function enregistrerResultats(Request $request, $visiteId)
    {
        $request->validate([
            'url_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'facing' => 'required|boolean',
            'stock' => 'required|boolean',
            'position_rack' => 'required|boolean',
            'promotion_id' => 'required|integer',
        ]);

        $userId = Session::get('loginID');
        $imagePath = $request->file('url_image')->store('visite_images', 'public');

        $visiteData = new VisiteData();
        $visiteData->url_image = $imagePath;
        $visiteData->facing = $request->facing;
        $visiteData->stock = $request->stock;
        $visiteData->position_rack = $request->position_rack;
        $visiteData->type_data = '';
        $visiteData->date_image = now();
        $visiteData->UtilisateurID = $userId;
        $visiteData->pointeID = Visite::find($visiteId)->pointeID;
        $visiteData->VisiteID = $visiteId;
        $visiteData->PromotionID = $request->promotion_id;
        $visiteData->save();

        return response()->json(['success' => 'Les résultats de la visite ont été enregistrés.']);
    }

    public function marquerPresence($visiteId)
    {
        $user = Session::get('loginID');
        $visite = Visite::findOrFail($visiteId);

        if ($visite->UtilisateurID !== $user->UtilisateurID) {
            return response()->json(['error' => "Cette visite n'est pas pour vous."], 403);
        }

        $pointage = new Pointage();
        $pointage->localisation_long = '';
        $pointage->localisation_lat = '';
        $pointage->tolerance = 0;
        $pointage->presence = 'present';
        $pointage->retard = 'sans retard';
        $pointage->date_arrivee = now();
        $pointage->UtilisateurID = $user->UtilisateurID;
        $pointage->save();
        $visite->statut = 'en cours';
        $visite->save();

        return response()->json(['success' => 'Présence enregistrée.']);
    }

    public function signalerRetard($visiteId)
    {
        $user = Session::get('loginID');
        $visite = Visite::findOrFail($visiteId);
        $currentTime = now();
        if ($visite->UtilisateurID !== $user->UtilisateurID) {
            return response()->json(['error' => "Cette visite n'est pas pour vous."], 403);
        }
        if ($currentTime > $visite->heure_fin) {
            return response()->json(['error' => 'La visite est déjà terminée.'], 409);
        }
        $retard = $currentTime->diffInMinutes($visite->heure_debut);
        $pointage = Pointage::where('UtilisateurID', $user->UtilisateurID)->where('date_arrivee', $visite->date_planifiee)->first();
        if ($pointage) {
            $pointage->retard = "un retard de $retard minutes";
            $pointage->presence = 'present avec retard';
            $pointage->date_depart = $currentTime;
            $pointage->save();
        } else {
            return response()->json(['error' => 'Aucun enregistrement initial trouvé.'], 404);
        }

        return response()->json(['success' => 'Retard signalé avec succès.']);
    }

    public function terminerVisite($visiteId)
    {
        $visite = Visite::findOrFail($visiteId);
        $visite->statut = 'terminée';
        $visite->save();
        return response()->json(['success' => 'Visite terminée avec succès.']);
    }

    public function signalerAbsence($visiteId)
    {
        $user = Session::get('loginID');
        $visite = Visite::findOrFail($visiteId);

        if ($visite->UtilisateurID !== $user->UtilisateurID) {
            return response()->json(['error' => "Cette visite n'est pas pour vous."], 403);
        }

        $pointage = new Pointage();
        $pointage->localisation_long = '';
        $pointage->localisation_lat = '';
        $pointage->tolerance = 0;
        $pointage->presence = 'absent';
        $pointage->date_arrivee = now();
        $pointage->date_depart = now();
        $pointage->UtilisateurID = $user->UtilisateurID;
        $pointage->save();
        $visite->statut = 'annulées';
        $visite->save();

        return response()->json(['success' => 'Absence signalée.']);
    }
}
