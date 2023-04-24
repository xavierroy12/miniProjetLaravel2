<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Http\Resources\ProduitResource;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;


class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index() : View
     {

        return view('produit/produits', [
            'produits' => Produit::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->routeIs('insertionProduitApi')) {
            $validation = Validator::make($request->all(), [
            'id_categorie' => 'required|regex:/^[1-9]\d*$/',
            'produit' => 'required',
            'description' => 'required|max:250',
            'prix' => 'required|regex:/^\d+\.\d\d$/'
            ], [
            'id_categorie.required' => 'Veuillez entrer l\'identifiant de la catégorie.',
            'id_categorie.regex' => 'L\'identifiant de la catégorie doit être un nombre supérieur à 0.',
            'produit.required' => 'Veuillez entrer un nom pour le produit.',
            'description.required' => 'Veuillez inscrire une description pour le produit.',
            'description.max' => 'Votre description de produit ne peut pas dépasser 250 caractères.',
            'prix.required' => 'Veuillez inscrire un prix pour le produit.',
            'prix.regex' => 'Le prix doit être un montant valide avec un point comme délimitateur.'
            ]);
            if ($validation->fails()) {
            // On répond à la requête de Postman en plaçant toutes les erreurs qui ont pu survenir dans
            // un conteneur JSON avec un code HTTP 400.
            return response()->json(['ERREUR' => $validation->errors()], 400);
            }

            $contenuDecode = $validation->validated();
            // Rendu ici, les données ont été validées et décodées dans le tableau associatif $contenuDecode.
            // Il faut alors procéder à l’insertion du produit en BD.
            try {
                Produit::create([
                'id_categorie' => $contenuDecode['id_categorie'],
                'produit' => $contenuDecode['produit'],
                'description' => $contenuDecode['description'],
                'prix' => $contenuDecode['prix']
                ]);
                return response()->json(['SUCCES' => 'Le produit a été ajouté.'], 200);
               } catch (QueryException $erreur) {
                report($erreur);
                return response()->json(['ERREUR' => 'Le produit n\'a pas été ajouté.'], 500);
               }
           }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $idProduit)
    {
        $produit = Produit::find($idProduit);
        if ($request->routeIs('produit')) {

        if (is_null($produit))
        return abort(404); // Redirige automatiquement vers la page "404 – Not found".

        return view('produit/produit', [
            'produit' => Produit::find($idProduit)
           ]);

        }
        else if ($request->routeIs('produitsCategorie')) {
            return view('produit/produitsCategorie', [
                'produits' => Produit::whereHas('categorie', function ($query) use ($idProduit) {
                    $query->where('id_categorie', $idProduit);
                })->get()
            ]);
        }
        else if ($request->routeIs('produitApi')) {
            $produit = Produit::find($idProduit);
            if (empty($produit))
            return response()->json(['ERREUR' => 'Le produit demandé est introuvable.'], 400);
            return new ProduitResource($produit);
           }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,Produit $produit)

    {
        $id = $request->input('id_produit');
        $produit = Produit::find($id);

        return view('produit/formulaireProduit', [
            'produit' => $produit
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, Produit $produit)
     {
        $validation = Validator::make($request->all(), [
            // Vous pouvez combiner plusieurs règles de validation à condition de les séparer par des "|". Les noms
            // clés de ce tableau associatif doivent correspondent aux termes inscrits dans les attributs "name" des
            // balises <input />, <select> et <textearea>.
            'id_produit' => 'required',
            'produit' => 'required',
            'description' => 'required',
            'prix' => 'required',
        ], [
            // Vous pouvez écrire un message d’erreur distinct par règle de validation fournie plus haut.
            'produit.required' => 'Veuillez entrer un nom.',
            'description.required' => 'Veuillez entrer une description.',
            'prix.required' => 'Veuillez entrer un prix.',

        ]);
        if ($validation->fails())
        return back()->withErrors($validation->errors())->withInput();
        else

        $contenuFormulaire = $validation->validated();
        $produit = Produit::find($contenuFormulaire['id_produit']);

        $produit->produit = $contenuFormulaire['produit'];
        $produit->description = $contenuFormulaire['description'];
        $produit->prix = $contenuFormulaire['prix'];

        if ($produit->save())
        $request->session()->flash('succes', 'La modification du produit a bien fonctionné.');
        else
        $request->session()->flash('erreur', 'La modification du produit n\'a pas fonctionné.');


        return view('produit/produits', [
            'produits' => Produit::all()
        ]);




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
     // On peut utiliser la méthode "input()" sur une requête pour récupérer une valeur, peu
     // importe si cette valeur a été transmise en GET ou en POST.
     $id = $request->input('id_produit');
     // La méthode "destroy()" du modèle Produit.php supprime le produit en BD possédant l’ID
     // fourni. Elle retourne "true" si la suppression a réussi ou "false" si elle a échoué.
     if (Produit::destroy($id))
     return back()->with('succes', 'La suppression du produit a bien fonctionné.');
     // La méthode "back()" permet de retourné sur la page précédente (soit la page des
     // produits) et la méthode « with() » permet d’inscrire dans la session PHP une clé
     // ("succes" ou "erreur" dans ce cas-ci) suivie d’un message personnalisé.
     return back()->with('erreur', 'La suppression du produit n\'a pas fonctionné.');
    }



}
