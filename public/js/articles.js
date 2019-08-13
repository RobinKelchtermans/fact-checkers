var currentHighlightId = null;
var canBeClickedAway = false;
var tooltipTimeOut = null;
var savedScore = "Geef een score";
var clickableHighlight = true;
var inlineCommentsHaveBeenPositioned = false;

$(document).ready(function() {
    setHighlightingAndInlineComments();
    setScore();

    // $('.comment').readmore({
    //     collapsedHeight: 45
    // }).css("overflow", "hidden");

    markId(document.URL.substring(document.URL.lastIndexOf('#')));

    $('[data-toggle="popover"]').popover({
        container: 'body',
        trigger: 'focus',
        html: true,
        sanitize: false,
    });

    $(".inline-comment").on("click", function() {
        $(this).css('z-index', 1022);
        $(this).siblings('.inline-comment').not('.active').css('z-index', 1021);
    });

    $(".inline-comment, .inline-comment-mini").hover(function() {
        $("#" + $(this).attr("data-associated_text_id")).addClass("highlight-glow");
    }).mouseleave(function() {
        $("#" + $(this).attr("data-associated_text_id")).removeClass("highlight-glow");
    });
    $(".highlight").hover(function() {
        $(".inline-comment-mini[data-associated_text_id=" + $(this).attr("id") + "] .btn").addClass("active");
        $(".inline-comment[data-associated_text_id=" + $(this).attr("id") + "]").addClass("highlight-glow");
    }).mouseleave(function() {
        $(".inline-comment-mini[data-associated_text_id=" + $(this).attr("id") + "] .btn").removeClass("active");
        $(".inline-comment[data-associated_text_id=" + $(this).attr("id") + "]").removeClass("highlight-glow");
    });

    $(".highlight").on("click", function() {
        if (clickableHighlight) {
            let id = $(this).attr("id");
            let comm = $(".inline-comment[data-associated_text_id='" + id + "']").attr("id");
            toggleInlineComment(comm.slice(8));
            $(".inline-comment[data-associated_text_id='" + id + "']").click();
        }
    });

    $("#article").on('mousemove', function(e) {
        $("#marked-tooltip").css({top: e.pageY, left: e.pageX });
    });

    $('.highlightable').on("mouseup", function (e) {
        if (!clickableHighlight) {
            return;
        }
        var selected = getSelection();
        var range = selected.getRangeAt(0);
        if (selected.toString().length > 0) {
            var newNode = document.createElement("span");
            let id = makeid(20);
            currentHighlightId = id;
            newNode.setAttribute("class", "highlight");
            newNode.setAttribute("id", id);
            try {
                range.surroundContents(newNode);
                createInlineComment(id);
            }
            catch(err) {
                $('[data-toggle="tooltip"]').tooltip('show');
                $("#article").on('mousemove', function(e) {
                    $("#marked-tooltip").css({top: e.pageY, left: e.pageX });
                    $('[data-toggle="tooltip"]').tooltip('show');
                });

                setTimeout(() => {
                    $("#article").off('mousemove');
                }, 1);
                
                tooltipTimeOut = setTimeout(() => {
                    $('[data-toggle="tooltip"]').tooltip('hide');
                    $("#article").on('mousemove', function(e) {
                        $("#marked-tooltip").css({top: e.pageY, left: e.pageX });
                    });
                }, 3000);

                setTimeout(() => {
                    canBeClickedAway = true;
                }, 10);
            }
        }
        selected.removeAllRanges();
    });

    function getSelection() {
        var seltxt = '';
        if (window.getSelection) { 
            seltxt = window.getSelection(); 
        } else if (document.getSelection) { 
            seltxt = document.getSelection(); 
        } else if (document.selection) { 
            seltxt = document.selection.createRange().text; 
        }
        else return;
        return seltxt;
    }

    $('.overlay').on('click', function() {
        removeInlineComment()
    });

    $(".reply").on("click", function(e) {
        e.preventDefault();
    });

    $(".thrust-rating").hover(function() {
        hoverRating(this);
    }).mouseleave(function() {
        hoverRating(this, true);
    });

    $(".thrust-rating").click(function() {
        clickRating(this);
    });

    $("#article").on("click", function() {
        if (canBeClickedAway){
            $('[data-toggle="tooltip"]').tooltip('hide');
            $("#article").on('mousemove', function(e) {
                $("#marked-tooltip").css({top: e.pageY, left: e.pageX });
            });
            canBeClickedAway = false;
            window.clearTimeout(tooltipTimeOut);
        }        
    });

    $("#toggleCommentsBtn").on("click", function() {
        toggleInlineComments();
    });

    window.addEventListener('resize', function(){
        checkSize();
    }, true);

    if ($(document).width() < 576) {
        showInlineCommentBox("nope")
    }

    $('.form-comment').submit(function(){
        $(this).children('button[type=submit]').prop('disabled', true);
    });
    $('#inlineComments').on('submit', '.form-comment', function(){
        $(this).children('button[type=submit]').prop('disabled', true);
    });
});

