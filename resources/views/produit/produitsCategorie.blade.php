<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Les produits de la categorie'). ' ' . $produits[0]->categorie->categorie  }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    @foreach ($produits as $produit)
                    <div>
                        <p class="font-semibold text-lg">Produits : {{ $produit->produit }}
                        <p class="font-semibold text-lg">Description : {{ $produit->description}} </p>
                        <p class="font-semibold text-lg">Prix : {{ $produit->prix}} $ </p>
                        <br/>

                            </div>
                            @endforeach
                        </div>

            </div>
        </div>
    </div>
</x-app-layout>
