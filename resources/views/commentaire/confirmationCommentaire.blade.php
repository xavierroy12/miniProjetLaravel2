
<?php
$user = Auth::user();
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmation') }}
        </h2>
    </x-slot>
    <div class="mx-auto max-w-lg">
        <h2 class="text-xl font-bold text-center mb-4">Merci pour votre {{ $commentaire->question ? 'Question' : 'Commentaire' }}</h2>
        <p class="text-center mb-4">Votre commentaire a été enregistré.</p>
        <p class="text-center mb-4">S’il y a lieu, un agent vous appellera sous peu au numéro suivant :  {{ $commentaire->telephone }}</p>
        <p class="text-center mb-4">De plus, un courriel de confirmation vous sera envoyé à l’adresse suivante :  {{ $user->email }}</p>
    </div>
</x-app-layout>

