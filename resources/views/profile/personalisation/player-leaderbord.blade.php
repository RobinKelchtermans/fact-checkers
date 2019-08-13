<div class="card my-3">
        <div class="card-header">
            <h4>
                <i class="fas fa-trophy"></i>
                Leaderbord
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-1 col-1 text-right">
                    #
                </div>
                <div class="col-sm-9 col-7">
                    Naam
                </div>
                <div class="col-sm-2 col-3" data-toggle="tooltip" data-placement="top" title="Je reputatie hangt af van hoe actief je bent, het aantal opmerkingen die je plaats en het up- en downvoten van opmerkingen.">
                   Reputatie*
                </div>
            </div>
            <?php 
                $i = 1;
                $userInList = false;
            ?>
            @foreach ($leaderbord as $user)
                <a href="{{ url('/users/' . $user->id) }}" style="color: inherit;">
                    @if($user->id == auth()->user()->id) <b> @endif
                        <div class="row">
                            <div class="col-sm-1 col-1 text-right">
                                {{ $i }}
                            </div>
                            <div class="col-sm-9 col-7">
                                {{ $user->firstname }} {{ $user->lastname }}
                            </div>
                            <div class="col-sm-2 col-3">
                                {{ $user->reputation * 100 }} %
                            </div>
                        </div>
                    @if($user->id == auth()->user()->id) </b> @endif
                </a>
                <?php 
                    $i += 1;
                    if ($user->id == auth()->user()->id) {
                        $userInList = true;
                    }
                ?>
            @endforeach

            @if (!$userInList)
                <b>
                    <div class="row mt-4">
                        <div class="col-sm-1 col-1 text-right">
                                
                        </div>
                        <div class="col-sm-9 col-7">
                            {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                        </div>
                        <div class="col-sm-2 col-3">
                            {{ auth()->user()->reputation * 100 }} %
                        </div>
                    </div>
                </b>
            @endif
        </div>
    </div>