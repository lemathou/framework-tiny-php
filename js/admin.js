var editor;
CKEDITOR.on( 'instanceReady', function( ev ) {
	editor = ev.editor;
	//editor.setReadOnly( false );
	//console.log('readonly');
});
CKFinder.setupCKEditor( null, '/js/ckfinder/' );

$(document).ready(function(){
	$(".login").submit(function(){
		var password = MD5_hexhash($(".login input[name=password_bis]").val());
		$(".login input[name=password]").val(password);
		$(".login input[name=password_bis]").val("");
		return true;
	});
});

