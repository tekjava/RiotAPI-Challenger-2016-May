$(function() {

    var tableBody = $('#tbody');
    var table = $('.Table');

    $('a.Action').click(function(event) {
        var id = $(this).attr('id');
        if(id == 'all') {
            var id = $(this).attr('id');
            tableBody.children().show('fast');
            $('a').parent().removeClass('selected');
            $('#'+id).parent().addClass('selected');
            console.log('Clicked me: '+id);
            table.css('top', '0px');
            setTimeout(function() {
                var rank = 1;
                $('tr[class="Row"]').each(function(index, el) {
                    var display = $(el).css('display');

                    if(display != 'none') {
                        console.log(display);
                        $(el).find('td.index').html(rank);
                        rank++;
                    }
                });
            }, 500);
        } else {
            tableBody.children().hide('fast');
            tableBody.children('#row_'+id).show('fast');
            $('a').parent().removeClass('selected');
            $('#'+id).parent().addClass('selected');
            console.log('Clicked me: '+id);
            table.css('top', '0px');
            setTimeout(function() {
                var rank = 1;
                $('tr[class="Row"]').each(function(index, el) {
                    var display = $(el).css('display');

                    if(display != 'none') {
                        console.log(display);
                        $(el).find('td.index').html(rank);
                        rank++;
                    }
                });
            }, 500);
        }
    });

});
