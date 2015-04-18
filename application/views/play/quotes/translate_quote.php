<?php

if (isset($selected_authors)){
	$source_names = $selected_authors;
	$source_uris = $selected_authors;
}else if (isset($selected_topics)){
	$source_names = $selected_topics;
	$source_uris = $selected_topics;
}
else
	redirect('play/quotes/'.$play_type);

for ($i=0; $i < count($source_names) ; $i++) {
	$parts = explode('_', $source_names[$i]);
	for ($j=0; $j < count($parts) ; $j++) { 
		$parts[$j] = ucfirst($parts[$j]);
	}
	$source_names[$i] = implode(' ', $parts);
}

?>
<style type="text/css">
	.hindi_div,#rite_trans{
		padding: 6px 12px;
		border: 1px solid #ccc;
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		border-radius: 4px;
	}
	.hindi{
		font-family: "mangal";
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;

		display: none;

		/*disable text copying */
		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		-webkit-locale: hi;
	}
	.author_name{
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
		display: none;
		color: #777;
	}
	#quotes_eval{
		position: relative;
		width:100%;
		height:100%;
	}
	#quotes_res_msg{
		display: none;
		position: absolute;
		width:100%;
		height:100%;
		background-color: rgba(255,255,255,0.5);
		z-index: 1000;
	}
	.blur{
	    -webkit-filter: blur(4px);
	    -moz-filter: blur(4px);
	    -ms-filter: blur(4px);
	    -o-filter: blur(4px);
	    filter: blur(4px);
	}
	a.glyphicon-thumbs-up,a.glyphicon-thumbs-down {
	    font-size: 1.5em;
		text-decoration: none;
	}
	a.glyphicon-thumbs-up{
		color: #46b525;
	}
	a.glyphicon-thumbs-down{
		color: #c7254e;
	}
	#en_trans:focus{
		border-color: #46b525;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(70,181,37, 0.6);
	}
	.list-group.panel > .list-group-item {
		border-bottom-right-radius: 4px;
		border-bottom-left-radius: 4px
	}
	.list-group-submenu {
		margin-left:20px;
	}
	#loading{
		display: none;
	}
	#submit_quote, #next_quote{
		display: none;
	}
</style>

