<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;




class RegisteredUserController extends Controller
{
    /**
    * Display the registration view.
    */
    public function create(): View
    {
        return view('auth/register', [
            'roles' => Role::All()
        ]);

    }

    /**
    * Handle an incoming registration request.
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'roles' => ['required', 'array', 'min:1'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach($request->roles);


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

public function show(Request $request)
{
    $validation = Validator::make($request->all(), [
        'courriel' => 'required|email',
        'mot_de_passe' => 'required',
        'nom_token' => 'required'
    ], [
        'courriel.required' => 'Veuillez entrer le courriel de l\'utilisateur.',
        'courriel.email' => 'Le courriel de l\'utilisateur doit être valide.',
        'mot_de_passe.required' => 'Veuillez entrer le mot de passe de l\'utilisateur.',
        'nom_token.required' => 'Veuillez inscrire le nom souhaité pour le token.'
    ]);
    if ($validation->fails())
    return response()->json(['ERREUR' => $validation->errors()], 400);

    $contenuDecode = $validation->validated();
    $utilisateur = User::where('email', '=', $contenuDecode['courriel'])->first();


    if (($utilisateur === null) || !Hash::check($contenuDecode['mot_de_passe'], $utilisateur->password))
    return response()->json(['ERREUR' => 'Informations d\'authentification invalides'], 500);

    return response()->json(
        ['SUCCÈS' => $utilisateur->createToken($contenuDecode['nom_token'])->plainTextToken], 200
    );
}
}
