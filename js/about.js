$(document).ready(function(){
    $(".team-member").hover(function(){
        $(this).css("transform", "scale(1.05)");
    }, function(){
        $(this).css("transform", "scale(1)");
    });
    $(".project-adviser").hover(function(){
        $(this).css("transform", "scale(1.05)");
    }, function(){
        $(this).css("transform", "scale(1)");
    });
});