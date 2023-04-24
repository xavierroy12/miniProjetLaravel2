<?php

namespace App\Http\Controllers;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\ConfirmationCommentaire;
use Illuminate\Support\Facades\Mail;



class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('commentaire/formulaireCommentaire', [
            'produits' => Produit::All()
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $validation = Validator::make($request->all(), [
            // Vous pouvez combiner plusieurs règles de validation à condition de les séparer par des "|". Les noms
            // clés de ce tableau associatif doivent correspondent aux termes inscrits dans les attributs "name" des
            // balises <input />, <select> et <textearea>.
            'telephone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'sujet' => 'required',
            'produit' => 'required',
            'choix' => 'required',
            'message' => 'required|max:1000',
           ], [
            // Vous pouvez écrire un message d’erreur distinct par règle de validation fournie plus haut.
            'telephone.required' => 'Veuillez entrer un numéro de téléphone.',
            'telephone.regex' => 'Le numéro de téléphone ne respecte pas le format attendu.',
            'telephone.min' => 'Le numéro de téléphone doit comporter au moins 10 caractères.',
            'sujet.required' => 'Veuillez spécifier un sujet pour votre question ou commentaire.',
            'produit.required' => 'Veuillez sélectionner le produit en lien avec votre question ou commentaire.',
            'choix.required' => 'Veuillez choisir entre une question ou un commentaire.',
            'message.required' => 'Veuillez inscrire une question ou un commentaire.',
            'message.max' => 'Votre question ou commentaire ne peut pas dépasser 1000 caractères.'
           ]);
           if ($validation->fails())
            return back()->withErrors($validation->errors())->withInput();
           else

            $contenuFormulaire = $validation->validated();

            $commentaire = Commentaire::create([
                'id_utilisateur' => Auth::id(),
                'id_produit' => $contenuFormulaire['produit'],
                'telephone' => $contenuFormulaire['telephone'],
                'sujet' => $contenuFormulaire['sujet'],
                'question' => ($contenuFormulaire['choix'] === 'question'),
                'message' => $contenuFormulaire['message']
               ]);
            $user = Auth::user();
            $confirmMail = new confirmationCommentaire($commentaire);
            $confirmMail->to($user->email);
            Mail::send($confirmMail);


            return view('commentaire/confirmationCommentaire', [
                'commentaire' => $commentaire
                ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Commentaire $commentaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commentaire $commentaire)
    {
        //
    }
}
