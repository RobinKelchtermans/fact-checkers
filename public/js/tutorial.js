$(document).ready(function() {
    var intro = introJs();
    
    intro.setOptions({
        exitOnOverlayClick: false,
        exitOnEsc: false,
        showStepNumbers: false,
    });

    intro.onafterchange(function(){          
        if (this._introItems.length - 1 == this._currentStep || this._introItems.length == 1) {
            $('.introjs-skipbutton').show();
        } 
    });

    // Page 1
    if (window.location.pathname == "/profile") {
        intro.setOption('doneLabel', '<b style="color:black">Volgende pagina</b>').oncomplete(function() {
            window.location.href = '/?tutorial=true';
        });
        intro.start();
    }

    // Page 2
    if (window.location.pathname == "/") {
        intro.setOption('doneLabel', '<b style="color:black">Open artikel</b>').oncomplete(function() {
            window.location.href = '/article/tutorial?tutorial=true';
        });
        intro.start();
    }

    // Page 3
    if (window.location.pathname == "/article/tutorial") {
        intro.setOption('doneLabel', '<b style="color:black">Klaar</b>')
            .onbeforechange(function(el) {
            if ($(el).attr("data-step") == "1") {
                $('#generalInfoModal').modal('show');
                $('#generalInfoModal').addClass("d-none");
            }
            if ($(el).attr("data-step") == "2") {
                $('#generalInfoModal').removeClass("d-none");
            }
            if ($(el).attr("data-step") == "3") {
                $('#generalInfoModal').modal('hide');
            }
            if ($(el).attr("data-step") == "5") {
                $('#scoreInfoModal').modal('show');
                $('#scoreInfoModal').addClass("d-none");
            }
            if ($(el).attr("data-step") == "6") {
                $('#scoreInfoModal').removeClass("d-none");
            }
            if ($(el).attr("data-step") == "7") {
                $('#scoreInfoModal').modal('hide');
            }
        });
        intro.start();

        $('.inline-comment-mini').each(function(i, el) {
            $(el).click();
        });
    }

    $('.introjs-skipbutton').hide();

});