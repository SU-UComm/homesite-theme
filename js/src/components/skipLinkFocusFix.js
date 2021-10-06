document.addEventListener('DOMContentLoaded', function() {

  $ = jQuery;

  $('#skiplinks').click(function(e){
    var href = $(this).attr('href').substr(1); // remove the #
    var target = $('a[name="' + href + '"]');
    $(this).blur();
    target.focus().console.log('hello skiplinks');
  });

});