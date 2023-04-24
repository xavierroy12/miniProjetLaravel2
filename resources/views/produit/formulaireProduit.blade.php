<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modification de produit') }}
        </h2>
    </x-slot>
    <div class="w-full max-w-md mx-auto">
        <?php  ?>
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="post" action="{{ route('enregistrementProduit') }}">
                @csrf
                <input type="hidden" name="id_produit" value="{{$produit->id_produit}}" />
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="produit">
                    Produit
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="produit" name="produit" type="text" placeholder="Produit" value="{{ $produit->produit }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" placeholder="Description"><?php echo $produit->description; ?></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="prix">
                    Prix
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="prix" name="prix" type="text" placeholder="Prix" value="<?php echo $produit->prix; ?>">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Modifier
                </button>
            </div>
        </form>
    </div>

</x-app-layout>