function checkSize() {
    let w = $(document).width();
    if (w < 576) {
        showInlineCommentBox("nope")
    } else {
        let val = $("#articleBox").attr("data-show-comments-original");
        if (val == " false " || val == "false") {
            val = true;
        } else {
            val = "false";
        }
        showInlineCommentBox(val);
    }
}

function createInlineComment(id) {
    let inlineComment = $("#templateInlineComment").clone();
    let coord = getCoords(id);
    inlineComment.attr("id", "commentClone");
    inlineComment.removeClass("d-none");
    inlineComment.addClass("inline-comment");
    inlineComment.addClass("active");
    inlineComment.css("top", coord.top - 150);
    
    $("#inlineComments").append(inlineComment);
    setTimeout(function(){
        $("#commentClone textarea").focus();
    }, 1);
    $(".overlay").show();

    $('#commentClone input[name=associated_text_id]').val(id);
    $('#commentClone input[name=article_text]').val($("#article").html());
}

function removeInlineComment() {
    $(".overlay").hide();
    $("#commentClone").remove();
    $("#" + currentHighlightId).contents().unwrap();
    currentHighlightId = null;
}

function showInlineComments() {
    $(".inline-comment").each(function(i, el){
        $(this).removeClass("d-none");
        $(this).hide();
        let assoc_id = $(this).data("associated_text_id");
        let coord = getCoords(assoc_id);
        $(this).css("top", coord.top - 100);

        let id = $(this).attr("id");
        let text = $($("#article").clone().find("#" + assoc_id).contents().unwrap().prevObject.prevObject[0]).html();
        let form = $("#" + id + " .comment-options a[data-content]").data("content");
        
        var $html = $('<div />',{html:form});
        $($html).find('input[name=article_text]').val(text);
        let newForm = $html.contents().unwrap().prop('outerHTML');
        $("#" + id + " .comment-options a").attr("data-content", newForm);

        $("#" + id + "-mini").removeClass("d-none");
        setMiniPosition(id + "-mini", coord.top - 80, 0);
    });
}

function setHighlightingAndInlineComments() {
    let val = $("#articleBox").attr("data-show-comments");
    if (val == "false" || val == " false ") {
        $(".highlight").addClass("no-highlight");
        clickableHighlight = false;
    } else {
        $(".highlight").removeClass("no-highlight");
        clickableHighlight = true;
        inlineCommentsHaveBeenPositioned = true;
        showInlineComments();
    }
}

function toggleInlineComments() {
    $.ajax({
        url: '/profile/toggleComments',
        method: 'post',
        data: null,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            // console.log(response);
        }
    });
    
    let val = $("#articleBox").attr("data-show-comments");
    showInlineCommentBox(val);
}

function showInlineCommentBox(val) {
    if (val == "false" || val == " false " || val == false) {
        $("#articleBox").attr("data-show-comments", true);
        clickableHighlight = true;
        $("#articleBox").removeClass("col-sm-12");
        $("#inlineComments").removeClass("col-sm-0");
        $("#articleBox").addClass("col-sm-8");
        $("#inlineComments").addClass("col-sm-4");
        $(".highlight").removeClass("no-highlight");
        $("#toggleCommentsBtn").addClass("active");
        setTimeout(() => {
            $(".inline-comment-mini").show(500, "easeOutExpo");            
        }, 500);
        if (!inlineCommentsHaveBeenPositioned) {
            showInlineComments();
            inlineCommentsHaveBeenPositioned = true;
        }
    } else {
        $("#articleBox").attr("data-show-comments", false);
        clickableHighlight = false;
        $("#articleBox").removeClass("col-sm-8");
        $("#inlineComments").removeClass("col-sm-4");
        $("#articleBox").addClass("col-sm-12");
        $("#inlineComments").addClass("col-sm-0");
        $(".highlight").addClass("no-highlight");
        $("#toggleCommentsBtn").removeClass("active");
        $(".inline-comment, .inline-comment-mini").hide(500, "easeOutExpo");
    }
}

function setMiniPosition(id, top, left) {
    $("#" + id).css("top", top);
    $("#" + id).css("left", left);
    var rect1 = document.getElementById(id).getBoundingClientRect();
    var max = $("#inlineComments").width() - rect1.width - 20;

    $(".inline-comment-mini.placed").each(function(i, element) {
        let rect2 = element.getBoundingClientRect();
        let overlap = !(rect1.right < rect2.left || 
                        rect1.left > rect2.right || 
                        rect1.bottom < rect2.top || 
                        rect1.top > rect2.bottom)
        if (overlap && (left < max)) {
            return setMiniPosition(id, top, left + rect1.width + 5)
        }
    });

    $("#" + id).addClass("placed");
}

function toggleInlineComment(id) {
    $("#comment-" + id).toggle(500, "easeOutExpo");
    $("#comment-" + id + "-mini").toggle(500, "easeOutExpo");
}

