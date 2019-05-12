$(function () {
    $('#checkbox').change(function () {
        setInterval(function () {
            moveRight();
        }, 3000);
    });

    let slideCount = $('#slider ul li').length;
    let slideWidth = $('#slider ul li').width();
    let slideHeight = $('#slider ul li').height();
    let sliderUlWidth = slideCount * slideWidth;

    $('#slider').css({ width: slideWidth, height: slideHeight });

    $('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });

    $('#slider ul li:last-child').prependTo('#slider ul');

    let moveLeft = function () {
        $('#slider ul').animate({
            left: + slideWidth
        }, 300, function () {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    let moveRight = function () {
        $('#slider ul').animate({
            left: - slideWidth
        }, 300, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    $('a.control_prev').click(function (event) {
        event.preventDefault();
        moveLeft();
    });

    $('a.control_next').click(function (event) {
        event.preventDefault();
        moveRight();
    });
});