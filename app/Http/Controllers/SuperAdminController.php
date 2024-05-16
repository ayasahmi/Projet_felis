<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\PointDeVente;
use Illuminate\Support\Facades\Session;

class SuperAdminController extends Controller
{
    public function store(Request $request)
    {
        $user = Utilisateur::find(Session::get('loginID'));

        if (!$user || $user->role !== 'super-admin') {
            return response()->json(['error' => 'Action non autorisée.'], 403);
        }

        $request->validate([
            'Nom' => 'required|string',
            'ville' => 'required|string',
            'Adresse' => 'required|string',
            'localisation_long' => 'required',
            'localisation_lat' => 'required',
            'NomEnseigne' => 'required|string',
            'telephone' => 'required|string',
            'email' => 'required|string|email|unique:point_de_vente',
            'coche_par_admin' => 'required|boolean'
        ]);

        $pointDeVente = new PointDeVente([
            'Nom' => $request->Nom,
            'ville' => $request->ville,
            'Adresse' => $request->Adresse,
            'localisation_long' => $request->localisation_long,
            'localisation_lat' => $request->localisation_lat,
            'NomEnseigne' => $request->NomEnseigne,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'coche_par_admin' => $request->coche_par_admin
        ]);
        $pointDeVente->save();
        return response()->json(['success' => 'Nouveau point de vente créé avec succès.'], 201);
    }
    public function gestionSouscriptions(Request $request)
    {
        $user = Utilisateur::find(Session::get('loginID'));

        if (!$user || $user->role !== 'super-admin') {
            return response()->json(['error' => 'Action non autorisée.'], 403);
        }
        $typeSouscription = $request->input('type_souscription');
        $utilisateurs = Utilisateur::where('type_souscription', $typeSouscription)->get();

        return response()->json(['utilisateurs' => $utilisateurs]);
    }
    public function modifierTypeSouscription(Request $request, $UtilisateurID)
    {
        $user = Utilisateur::find(Session::get('loginID'));

        if (!$user || $user->role !== 'super-admin') {
            return response()->json(['error' => 'Action non autorisée.'], 403);
        }
        $utilisateur = Utilisateur::findOrFail($UtilisateurID);

        $nouveauTypeSouscription = $request->input('nouveau_type_souscription');
        $utilisateur->type_souscription = $nouveauTypeSouscription;
        $utilisateur->save();
        return response()->json(['message' => 'Type de souscription modifié avec succès.']);
    }
}
