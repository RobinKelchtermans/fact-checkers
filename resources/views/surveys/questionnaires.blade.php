@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Vragenlijsten</h1>
            <h5>Deze pagina bevat de vragen die worden gesteld aan de gebruikers.</h5>
            <h5>Deze vragenlijsten werden goedgekeurd door de Sociaal-Maatschappelijke Ethische Commissie van de KU Leuven. Dossiernummer: G-2019021549</h5>

            <h3>Mediaenquête</h3>
            <ol>
                <li>Hoe vaak lees je het nieuws?</li>
                <li>Wat is je voornaamelijkste bron van nieuws?</li>
                <li>Welke (online) kranten lees je?</li>
                <li>Waar of wanneer lees je het nieuws?</li>
                <li>Hoe vaak gebruik je [...] om het nieuws te lezen?
                    <ul>
                        <li>Papieren krant</li>
                        <li>Smartphone</li>
                        <li>Tablet</li>
                        <li>Computer</li>
                        <li>Ander</li>
                    </ul>
                </li>
                <li>Hoe vaak denk je (impliciet) in contact te komen met fake news?</li>
                <li>Hoe betrouwbaar vind je (online) kranten?</li>
                <li>Hoe betrouwbaar vind je sociale media (nieuwsgewijs)?</li>
                <li>Heb je ooit bewust een fake news artikel gezien? Indien ja, heb je iets gedaan en wat?</li>
                <li>Ben je bereid om aan fact checking te doen?</li>
                <li>Heb je al eerder aan fact checking gedaan?</li>
            </ol>

            <h3>Eindenquête</h3>
            <ol>
                <li>Hoe vaak denk je in (impliciet) contact te komen met fake news?</li>
                <li>Hoeveel fake news artikels denk je in totaal te hebben geopend?</li>
                <li>Heb je ooit gemerkt dat het platform extra functionaliteiten heeft aangeboden? Indien ja, wat en wanneer?</li>
                <li>Ik vind het een maatschappelijk meerwaarde om dergelijke platformen aan te bieden.</li>
                <li>Vond je het een meerwarde om ...
                    <ul>
                        <li>opmerkingen te kunnen plaatsen bij artikels?</li>
                        <li>opmerkingen te kunnen plaatsen in de artikels zelf (markeringen)?</li>
                        <li>opmerkingen te kunnen up- en downvoten?</li>
                        <li>een score te kunnen geven op de Fake-o-Meter?</li>
                        <li>Heb je nog opmerkingen bij een van deze zaken?</li>
                    </ul>
                </li>
            </ol>
        </div>
    </div>
</div>

@endsection