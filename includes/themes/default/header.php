<?php
 if( !defined('PHURL' ) ) {
 header('HTTP/1.0 404 Not Found');
     exit();
 }

$getalias = trim(mysql_real_escape_string($_SERVER['REQUEST_URI'], $mysql['connection']));
$alias = substr($getalias, 1, strlen($getalias));
$alias = str_replace("-","",$alias);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo get_phurl_option('site_title'); ?> | <?php echo get_phurl_option('site_slogan'); ?></title>
<?php
if (isset( $WORKING_DIR )) {
?>
<base href="<?php echo $WORKING_DIR; ?>">
<?php
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_phurl_option('theme_path'); ?>style.css" />
	<script type="text/javascript" src="<?php echo get_phurl_option('theme_path'); ?>jquery.js"></script>
	<script type="text/javascript"> 
	var tourl;
	$(document).ready(function(){
	$("input#url").bind("textchange",showPage);
	<?php
	if (strlen($alias) > 1) {
	echo "showPage();";
	}
	?>
	$("input#url").focus();	
	$("form#surlform").submit(function(){
		var url = $("input#url").val();	
		var apiKey = '<?php echo currentApiKey(); ?>'
		$.get("api/create.php?a=&url=" + url + "&apiKey="+apiKey, function(data) {
        		$("input#url").val(data);
        		$("input#url").select();
				$('#button').hide();
				$('#hbutton').show();
				tourl = data;
				$('#hbutton').bind('click', function() {
					window.location = tourl + "-";
				});
				var lastText = jQuery('input#url').val();
				jQuery('div#input').on('keyup', 'input#url', function() {
				if(jQuery(this).val() !== lastText) {
					toggleButtons();
				}
				    lastText = jQuery(this).val();
				});
    		});
   		return false;
	});
	});
	
	$(document).click(function(){
		showPage();
    });
	$(document).mousemove(function(){
		showPage();
    });
	function toggleButtons() {
		$('#hbutton').hide();
		$('#button').show();
	}
	function showPage() {
		$("#show-options").animate({ opacity: 1}, 2000);
		$("#header").animate({ opacity: 1}, 1000);
		$(".notice").animate({ opacity: 1}, 1000);
		$("#footer").animate({ opacity: 1}, 1000);
	}

</script>
<?php
$jquery = <<<JQUERY
<script>
 $(document).ready(function() {
 	 $("#dynamicdiv").load("includes/dynstats.php?alias=$alias");
   var refreshId = setInterval(function() {
      $("#dynamicdiv").load('includes/dynstats.php?alias=$alias');
   }, 9000);
   $.ajaxSetup({ cache: false });
});
</script>
JQUERY;
echo $jquery;
?>

</head>
<body>
<div id="container">
 <div id="header">
 	<div id="logo"><h1><?php echo get_phurl_option('site_title'); ?></h1></div>
 	<span id="slogan">- <?php echo get_phurl_option('site_slogan'); ?></span>
 		<ul id="menu">
 			<li><a href="/">Home</a></li>
<?php //<li><a href="/api/create.php?url=http://example.org/">API</a></li> ?>
	<?php if (is_login()) { ?>
<li>
        <a href="#">My Account</a>
        <ul>
            <li><a href="/admin/">My URLs</a></li>
            <li><a href="/admin/api.php">Developer</a></li>
            <li><a href="/admin/account.php">Account Settings</a></li>
        </ul>
    </li>
	<?php if (is_admin_login()) { ?>
<li>
        <a href="#">Site Administration</a>

        <ul>
            <li><a href="/admin/?list=all">Site URLs</a></li>
            <li><a href="/admin/users.php">Site Users</a></li>
            <li><a href="/admin/site.php">Site Settings</a></li>
        </ul>

    </li>
	<?php } ?>
 			<li><a href="/admin/logout.php">Logout</a></li>
	<?php } else { ?>
 			<li><a href="/admin/login.php">Login/Signup</a></li>
	<?php } ?>


 		</ul>
 	<div class="clear"></div>
 	
 </div>
<div id="content">
