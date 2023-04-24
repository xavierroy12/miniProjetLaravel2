<?php
$user = Auth::user();
?>


    <div class="mx-auto max-w-lg">
        <h2 class="text-xl font-bold text-center mb-4">Merci pour votre {{ $commentaire->question ? 'Question' : 'Commentaire' }}</h2>
        <p class="text-center mb-4"><strong> Sujet : </strong> {{$commentaire->sujet}}</p>
        <p class="text-center mb-4"><strong> Message : </strong>{{$commentaire->message}}</p>
        <p class="text-center mb-4"><small>*Il est possible qu'un agent vous contacte éventuellement</small></p></p>
    </div>