function markId(id) {
    if (id.includes('#comment-')) {
        if ($(id).parent().attr("id") == "inlineComments") {
            toggleInlineComment(id.slice(9));
        } else {
            let parent = $(id).closest(".inline-comment").attr("id");
            if (parent) {
                toggleInlineComment(parent.slice(8));
            }
        }

        $(id + " .comment").addClass("glow");
        
        setTimeout(() => {
            $(id + " .comment").addClass("recently-glowed");
            $(id + " .comment").removeClass("glow");
        }, 1500);
    }
}

function hoverRating(el, leaving = false) {
    if (leaving) {
        $(el).removeClass('hovered');
        $(el).siblings().not('active-rating').removeClass('hovered');
        $(el).siblings().removeClass('temp-not-active-rating');
    } else {
        $(el).addClass('hovered');
        $(el).prevAll().addClass('hovered');
        $(el).nextAll().addClass('temp-not-active-rating');
    }

    score = getTextValue($(el).index());

    if (leaving) {
        score = savedScore;
    }
    $("#given-rating").text(score);
}

function clickRating(el) {
    // reset
    $(el).siblings().removeClass("active-rating");
    $(el).siblings().removeClass("fas");
    $(el).siblings().addClass("far");

    //remove not needed classes
    $(el).removeClass("far");
    $(el).prevAll().removeClass("far");

    $(el).addClass("active-rating");
    $(el).addClass("fas");
    $(el).prevAll().addClass("active-rating");
    $(el).prevAll().addClass("fas");

    savedScore = getTextValue($(el).index());
    $("#given-rating").text(savedScore);
    try {
        saveRating(el.dataset.value);
    } catch (error) {
        // do nothing
    }
}

function saveRating(value) {
    // console.log($('input[name="id"]').val());
    $.ajax({
        url: '/saveScore',
        method: 'post',
        data: {
            // userId: $('input[name="user-id"]').val(),
            id: $('input[name="article-id"]').val(),
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

function setScore() {
    let score = $('input[name="score-value"]').val();
    let el = $(".thrust-rating[data-value='" + score + "']");
    clickRating(el);
}

function startAnswer(id) {
    if (document.getElementById("answer-" + id)) {
        $("#answer-" + id + " textarea").focus();
        return;
    }
    let answer = $("#templateSubComment").clone();
    answer.attr("id", "answer-" + id);
    answer.removeClass("d-none");
    $("#comment-" + id + "-answers").append(answer);
    $("#answer-" + id + " input[name=parent_id]").val(id);
    $("#answer-" + id + " textarea").focus();
}

var processing = false;
function upvote(id) {
    if (processing) {
        return;
    }
    if ($($("#comment-" + id).find(".upvote")[0]).hasClass("voted")) {
        removeVote(id);
    } else {
        processing = true;
        $.ajax({
            url: '/vote',
            method: 'post',
            data: {
                id: id,
                value: 'upvote',
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                $($("#comment-" + id).find(".downvote")[0]).removeClass("voted");
                $($("#comment-" + id).find(".upvote")[0]).addClass("voted");
                $("#comment-" + id + " .votes")[0].innerText = response;
            },
            error: function(response) {
                $('#errorModal').modal('show');
            },
            complete: function () {
                processing = false;
            }
        });
    }
}

function downvote(id) {
    if (processing) {
        return;
    }
    if ($($("#comment-" + id).find(".downvote")[0]).hasClass("voted")) {
        removeVote(id);
    } else {
        processing = true;
        $.ajax({
            url: '/vote',
            method: 'post',
            data: {
                id: id,
                value: 'downvote',
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                $($("#comment-" + id).find(".downvote")[0]).addClass("voted");
                $($("#comment-" + id).find(".upvote")[0]).removeClass("voted");
                $("#comment-" + id + " .votes")[0].innerText = response;
            },
            error: function(response) {
                $('#errorModal').modal('show');
            },
            complete: function () {
                processing = false;
            }
        });
    }
}

function removeVote(id) {
    processing = true;
    $.ajax({
        url: '/vote',
        method: 'post',
        data: {
            id: id,
            value: 'remove',
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            $($("#comment-" + id).find(".downvote")[0]).removeClass("voted");
            $($("#comment-" + id).find(".upvote")[0]).removeClass("voted");
            $("#comment-" + id + " .votes")[0].innerText = response;
        },
        error: function(response) {
            $('#errorModal').modal('show');
        },
        complete: function () {
            processing = false;
        }
    });
}





// Helpers

function makeid(length) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (let i = 0; i < length; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function getCoords(id) {
    try {
        let box = document.getElementById(id).getBoundingClientRect();
        return {
            top: box.top + pageYOffset,
            left: box.left + pageXOffset
        };
    } catch (error) {
        return {
            top: 150,
            left: 0
        }
    }
    
    
}

function getTextValue(index) {
    switch (index) {
        case 0:
            score = "Fake news";
            break;
        case 1:
            score = "Onwaar";
            break;
        case 2:
            score = "Grotendeels onwaar";
            break;
        case 3:
            score = "Gedeeltelijk waar";
            break;
        case 4:
            score = "Grotendeels waar";
            break;
        case 5:
            score = "Waar";
            break;
    
        default:
            score = savedScore;
            break;
    }
    return score;
}