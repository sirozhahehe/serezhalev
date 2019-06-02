type="text/javascript"
$("body").on('click', '[href*="#pre"]', function(e){
  var fixed_offset = 0;
  $('html,body').stop().animate({ scrollTop: $(this.hash).offset().top - fixed_offset }, 400);
  e.preventDefault();
});