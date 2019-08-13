$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip()

    $(".filters").click(function (e) {
        if (hasCorrectNbOfSources()) {
            let toggleId = $(this).attr('id');
            let id = $(this).attr('data-id');
            saveFilter(id, $('#' + toggleId + ':checked').length > 0);
        } else {
            e.preventDefault();
            $('#notEnoughSources').removeClass('d-none');
            $('#notEnoughSources').show();
            setTimeout(() => {
                $('#notEnoughSources').hide(500);
            }, 5000);
        }
    });
    $('#notEnoughSources').on('close.bs.alert', function (event) {
        event.preventDefault();
        $(this).hide(500);
      });
});

function hasCorrectNbOfSources() {
    let nb = $('#sources input[type=checkbox]:checked').length;
    return (nb > 2);
}

function saveFilter(id, value) {
    $.ajax({
        url: '/saveFilters',
        method: 'post',
        data: {
            id: id,
            value: value,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            // console.log(response);
        },
        error: function(response) {
            $('#errorModal').modal('show');
        }
    });
}
