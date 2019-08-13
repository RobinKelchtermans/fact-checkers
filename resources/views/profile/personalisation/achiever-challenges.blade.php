<?php
    // Get the data
    $a = $challenges['viewed_articles'];
    $s = $challenges['given_scores'];
    $c = $challenges['created_comments'];

    $at = $challenges['viewed_articles_today'];
    $st = $challenges['given_scores_today'];
    $ct = $challenges['created_comments_today'];

    // Set the benchmarks
    // Daily
    $atl = 15;
    $stl = 10;
    $ctl = 5;

    // Total
    $al1 = 15;
    $al2 = 100;
    $al3 = 500;

    $sl1 = 10;
    $sl2 = 75;
    $sl3 = 400;

    $cl1 = 5;
    $cl2 = 50;
    $cl3 = 300;
    
    // Set percentages
    // Daily
    $atp = min($at * (100/$atl), 100);
    $stp = min($st * (100/$stl), 100);
    $ctp = min($ct * (100/$ctl), 100);

    // Total
    if ($a < $al1) {
        $ap = min($a * (100/$al1), 100);
    } elseif($a < $al2) {
        $ap = min($a * (100/$al2), 100);
    } else {
        $ap = min($a * (100/$al3), 100);
    }

    if ($s < $sl1) {
        $sp = min($s * (100/$sl1), 100);
    } elseif($s < $sl2) {
        $sp = min($s * (100/$sl2), 100);
    } else {
        $sp = min($s * (100/$sl3), 100);
    }

    if ($c < $cl1) {
        $cp = min($c * (100/$cl1), 100);
    } elseif($c < $cl2) {
        $cp = min($c * (100/$cl2), 100);
    } else {
        $cp = min($c * (100/$cl3), 100);
    }

?>
<div class="card my-3">
    <div class="card-header">
        <h4>Uitdagingen</h4>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-12 mb-3 text-center">
                <h3>Vandaag</h3>
            </div>
            <div class="col-4 text-center">
                <i class="far fa-3x fa-eye" data-toggle="tooltip" data-placement="top" title="Aantal verschillende artikels die je hebt gelezen vandaag."></i>
                <h2 class="my-3">{{ $at }}</h2>
                <div class="px-lg-5">
                    <div class="progress">
                        <div class="progress-bar @if($atp == 100) bg-success @endif" role="progressbar" style="width: {{ $atp }}%" aria-valuenow="{{ $atp }}" aria-valuemin="0" aria-valuemax="100">{{ $at }}/{{ $atl }}</div>
                    </div>
                </div>
            </div>
            <div class="col-4 text-center">
                <i class="far fa-3x fa-check-circle" data-toggle="tooltip" data-placement="top" title="Aantal verschillende artikels die je een score hebt gegeven vandaag."></i>
                <h2 class="my-3">{{ $st }}</h2>
                <div class="px-lg-5">
                    <div class="progress">
                        <div class="progress-bar @if($stp == 100) bg-success @endif" role="progressbar" style="width: {{ $stp }}%" aria-valuenow="{{ $stp }}" aria-valuemin="0" aria-valuemax="100">{{ $st }}/{{ $stl }}</div>
                    </div>
                </div>
            </div>
            <div class="col-4 text-center">
                <i class="far fa-3x fa-comments" data-toggle="tooltip" data-placement="top" title="Aantal opmerkingen die je hebt geplaatst vandaag."></i>
                <h2 class="my-3">{{ $ct }}</h2>
                <div class="px-lg-5">
                    <div class="progress">
                        <div class="progress-bar @if($ctp == 100) bg-success @endif" role="progressbar" style="width: {{ $ctp }}%" aria-valuenow="{{ $ctp }}" aria-valuemin="0" aria-valuemax="100">{{ $ct }}/{{ $ctl }}</div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mt-3">
            <div class="col-12 mb-3 text-center">
                <h3>Totaal</h3>
            </div>
            <div class="col-4 text-center">
                <i class="far fa-3x fa-eye" data-toggle="tooltip" data-placement="top" title="Aantal verschillende artikels die je hebt gelezen in totaal."></i>
                <h2 class="my-3">{{ $a }}</h2>
                <div class="px-lg-5">
                    <div class="progress">
                        <div class="progress-bar @if($ap == 100) bg-success @endif" role="progressbar" style="width: {{ $ap }}%" aria-valuenow="{{ $ap }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $a }}/@if($a < $al1) {{ $al1 }} @elseif($a < $al2) {{ $al2 }} @else {{ $al3 }} @endif
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <i class="@if($a < $al1) far @else fas @endif fa-2x fa-star" data-toggle="tooltip" data-placement="bottom" title="Lees {{ $al1 }} verschillende artikels."></i>
                    <i class="@if($a < $al2) far @else fas @endif fa-2x fa-star" data-toggle="tooltip" data-placement="bottom" title="Lees {{ $al2 }} verschillende artikels."></i>
                    <i class="@if($a < $al3) far @else fas @endif fa-2x fa-star" data-toggle="tooltip" data-placement="bottom" title="Lees {{ $al3 }} verschillende artikels."></i>
                </div>
            </div>
            <div class="col-4 text-center">
                <i class="far fa-3x fa-check-circle" data-toggle="tooltip" data-placement="top" title="Aantal verschillende artikels die je een score hebt gegeven in totaal."></i>
                <h2 class="my-3">{{ $s }}</h2>
                <div class="px-lg-5">
                    <div class="progress">
                        <div class="progress-bar @if($sp == 100) bg-success @endif" role="progressbar" style="width: {{ $sp }}%" aria-valuenow="{{ $sp }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $s }}/@if($s < $sl1) {{ $sl1 }} @elseif($s < $sl2) {{ $sl2 }} @else {{ $sl3 }} @endif
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <i class="@if($s < $sl1) far @else fas @endif fa-2x fa-star" data-toggle="tooltip" data-placement="bottom" title="Geef {{ $sl1 }} scores."></i>
                    <i class="@if($s < $sl2) far @else fas @endif fa-2x fa-star" data-toggle="tooltip" data-placement="bottom" title="Geef {{ $sl2 }} scores."></i>
                    <i class="@if($s < $sl3) far @else fas @endif fa-2x fa-star" data-toggle="tooltip" data-placement="bottom" title="Geef {{ $sl3 }} scores."></i>
                </div>
            </div>
            <div class="col-4 text-center">
                <i class="far fa-3x fa-comments" data-toggle="tooltip" data-placement="top" title="Aantal opmerkingen die je hebt geplaatst in totaal."></i>
                <h2 class="my-3">{{ $c }}</h2>
                <div class="px-lg-5">
                    <div class="progress">
                        <div class="progress-bar @if($cp == 100) bg-success @endif" role="progressbar" style="width: {{ $cp }}%" aria-valuenow="{{ $cp }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $c }}/@if($c < $cl1) {{ $cl1 }} @elseif($c < $cl2) {{ $cl2 }} @else {{ $cl3 }} @endif
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <i class="@if($c < $cl1) far @else fas @endif fa-2x fa-star" data-toggle="tooltip" data-placement="bottom" title="Schrijf {{ $cl1 }} opmerkingen."></i>
                    <i class="@if($c < $cl2) far @else fas @endif fa-2x fa-star" data-toggle="tooltip" data-placement="bottom" title="Schrijf {{ $cl2 }} opmerkingen."></i>
                    <i class="@if($c < $cl3) far @else fas @endif fa-2x fa-star" data-toggle="tooltip" data-placement="bottom" title="Schrijf {{ $cl3 }} opmerkingen."></i>
                </div>
            </div>
        </div>
    </div>
</div>