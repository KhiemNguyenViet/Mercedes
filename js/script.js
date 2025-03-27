function more_info(){
    var lessHeight = $('#info').data('less-height');
    trueHeight = $('#info').outerHeight(false);
    if (trueHeight > lessHeight) {
        $('.info-toggle-arrow').css('display', 'inline-block');
        $('.info-toggle').show();
        $('#info').height(lessHeight);
    }
}
$(document).ready(function(){
    $('.info-toggle-button').click(function() {
        $('#info').toggleClass('info-more');
        $('.info-toggle-button').toggleClass('info-more-button');
        $('.info-toggle-arrow').toggleClass('info-more-arrow');
        return false;
    });
    $('.info-toggle-arrow').click(function() {
        $('#info').toggleClass('info-more');
        $('.info-toggle-button').toggleClass('info-more-button');
        $('.info-toggle-arrow').toggleClass('info-more-arrow');
        return false;
    });
});