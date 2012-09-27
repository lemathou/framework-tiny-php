<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Administration</title>
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/md5.js"></script>
<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".login").submit(function(){
		var password = MD5_hexhash($(".login input[name=password_bis]").val());
		$(".login input[name=password]").val(password);
		$(".login input[name=password_bis]").val("");
		return true;
	});
});
</script>
<link href="css/common.css" rel="stylesheet" type="text/css" />
