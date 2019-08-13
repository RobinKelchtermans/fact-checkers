$(document).ready(function() {

    $("#btnStart").on("click", function() {
        $('.carousel').carousel('next');
        $(".header-progress-list .todo").first().addClass("done").removeClass("todo");
    });

    $('#text-carousel').on("click", ".next", function() {
        $('.carousel').carousel('next');
        $(".header-progress-list .todo").first().addClass("done").removeClass("todo");

        if ($(this).parent().next().attr("id") === "result") {
            window.setTimeout(calculateResult,50);
        }
    });

    $('.preventNext').click(function(e) {
        e.stopPropagation();
        $("#sourceValue").focus();
    });

    $("#sourceValue").keyup(function() {
        if ($("#sourceBtn").length < 1) {
            $("#sourceBox").append('<button class="btn btn-outline-primary next mt-3" id="sourceBtn">Volgende</button>');
        }
        if (this.value.length < 1) {
            $("#sourceBtn").remove();
        }
    });

    $("#alreadyFactCheckingValue").keyup(function() {
        if ($("#alreadyFactCheckingBtn").length < 1) {
            $("#alreadyFactCheckingBox").append('<button class="btn btn-outline-primary next mt-3" id="alreadyFactCheckingBtn">Volgende</button>');
        }
        if (this.value.length < 1) {
            $("#alreadyFactCheckingBtn").remove();
        }
    });

    $("#sawFakeValue").keyup(function() {
        if ($("#sawFakeBtn").length < 1) {
            $("#sawFakeBox").append('<button class="btn btn-outline-primary next mt-3" id="sawFakeBtn">Volgende</button>');
        }
        if (this.value.length < 1) {
            $("#sawFakeBtn").remove();
        }
    });    
});

function calculateResult() {
    let answers = [];
    $(".answer").each(function(i, el) {
        answers.push({
            userType: $(el).data("type"),
            reference: $(el).data("reference"),
            correlation: $(el).data("correlation"),
            value: $("input[name=" + $(el).data("reference") + "]:checked").val(),
        });
    });
    
    let groups = _.groupBy(answers, "userType");

    let totals = [];

    _.each(groups, function(e) {
        let sum = 0;
        _.each(e, function(el) {
            sum += (el.correlation * el.value);
        });
        totals.push({
            type: e[0].userType,
            total: sum
        });
    });

    let max = _.maxBy(totals, "total");

    showType(max.type);
}

function showType(type) {
    $("#userTypeValue").val(type);
    $("#userInfoValue").val(getInfo(type));
    $("#result img").attr("src", "/images/" + type + ".jpg");
    $("#result .card-title").html("Je bent een " + type.replace(/_/g, " "));

    $("#result .card-text").html(getInfo(type));
}

function getInfo(type) {
    let info = "";
    switch (type) {
        case "Philanthropist":
            info = "Philantropisten worden gemotiveerd door doel en betekenis. Deze groep is altruïstisch, wil andere mensen geven en hun leven verrijken zonder een beloning te verwachten.";
            break;
        case "Achiever":
            info = "Achievers worden gemotiveerd door meesterschap. Ze willen nieuwe dingen leren en zichzelf verbeteren. Ze willen uitdagingen kunnen overwinnen.";
            break;
        case "Disruptor":
            info = "Disruptors zijn gemotiveerd door verandering. In het algemeen willen ze het systeem verstoren, hetzij direct of via andere gebruikers om positieve of negatieve verandering te forceren.";
            break;
        case "Free_Spirit":
            info = "Free Spirits worden gemotiveerd door autonomie en zelfexpressie. Ze willen kunnen creëren en verkennen.";
            break;
        case "Player":
            info = "Players worden gemotiveerd door beloningen en zijn in staat om alles te doen om deze beloningen te verzamelen van een systeem. Ze doen het voor henzelf.";
            break;
        case "Socialiser":
            info = "Socialisers worden gemotiveerd door verbondenheid. Ze willen communiceren met anderen en sociale connecties creëren.";
            break;
        default:
            break;
    }
    return info;
}