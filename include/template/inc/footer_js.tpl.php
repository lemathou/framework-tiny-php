<script type="application/javascript" src="/js/jquery-1.11.1.min.js"></script>
<script type="application/javascript" src="/js/jquery.zoom.min.js"></script>
<script type="application/javascript" src="/js/jquery.jcarousel.min.js"></script>
<script type="application/javascript" src="/js/jquery.jcarousel.basic.js"></script>
<script type="application/javascript" src="/js/md5.js"></script>
<script type="application/javascript" src="/js/common.js"></script>
<?php if (isset($this->header["js"]) && is_array($this->header["js"])) foreach($this->header["js"] as $i) if ($i) { ?>
<script type="application/javascript" src="/js/<?php echo $i; ?>.js"></script>
<?php } ?>
<script type="text/javascript">
/* Analytics */
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52271684-1', 'auto');
  ga('send', 'pageview');

/* G+ */
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/platform.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
/* Facebook */
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.0";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

