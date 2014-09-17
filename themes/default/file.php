<?php
include 'header-title.php';
?>
<script type="text/javascript">
$(document).ready(function(){
	Copy();
	$(".btnCopy").click(function() {
		changeView();
	});
	$("textarea").click(function() {
		var textarea = $('textarea.content');
		selectAll(textarea);
	});
});

function Copy(){
	var textarea = $('textarea.content');
	var pre = $('pre.prettyprint');

	var content = htmlDecode(pre.html());

	textarea.val(content.replace(/<br ?\/?>/g, "\n")); 
	textarea.attr('rows',textarea.val().split("\n").length)
}

function changeView(){
	var textarea = $('textarea.content');

	$( ".codeDisplay" ).toggle();
	selectAll(textarea);
}

function selectAll(elmt) {
    var $this = $(elmt);
    $this.select();

    // Work around Chrome's little problem
    $this.mouseup(function() {
        // Prevent further mouseup intervention
        $this.unbind("mouseup");
        return false;
    });
}

function htmlDecode(value) {
	if (value) {
		return $('<div />').html(value).text();
	} else {
		return '';
	}
}

</script>
	<div class="row">
<?php
include 'breadcrumb.php';
?>
	<div class="col-lg-3 col-sm-5">

	<?php
		include 'modules/SingleRevControl.php';
		include 'modules/date.php';
		include 'modules/author.php';
		include 'modules/msg.php';
		include 'modules/goToTop.php';
	?>
	</div>
	<div class="col-lg-9 col-sm-7">

	<?php
		$supported_image = array(
		    'gif',
		    'jpg',
		    'jpeg',
		    'png'
		);

		$ext = strtolower(pathinfo(getPath(), PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
		if (in_array($ext, $supported_image)) {
		    ?>
				<img class="img-responsive" src="data:image/<?php echo $ext ?>;base64,<?php echo getFile(true) ?>">
			<?php
		} else {
			?>
			<pre class="prettyprint linenums codeDisplay"><?php echo trim(htmlspecialchars(getFile())); ?></pre>
			<textarea readonly style="resize: none;display: none;white-space: nowrap;overflow-wrap: normal;" class="form-control col-md-12 content codeDisplay" style="display:none;"></textarea>
			<?php
		}
		
		/*<div class="alert alert-error" role="alert">Le fichier <strong><?php echo getRepoPath().getPath() ?></strong> n'éxiste pas.</div>
		*/
	?>
	</div>
<?php
?>
