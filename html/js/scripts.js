function disableOtherThan(age) {
    $('#game_nation').find('option').remove();

    $('.nage_' + age).each(function (index) {
        var id = $(this).attr('id').split('_').pop();
        var value = $(this).text();

        $('#game_nation').append('<option value="' + id + '">' + value + '</option>');
    });
}

// delay after document is ready
$(function () {
    $('#game_age').on('change', function (e) {
        var age = $('#game_age>option:selected').text();
        disableOtherThan(age);
    });

    if ($.fn.tooltipster) {
        $('.tooltip').tooltipster({
            contentAsHTML: true,
            theme: 'tooltipster-light'
        });
    }

    if ($('#show-turn').length > 0) {

        $('a').each(function(e){
            var link = $(this);
            if ('download' == link.html()) {
                var parts= link.attr('href').split('_');
                link.attr('download',parts[1] + '_' + parts[2]);
            }
        });
    }
});


