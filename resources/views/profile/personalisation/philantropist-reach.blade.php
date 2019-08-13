<div class="card my-3">
    <div class="card-header">
        <h4>Opmerkingen met het grootste bereik</h4>
    </div>
    <div class="card-body">
        @if (count($comments) == 0)
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        Je hebt nog geen opmerkingen geplaatst.
                    </div>
                </div>
            </div>
        @endif
        @foreach ($comments as $comment)
            <div class="row">
                <div class="col-sm-1 col-1 text-right">
                    {{ $comment->reach }}
                </div>
                <div class="col-sm-9 col-7">
                    {{ $comment->text }}
                </div>
                <div class="col-sm-2 col-3">
                    <a href="{{ url('/article/' . $comment->article_id . '#comment-' . $comment->id)}}">Open</a>
                </div>
            </div>
        @endforeach
    </div>
</div>