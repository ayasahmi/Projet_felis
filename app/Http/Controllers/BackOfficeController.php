<?php

namespace App\Http\Controllers;

use App\Models\Pointage;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\PointDeVente;
use App\Models\Visite;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VisitesImport;

class BackOfficeController extends Controller
{
    public function planifierVisites(Request $request)
    {
        if ($request->hasFile('visites_excel')) {
            Excel::import(new VisitesImport, $request->file('visites_excel'));
            return response()->json(['success' => 'Visites importées et planifiées avec succès.']);
        }

        $request->validate([
            'visites' => 'required|array',
            'visites.*.date_planifiee' => 'required|date',
            'visites.*.heure_debut' => 'required|date_format:H:i',
            'visites.*.heure_fin' => 'required|date_format:H:i',
            'visites.*.pointeID' => 'required|exists:point_de_vente,pointeID',
            'visites.*.UtilisateurID' => 'required|exists:utilisateurs,UtilisateurID',
            'visites.*.num_semaines' => 'required|integer',
            'visites.*.nom_journée' => 'required|string',
            'visites.*.annee' => 'required|integer'
        ]);

        foreach ($request->visites as $visiteInfo) {
            Visite::create([
                'date_planifiee' => $visiteInfo['date_planifiee'],
                'heure_debut' => $visiteInfo['heure_debut'],
                'heure_fin' => $visiteInfo['heure_fin'],
                'pointeID' => $visiteInfo['pointeID'],
                'UtilisateurID' => $visiteInfo['UtilisateurID'],
                'num_semaines' => $visiteInfo['num_semaines'],
                'nom_journée' => $visiteInfo['nom_journée'],
                'annee' => $visiteInfo['annee'],
                'statut' => 'planifiee',
            ]);
        }
        return response()->json(['success' => 'Visites planifiées avec succès.']);
    }
    public function updateVisite(Request $request, $id)
    {
        $request->validate([
            'date_planifiee' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'pointeID' => 'required|exists:point_de_vente,pointeID',
            'UtilisateurID' => 'required|exists:utilisateurs,UtilisateurID',
            'num_semaines' => 'required|integer',
            'nom_journée' => 'required|string',
            'annee' => 'required|integer'
        ]);

        $visite = Visite::findOrFail($id);
        $visite->update($request->all());

        $now = now();
        if ($visite->date_planifiee > $now) {
            $visite->statut = 'planifiee';
        } elseif ($now >= $visite->heure_debut && $now <= $visite->heure_fin) {
            $visite->statut = 'en cours';
        } elseif ($now > $visite->heure_fin) {
            $visite->statut = 'terminee';
        }
        $visite->save();

        return response()->json(['success' => 'Visite mise à jour avec succès.']);
    }

}
