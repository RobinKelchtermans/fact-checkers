<div class="container">
    <div aria-live="polite" aria-atomic="true" style="position: fixed; bottom: 1em; left: 1em; z-index:99999">

        @if (Session::has('toasts'))
            @foreach (Session::get('toasts') as $toast)

                <div class="toast toast-{{ $toast->type }}" style="" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <img src="{{ url('/images/icon.png') }}" class="rounded mr-2" alt="fact checkers logo" style="width: 1em; height: 1em;">
                        <strong class="mr-auto">{{ $toast->title }}</strong>
                        <small>Nu</small>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {!! $toast->message !!}
                    </div>
                </div>

            @endforeach
        @endif

    </div>
</div>