<div class="row">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show col-sm-4 offset-sm-4">
                {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
<div class="card my-3">
    <div class="card-header">
        <h4>Geef feedback</h4>
    </div>
    <div class="card-body">
        <h5>We zijn enorm hard geïnteresseerd in jouw feedback! Wat kan er beter? Wat vind je juist goed? Schrijf het allemaal maar op.</h5>
        <form role="form" method="POST" action="{{ url('/profile/giveFeedback') }}">
            @csrf
            <div class="form-group">
                <textarea class="form-control" id="feedback" name="feedback" rows="3" required="required"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Verzenden</button>
        </form>
    </div>
</div>