$(function () {

    var dynamicDivBlue = $('.searchgameladderinline').parent("#blue");
    var childrenLengthBlue = dynamicDivBlue.children().length;

    dynamicDivBlue.css('padding', '0px '+(5-childrenLengthBlue)*100+'px');

    var dynamicDivRed = $('.searchgameladderinline').parent("#red");
    var childrenLengthRed = dynamicDivRed.children().length;

    dynamicDivRed.css('padding', '0px '+(5-childrenLengthRed)*100+'px');

});
