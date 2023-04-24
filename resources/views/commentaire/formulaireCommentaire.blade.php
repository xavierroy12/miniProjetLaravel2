<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
?>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questions/Commentaires') }}
        </h2>
    </x-slot>
    <div class="mx-auto max-w-lg">
        <h2 class="text-xl font-bold text-center mb-4">Posez votre question ou laissez un commentaire</h2>
        <div class="bg-white rounded-lg shadow-md p-6 ">
            <form method="post" action="{{ route('insertionCommentaire') }}">
                @csrf
                <div class="mb-4">
                    <label @disabled(true) for="demandeur" class="block font-bold mb-2">Demandeur</label>
                    <input type="text" id="demandeur" name="demandeur" value="{{ $user->name }}" class="form-input rounded-md shadow-sm w-full">
                </div>
                <div class="mb-4">
                    <label for="telephone" class="block font-bold mb-2">Numéro de téléphone</label>
                    <input type="text" id="telephone" name="telephone" class="form-input rounded-md shadow-sm w-full">
                </div>
                <div class="mb-4">
                    <label for="sujet" class="block font-bold mb-2">Sujet</label>
                    <input type="text" id="sujet" name="sujet" class="form-input rounded-md shadow-sm w-full">
                </div>
                <div class="mb-4">
                    <label for="produit" class="block font-bold mb-2">Produit concerné</label>
                    <select id="produit" name="produit" class="form-select rounded-md shadow-sm w-full">
                        @foreach ($produits as $produit)
                        <option value="{{ $produit->id_produit}}">{{ $produit->produit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <span class="block font-bold mb-2">Type de message</span>
                    <div class="flex items-center">
                        <label for="question" class="inline-flex items-center mr-4">
                            <input type="checkbox" id="choix" name="choix" value="true" class="form-checkbox">
                            <span class="ml-2">Question</span>
                        </label>
                        <label for="commentaire" class="inline-flex items-center">
                            <input type="checkbox" id="choix" name="choix" value="false" class="form-checkbox">
                            <span class="ml-2">Commentaire</span>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="message" class="block font-bold mb-2">Question/Commentaire</label>
                    <textarea id="message" name="message" class="form-textarea rounded-md shadow-sm w-full" rows="6"></textarea>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded-md">Envoyer</button>
                </div>
            </form>




        </div>
    </div>
</x-app-layout>
