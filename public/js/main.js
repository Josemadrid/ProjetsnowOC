/*-----------------------------------------------------------------------------------*/

/*  /* Show trick media in small screen */

/*-----------------------------------------------------------------------------------*/

$(function () {
    $("#loadMedia").on('click', function (e) {
        e.preventDefault();
        $("div.load-media").removeClass('d-none');
        $("#loadMedia").addClass('d-none');
        $("#hideMedia").removeClass('d-none');
    });
    $("#hideMedia").on('click', function (e) {
        e.preventDefault();
        $("div.load-media").addClass('d-none');
        $("#loadMedia").removeClass('d-none');
        $("#hideMedia").addClass('d-none');
    });

});

/*-----------------------------------------------------------------------------------*/

/*  /* Show more tricks in the home page */

/*-----------------------------------------------------------------------------------*/

$(function () {
    $("div.trick").slice(0, 500).show();
    $("#loadMoreTrick").on('click', function (e) {
        e.preventDefault();
        $("div.trick:hidden").slice(0, 6).slideDown();
        if ($("div.trick:hidden").length == 0) {
            $("#loadMoreTrick").hide('slow');
            $("#loadLessTrick").show('slow');
        }
    });
    $("#loadLessTrick").on('click', function (e) {
        e.preventDefault();
        $("div.trick").slice(6, $("div.trick").length).hide();
        $("#loadLessTrick").hide('slow');
        $("#loadMoreTrick").show('slow');

    });
});

/*  /* Enlarge image on click */

/*-----------------------------------------------------------------------------------*/

$(document).ready(function () {
    $('.enlarge').on('click', function () {
        $(this).toggleClass('clic-image');
    });
});


/*  /* Trick collection */

/*-----------------------------------------------------------------------------------*/

$('#add-image').click(function () {
    const index = +$('#image-counter').val();
    const tmpl = $('#trick_pictures').data('prototype').replace(/__name__/g, index);
    console.log(tmpl,index);
    $('#trick_pictures').append(tmpl);
    $('#image-counter').val(index + 1);
    displayCounter();
});

$('#add-video').click(function () {
    const index = +$('#video-counter').val();
    const tmpl = $('#trick_videos').data('prototype').replace(/__name__/g, index);
    $('#trick_videos').append(tmpl);
    $('#video-counter').val(index + 1);
    displayCounter();
});



function displayCounter() {
    const countImage = +$('#trick_images div.form-group').length;
    const counterImage = countImage + '/3';
    $('.counter-image').text(counterImage);
    if (countImage >= 3) {
        $('#add-image').hide();
    } else {
        $('#add-image').show();
    }
    const countVideo = +$('#trick_videos div.form-group').length;
    const counterVideo = countVideo + '/3';
    $('.counter-video').text(counterVideo);
    if (countVideo >= 3) {
        $('#add-video').hide();
    } else {
        $('#add-video').show();
    }
}


displayCounter();
