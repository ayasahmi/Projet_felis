<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Models\Utilisateur;

class AuthentificationController extends Controller{
    public function registerUtil(Request $request){
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'mail' => 'required|string|email|max:60|unique:utilisateurs',
            'motdepasse' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:50',
            'role' => 'required|in:Super-Admin,Admin,Back-office,Manager,Merchandiser',
            'photo_user' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Nbr_users' => 'required|integer',
            'type_souscription' => 'required|string|max:50',
            'nomentreprise' => 'required|string|max:50',
            'adresse' => 'required|string|max:50',
            'ville' => 'required|string|max:50',
            'date_creation' => 'required|date',
            'statut_activation' => 'required|string|max:50',
        ]);

        $photoPath = $request->hasFile('photo_user') ? $request->file('photo_user')->store('photos', 'public') : null;

        $utilisateur = Utilisateur::create(array_merge($validated, [
            'motdepasse' => Hash::make($request->motdepasse),
            'photo_user' => $photoPath,
            'date_creation' => now(),
            'statut_activation' => 'activé',
            'date_expiration' => $request->role === 'Administrateur' ? now()->addDays(13) : null,
        ]));

        return response()->json(['success' => 'Votre compte a été créé avec succès.'], 201);
    }
    public function loginUtil(Request $request){
        $validated = $request->validate([
            'mail' => 'required|string',
            'password' => 'required|string',
        ]);

        $utilisateur = Utilisateur::where('mail', $validated['mail'])->first();

        if ($utilisateur && Hash::check($validated['password'], $utilisateur->motdepasse)) {
            $request->session()->put('loginId', $utilisateur->id);

            $responseData = match($utilisateur->role) {
                'Merchandiser', 'Manager', 'Back-office', 'Administrateur', 'Super-Admin' => [
                    'redirect' => strtolower($utilisateur->role) . '.profil',
                    'role' => $utilisateur->role
                ],
                default => ['fail' => 'Role not defined']
            };
            if ($utilisateur->role === 'Administrateur' && now()->greaterThan($utilisateur->date_expiration)) {
                $responseData['redirect'] = 'admin.souscription';
            }
            return response()->json($responseData);
        }
        return response()->json(['fail' => 'Les informations de connexion sont incorrectes.'], 401);
    }
}
