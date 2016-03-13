
$(function(){
	$('.delete').click(function(){
		if ($(this).parent().parent().parent().hasClass('directory')) var name = 'directory';
		else var name = 'file';
		
		return confirm('Deleting' + name + ' Are you sure ');
	});
	
	$('.list-directory ul').css({ display: 'none' });
	$('.list-directory strong').css({ cursor: 'pointer' }).click(function(){
		var $this = $(this);
		
		$this.siblings('ul').slideToggle();
	});
	
	$('#dir').change(function(){
		window.location = 'index.php?dir=' + $(this).val();
	});
	$('#change').find('input[type=submit]').css('display', 'none');
});