<div class="container">
	<h3 style="color:#46b525">Quotes &amp; Famous Dialogues</h3>
	<hr>

	<div class="row-fluid">
		<div class="col-md-8 main_content">
			<div id="quotes_eval">
				<div id="quotes_res_msg">
					<div class="row-fluid">
						<div class="col-md-12" id="submit_quote_msg">
						</div>
					</div>
					<br><br>
					<div class="row-fluid">
						<div class="col-md-6">
							<h4 style="color:#2A6D16">Vote the quote</h4>
							<a class="glyphicon glyphicon-thumbs-up" href=""></a>&nbsp;
							<span id="vote_up_no">0</span>&nbsp;&nbsp;
							<a class="glyphicon glyphicon-thumbs-down" href=""></a>&nbsp;
							<span id="vote_down_no">0</span>
						</div>
						<div class="col-md-6">
							<h4 style="color:#2A6D16">Share with your friends</h4>
						</div>
					</div>
				</div>
				<div class="row-fluid quot_elmnts">
					<div class="col-md-12" id="hindi_col">
						<span style="font-size:16px;color:#444">Translate this quote to english: </span><br><br>
						<div class="hindi_div">
							<img id="loading" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>">
							<span class="hindi notranslate"></span>&nbsp;		
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="row-fluid quot_elmnts">
					<div class="col-md-12">
						<span style="font-size:16px;color:#444">and type here</span><br><br>
						<textarea class="form-control" id="en_trans" style="width:100%" rows="5"></textarea>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="row-fluid quot_elmnts">
					<div class="col-md-12">
						<div class="progress">
						  <div class="progress-bar progress-bar-striped progress-bar-success active" id="score-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:">
						    <span class="sr-only">45% Complete</span>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="progress">
						  <div class="progress-bar progress-bar-striped progress-bar-info active" id="time-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:">
						    <span class="sr-only">45% Complete</span>
						  </div>
						</div>
					</div>
				</div>
			</div>
			<div class="row-fluid" id="btns_row">
				<div class="col-md-12">
					<a href="#" class="btn btn-success pull-right" id="next_quote">Next</a>
					<a href="#" class="btn btn-success pull-right" id="submit_quote">Submit</a>
				</div>
			</div>
		</div>
		<br>
		<br>
		<div class="col-md-4">
			<div id="MainMenu">
			  <div class="list-group panel">
			    <a href="#demo4" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu">Report</a>
			    <div class="collapse" id="demo4">
			      <a href="#demo4a" class="list-group-item"  data-toggle="collapse" data-parent="#demo4">Incorrect Quote</a>
			      <div class="collapse list-group-submenu list-group-submenu-1" id="demo4a">
				      <a href="" class="list-group-item">Quote Language is incorrect</a>
				      <a href="" class="list-group-item">Quote Author is incorrect</a>
			      </div>
			      <a href="" class="list-group-item">Inappropriate Quote</a>
			    </div>
			    <a href="#demo5" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu">Contribute</a>
			    <div class="collapse" id="demo5">
					<a href="#demo5a" class="list-group-item"  data-toggle="collapse" data-parent="#demo5">Improve Google Translation</a>
				    <div class="collapse list-group-submenu list-group-submenu-1" id="demo5a">
						<a href="" id="improve_current_quote" class="list-group-item">Current Quote</a>
						<a href="" class="list-group-item">From Incorrect Quote List</a>
					</div>
			    </div>
			    <a href="<?php echo base_url().'play/quotes_category/practice'; ?>" class="list-group-item list-group-item-success" data-parent="#MainMenu">Change Category</a>
			  </div>
			</div>
			<!-- end of MainMenu -->
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/js/similar_text.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/progressTimer.js'; ?>"></script>
<script type="text/javascript">
$(document).ready(function(){

	var en_text;
	var source_names = new Array();
	var source_uris = new Array();
	var num_of_sources;
	var percent = 0;
	var uri = 0;
	var total_available_quotes;
	var max_quotes_per_cat = 25;
	var remaining_quotes_per_cat = max_quotes_per_cat;
	var quote_id;
	var iquo;
	var msg1, msg2;
	var is_auth=0;

	<?php foreach ($source_names as $source_name) {?>
		source_names.push('<?php echo $source_name; ?>');
	<?php }?>

	<?php foreach ($source_uris as $source_uri) {?>
		source_uris.push('<?php echo $source_uri; ?>');
	<?php }?>

	num_of_sources = source_uris.length;
	total_available_quotes = num_of_sources*max_quotes_per_cat;

	function getquote (iauthor,iquote,index_auth,is_author) {
		$.ajax({
			type:"POST",
			url:"<?php echo base_url().'play/get_quote/"+iauthor+"/"+iquote+"/"+is_author+"'; ?>",
			dataType: "json",
			cache:false,
			success:function(result){
				if (result.submitted_quote) {
					show_quote(is_author);
				}else{
					$("#loading").fadeOut();
					$(".hindi").html(result.hindi_text);
					if (is_author) {
						$(".author_name").remove();
						$("#hindi_col").append("<span class='pull-right author_name'>"+source_names[index_auth]+"</span>");
					};
					setTimeout( function() {
						$(".hindi").fadeIn();
						if (is_author) {
							$(".author_name").fadeIn();
						};
					}, 300);
					en_text = result.english_text;
					quote_id = result.quote_id;
					progressTimer();
					console.log(quote_id);
					// console.log("%c"+en_text,"color:blue");
					$("#improve_current_quote").attr("href","<?php echo base_url().'contribute/quotes/';?>"+quote_id);
				}
			}
		});
	}

	function show_quote(is_auth){

		// console.log("%cNext Clicked","color:red");

		iquo = 25-remaining_quotes_per_cat;

		getquote(source_uris[uri],iquo,uri,is_auth);

		uri = (uri+1+num_of_sources)%num_of_sources;
		total_available_quotes--;
		remaining_quotes_per_cat = Math.ceil(total_available_quotes/num_of_sources);
		// console.log("source_uris[uri] : "+source_uris[uri]);
		// console.log("iquo : "+iquo);
		// console.log("total_available_quotes = "+total_available_quotes);
		// console.log("uri = "+uri);
		// console.log("remaining_quotes_per_cat = "+remaining_quotes_per_cat);
	}

	<?php if (isset($selected_authors)) { $is_author = 1;?>
		$(".author_name").fadeOut();
		is_auth = 1;
	<?php } else { $is_author = 0;?>
		$(".author_name").remove();
		is_auth = 0;
	<?php } ?>

	$("#loading").fadeIn();

	show_quote(is_auth);

	// generate realtime score
	$("#en_trans").keyup(function(e) {
		if (e.keyCode == 0 || e.keyCode == 32 || $("#en_trans").val().length >= (en_text.length-1)) {
			percent = similar_text($("#en_trans").val(),en_text);
			$('#score-bar').css("width",percent+'%');
			$('#score-bar').html("Score : "+Math.floor(percent)+"%");
		}
	});
	
	// Buttons
	
	$("#submit_quote").show();
	$("#submit_quote").click(function(){
		$("#submit_quote").hide();
		var secs = 0;
		var mins = 0;
		var time_left = $("#time-bar").text();
		time_left = time_left.split(" ");
		if (time_left[4] == "mins")
			mins = parseInt(time_left[3]);
		if (time_left[time_left.length-1] == "secs")
			secs = parseInt(time_left[time_left.length-2]);
		else
			secs = parseInt(time_left[time_left.length-1]);
		total_sec = mins*60+secs;
		console.log(total_sec);
		if (isNaN(percent)) percent = 0;
		$.ajax({
			type:"POST",
			url:"<?php echo base_url().'play/store_quote_score/"+quote_id+"/"+Math.floor(percent)+"/"+total_sec+"'; ?>",
			cache:false,
			async:false,
			success:function(){}
		});
		// send user input data + quotes data to play/quotes_calcscore
		if (percent>=95) {
			msg1 = "Awesome";
			msg2 = "Sometimes this is as accurate as it gets! :)";
		}else if (percent>=85) {
			msg1 = "Fantastic";
			msg2 = "You figured out more than 85% of the quote correctly! Woo hoo!"
		}else if (percent>=65) {
			msg1 = "Great Job, Buddy";
			msg2 = "You almost did it. Although the accurate quote would be this:";
		}else if (percent>=45) {
			msg1 = "Good One";
			msg2 = "Looks like you figured out most of the parts of the quote correctly.";
		}else if (percent>0) {
			msg1 = "Nice try";
			msg2 = "Tip : You can improve your score for this quote by trying it again <a href=''>here</a>";
		}else{
			msg1 = "Skipping?";
			msg2 = "Looks like you didnt try this one. If you didnt like this quote, give it a down vote, we wont mind :) or if you think something's wrong, then, just let us know.";
		}
		$("#submit_quote_msg").html("<h2 style='color:#46b525'>"+msg1+"</h2><span style='font-size:16px;'>"+msg2+"</span><br><br><h4 style='color:#2A6D16'>Correct Translation</h4><p id='rite_trans'></p>");
		$("#rite_trans").html(en_text);
		$("#quotes_res_msg").fadeIn("slow");
		$(".quot_elmnts").addClass("blur");
		$("#next_quote").show();
	});

	$("#next_quote").click(function(){
		ClearAllIntervals();
		percent = 0;
		$('#score-bar').css("width",'0%');
		$("#quotes_res_msg").fadeOut();
		$(".quot_elmnts").removeClass("blur");
		$("#en_trans").val("");

		$(".hindi").fadeOut();

		var is_auth;
		<?php if (isset($selected_authors)) { $is_author = 1;?>
			$(".author_name").fadeOut();
			is_auth = 1;
		<?php } else { $is_author = 0;?>
			$(".author_name").remove();
			is_auth = 0;
		<?php } ?>

		$("#loading").fadeIn();

		if (total_available_quotes>0) {
			show_quote(is_auth);
		}else{
			alert("no more quotes, come back later");
		}
		$("#next_quote").hide();
		$("#submit_quote").show();
	});

});
</script>