<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Produit;
use App\Models\Planogramme;
use App\Models\PointDeVente;
use App\Models\Visite;
use App\Models\CritereClient;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VisitesImport;
use Hash;

class AdminController extends Controller
{
    public function listeUtilisateurs(Request $request){
        $rolesExclus = ['Super-Administrateur'];
        $roleFiltre = $request->query('role');
        $nomFiltre = $request->query('nom');
        $query = Utilisateur::whereNotIn('role', $rolesExclus);
        if ($roleFiltre && in_array($roleFiltre, ['Back-office', 'Manager', 'Merchandiser'])) {
            $query = $query->where('role', $roleFiltre);
        }
        if ($nomFiltre) {
            $query = $query->where(function($q) use ($nomFiltre) {
                $q->where('nom', 'like', "%{$nomFiltre}%")->orWhere('prenom', 'like', "%{$nomFiltre}%");
            });
        }
        $utilisateurs = $query->get();
        return response()->json(['success' => true,'data' => $utilisateurs]);
    }
    public function creerUsers(Request $request) {
        $admin = Session::get('loginID');
        if ($admin->role !== 'Administrateur') {
            return back()->with('error', 'Action non autorisée.');
        }
        if ($admin->Nbr_users <= 0) {
            return back()->with('error', "Nombre maximum d'utilisateurs créés atteint.");
        }
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'mail' => 'required|string|email|max:100|unique:utilisateurs',
            'motdepasse' => 'required|string|min:8',
            'phone' => 'required|string',
            'role' => 'required|string|in:Back-office,Manager,Merchandiser',
            'photo_user' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'adresse' => 'required|string|max:50',
            'ville' => 'required|string|max:50',
            'date_creation' => 'required|date',
            'statut_activation' => 'required|string|max:50',
        ]);
        $utilisateur = new Utilisateur([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'mail' => $request->mail,
            'motdepasse' => Hash::make($request->motdepasse),
            'role' => $request->role,
            'statut_activation' => 'actif'
        ]);
        $utilisateur->save();
        $admin->decrement('Nbr_users');
        return response()->json(['success' => 'utilisateurs aouté']);
    }
    public function updateUser(Request $request, $id) {
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'mail' => 'required|string|email|max:100|unique:utilisateurs',
            'motdepasse' => 'nullable|string|min:6',
            'role' => 'required|string|in:Back-office,Manager,Merchandiser'
        ]);

        $user = Utilisateur::findOrFail($id);
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->mail = $request->mail;
        if ($request->has('motdepasse')) {
            $user->motdepasse = Hash::make($request->motdepasse);
        }
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => 'utilisateurs modifié']);
    }
    public function deleteUser($id) {
        $user = Utilisateur::findOrFail($id);
        $user->delete();
        return response()->json(['success' => 'utilisateurs suppromé']);
    }

    public function getUser(Request $request) {
        return $request->all()['id'];
    }
    public function listeProduits(Request $request)
    {
        $designation = $request->query('designation');
        $categorie = $request->query('categorie');
        $famille = $request->query('famille');
        $sousFamille = $request->query('sous_famille');
        $sousSousFamille = $request->query('sous_sous_famille');
        $query = Produit::query();
        if ($designation) {
            $query->where('designation', 'like', "%{$designation}%");
        }
        if ($categorie) {
            $query->where('categorie', 'like', "%{$categorie}%");
        }
        if ($famille) {
            $query->where('famille', 'like', "%{$famille}%");
        }
        if ($sousFamille) {
            $query->where('sous_famille', 'like', "%{$sousFamille}%");
        }
        if ($sousSousFamille) {
            $query->where('sous_sous_famille', 'like', "%{$sousSousFamille}%");
        }
        $produits = $query->get();
        return response()->json(['success' => true,'data' => $produits]);
    }
    public function creerProduit() {
        $planogrammes = Planogramme::all();
        return response()->json(['success' => true,'message' => 'Planogrammes retrieved successfully','planogrammes' => $planogrammes
        ]);
    }
    public function storeProduit(Request $request) {
        $validatedData = $request->validate([
            'designation' =>'required|string|max:255',
            'prix_unitaire' =>'required|numeric',
            'description' =>'nullable|string',
            'prix_renseigne' =>'nullable|numeric',
            'categorie' =>'required|string|max:255',
            'famille' =>'nullable|string|max:255',
            'sous_famille' =>'nullable|string|max:255',
            'sous_sous_famille' =>'nullable|string|max:255',
            'date_validite' =>'nullable|date',
            'plano_id' =>'nullable|exists:planogrammes,PlanoID',
        ]);

        $produit = new Produit($validatedData);
        $produit->save();
        return response()->json(['success' => true,'message' => 'Produit ajouté avec succès','produit' => $produit]);
    }
    public function editerProduit($id) {
        $produit = Produit::findOrFail($id);
        $planogrammes = Planogramme::all();
        return response()->json(['success' => true,'produit' => $produit,'planogrammes' => $planogrammes]);
    }
    public function updateProduit(Request $request, $id) {
        $validatedData = $request->validate([
            'designation' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric',
            'description' => 'nullable|string',
            'prix_renseigne' => 'nullable|numeric',
            'categorie' => 'required|string|max:255',
            'famille' => 'nullable|string|max:255',
            'sous_famille' => 'nullable|string|max:255',
            'sous_sous_famille' => 'nullable|string|max:255',
            'date_validite' => 'nullable|date',
            'plano_id' => 'nullable|exists:planogrammes,PlanoID',
        ]);

        $produit = Produit::findOrFail($id);
        $produit->update($validatedData);
        return response()->json(['success' => true,'message' => 'Produit modifié avec succès','produit' => $produit]);
    }
    public function deleteProduit($id) {
        $produit = Produit::findOrFail($id);
        $produit->delete();
        return response()->json(['success' => true,'message' => 'Produit supprimé avec succès']);
    }

    public function choixCriteres()
    {
        $criteresAChoisir = ['facing', 'stock', 'prix', 'position_prod', 'shelf_sharing', 'conformite_plano'];
        $classifications = ['categorie', 'famille', 'sous_famille','sous_sous_famille'];
        return response()->json(['success' => true,'criteria' => $criteresAChoisir,'classifications' => $classifications]);
    }
    public function enregistrerCriteres(Request $request, $id_critere)
    {
        $data = $request->validate([
            'facing' => 'boolean',
            'prix' => 'boolean',
            'stock' => 'boolean',
            'position_prod' => 'boolean',
            'shelf_sharing' => 'boolean',
            'conformite_plano' => 'boolean'
        ]);
        $critere = CritereClient::updateOrCreate(
            ['id_critere' => $id_critere],$data
        );

        return response()->json(['success' => true,'message' => 'Critères enregistrés avec succès','data' => [$data,$critere]]);
    }
    public function listerPlanogrammes()
    {
        $planogrammes = Planogramme::all();
        return response()->json(['success' => true,'data' => $planogrammes]);
    }

    public function ajouterPlanogramme(Request $request)
    {
        $request->validate(
            ['Type_plano' => 'required|string|max:50']
        );
        $planogramme = new Planogramme(['Type_plano' => $request->Type_plano]);
        $planogramme->save();
        return response()->json(['success' => true,'message' => 'Planogramme ajouté avec succès','data' => $planogramme], 201);
    }

    public function modifierPlanogramme(Request $request, $id)
    {
        $request->validate([
            'Type_plano' => 'required|string|max:50'
        ]);

        $planogramme = Planogramme::findOrFail($id);
        $planogramme->Type_plano = $request->Type_plano;
        $planogramme->save();

        return response()->json(['success' => true,'message' => 'Planogramme modifié avec succès','data' => $planogramme]);
    }

    public function supprimerPlanogramme($id)
    {
        $planogramme = Planogramme::findOrFail($id);
        $planogramme->delete();

        return response()->json(['success' => true,'message' => 'Planogramme supprimé avec succès']);
    }

    public function listePointDeVente()
    {
        $pointsDeVente = PointDeVente::all();
        return response()->json(['success' => true,'pointsDeVente' => $pointsDeVente]);
    }
    public function cocherPointDeVente(Request $request)
    {
        $request->validate([
            'pointsDeVente' => 'required|array',
            'pointsDeVente.*' => 'exists:point_de_vente,pointeID',
        ]);

        $pointsDeVenteSelectionnes = $request->input('pointsDeVente');
        PointDeVente::whereIn('pointeID', $pointsDeVenteSelectionnes)->update(['coche_par_admin' => true]);

        return response()->json(['success' => true,'message' => 'Points de vente mis à jour avec succès']);
    }
    public function planifierVisites(Request $request)
    {
        if ($request->hasFile('visites_excel')) {
            Excel::import(new VisitesImport, $request->file('visites_excel'));
            return response()->json(['success' => true,'message' => 'Visites importées et planifiées avec succès']);
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
            'visites.*.annee' => 'required|string'
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
        return response()->json(['success' => true,'message' => 'Visites planifiées avec succès']);
    }
    public function editVisite($id)
    {
        $visite = Visite::with('point_de_vente')->findOrFail($id);
        $points_de_vente = PointDeVente::all();
        return response()->json(['success' => true,'visite' => $visite,'points_de_vente' => $points_de_vente]);
    }
    public function updateVisite(Request $request, $id)
    {
        $request->validate([
            'date_planifiee' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'pointeID' => 'required|exists:point_de_vente,pointeID',
            'UtilisateurID' => 'required|exists:utilisateurs,UtilisateurID',
            'num_semaines' => 'required',
            'nom_journée' => 'required',
            'annee' => 'required'
        ]);
        $visite = Visite::findOrFail($id);
        $visite->date_planifiee = $request->date_planifiee;
        $visite->heure_debut = $request->heure_debut;
        $visite->heure_fin = $request->heure_fin;
        $visite->pointeID = $request->pointeID;
        $visite->UtilisateurID = $request->UtilisateurID;
        $visite->num_semaines = $request->num_semaines;
        $visite->nom_journée = $request->nom_journée;
        $visite->annee = $request->annee;
        $now = now();
        if ($visite->date_planifiee > $now) {
            $visite->statut = 'planifiee';
        } elseif ($now >= $visite->heure_debut && $now <= $visite->heure_fin) {
            $visite->statut = 'en cours';
        } elseif ($now > $visite->heure_fin) {
            $visite->statut = 'terminee';
        }
        $visite->save();
        return response()->json(['success' => true,'message' => 'Visite mise à jour avec succès','visite' => $visite]);
    }
}
