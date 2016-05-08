$(function() {

    $('tr[class="Row"]').each(function(index, el) {
        $(el).find('td.index').html(index+1);
    });

    var table = $('.Table');
    var tableHeight = table.height();

    $('#next').click(function() {
        var top = table.css('top');
        top = top.substring(0, top.length - 2);
        if (!((-top + 3060) >= tableHeight)) {
            console.log(top);
            table.css('top', top - 3060+'px');
        }
    });

    $('#prev').click(function() {
        var top = table.css('top');
        top = top.substring(0, top.length - 2);
        if (!((-top - 3060) < 0)) {
            console.log(top);
            table.css('top', -(-top - 3060) +'px');
        }
    });

});
