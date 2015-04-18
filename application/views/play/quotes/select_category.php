<?php
$author_urls = $authors;

for ($i=0; $i < count($authors) ; $i++) { 
	$parts = explode('_', $authors[$i]);
	for ($j=0; $j < count($parts) ; $j++) { 
		$parts[$j] = ucfirst($parts[$j]);
	}
	$authors[$i] = implode(' ', $parts);
}
?>
<div class="container">
	<h3 style="color:#46b525">Quotes &amp; Famous Dialogues</h3>
	<hr>
	<h4 class='page-heading'>Select some categories</h4><br>
	<a href="#" class="btn btn-default">Random</a><br><br>
	<div class="">
			<span class="dropdown" style="font-size:18px">
				Or <br><br>Filter By
				<button class="btn btn-default dropdown-toggle" type="button" id="select_category" name="select_category" data-toggle="dropdown" style="border:none;font-size:16px">
				</button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#" id="authors">Authors</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#" id="topics">Topics</a></li>
				</ul>
			</span><br><br>
			<a href="#" id="checkall">Select All</a>
	</div>
	<hr>
	<div class="row-fluid" id="authors_list">
		<div class="col-xs-6 col-sm-4 col-md-3" style="max-height:360px">
			<?php
				$num_auth = count($authors);
				$times = $num_auth/4;
				for ($i=0; $i < $times; $i++) { 
					echo '<paper-checkbox role="checkbox" tabindex="0" aria-checked="false" class="paper_chk" name="'.$author_urls[$i].'" id="'.$author_urls[$i].'"></paper-checkbox> &nbsp;'.$authors[$i]."<br><br>";
				}
				$start = $i;
				echo "<br>";
			?>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3" >
			<?php 
				for ($i=$start; $i < 2*$times; $i++) { 
					echo '<paper-checkbox role="checkbox" tabindex="0" aria-checked="false" class="paper_chk" name="'.$author_urls[$i].'" id="'.$author_urls[$i].'"></paper-checkbox> &nbsp;'.$authors[$i]."<br><br>";
				}
				$start = $i;
				echo "<br>";
			?>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3" >
			<?php 
				for ($i=$start; $i < 3*$times; $i++) {
					echo '<paper-checkbox role="checkbox" tabindex="0" aria-checked="false" class="paper_chk" name="'.$author_urls[$i].'" id="'.$author_urls[$i].'"></paper-checkbox> &nbsp;'.$authors[$i]."<br><br>";
				}
				$start = $i;
				echo "<br>";
			?>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3" >
			<?php
				for ($i=$start; $i < count($authors); $i++) {
					echo '<paper-checkbox role="checkbox" tabindex="0" aria-checked="false" class="paper_chk" name="'.$author_urls[$i].'" id="'.$author_urls[$i].'"></paper-checkbox> &nbsp;'.$authors[$i]."<br><br>";
				}
				echo "<br>";
			?>
		</div>
	</div>
	<div class="row_fluid" id="topics_list">
		<div class="col-xs-6">
			<?php
				$num_top = count($topics);
				$times = $num_top/2;
				for ($i=0; $i < $times; $i++) { 
					echo '<paper-checkbox role="checkbox" tabindex="0" aria-checked="false" class="paper_chk" name="'.lcfirst($topics[$i]).'" id="'.lcfirst($topics[$i]).'"></paper-checkbox> &nbsp;'.$topics[$i]."<br><br>";
				}
				$start = $i;
				echo "<br>";
			?>
		</div>
		<div class="col-xs-6">
			<?php 
				for ($i=$start; $i < 2*$times; $i++) { 
					echo '<paper-checkbox role="checkbox" tabindex="0" aria-checked="false" class="paper_chk" name="'.lcfirst($topics[$i]).'" id="'.lcfirst($topics[$i]).'"></paper-checkbox> &nbsp;'.$topics[$i]."<br><br>";
				}
				echo "<br>";
			?>
		</div>
	</div>
	<span class="clearfix"></span>
	<div class="row-fluid">
		<div class="col-xs-12">
			<paper-checkbox role="checkbox" tabindex="0" aria-checked="true" checked="false" name="remember_me" value="Remember me checkbox"></paper-checkbox> Remember my selections<br><br>
			<input class="btn btn-default" type="submit" value="Submit" id="submit" />
		</div>
	</div>
</div>
<script type="text/javascript">
	var category = "authors";

	$('#select_category').html('Authors &nbsp; <span class="caret"></span>');
	
	$("#authors_list").show();
	$("#topics_list").hide();
	
	$('#authors').click(function(){
		$('#select_category').html('Authors &nbsp; <span class="caret"></span>');
		$('#topics_list').fadeOut();
		$('#authors_list').fadeIn();
		category = "authors";
	});
	$('#topics').click(function(){
		$('#select_category').html('Topics &nbsp; <span class="caret"></span>');
		$('#authors_list').fadeOut();
		$('#topics_list').fadeIn();
		category = "topics";
	});

    $('#checkall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.paper_chk').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.paper_chk').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });

	// Sending the form data

    $("#submit").click(function(){
		if (category === "authors") {
			var authors = new Array();
		    <?php foreach($author_urls as $a ){ ?>
		        authors.push('<?php echo $a; ?>');
		    <?php } ?>

		    var a;
		    var selected_authors = new Array();
		    for (a in authors){
		    	if ($("#"+authors[a]).attr("aria-checked")=="true") {
		    		selected_authors.push(authors[a]);
		    	};
		    };
			var dataString = 'selected_authors='+ selected_authors;
		}
		else if (category === "topics") {
			var topics = new Array();
		    <?php foreach($topics as $t ){ ?>
		        topics.push('<?php echo lcfirst($t); ?>');
		    <?php } ?>
		    var t;
		    var selected_topics = new Array();
		    for (t in topics){
		    	if ($("#"+topics[t]).attr("aria-checked")=="true") {
		    		selected_topics.push(topics[t]);
		    	};
		    };
			var dataString = 'selected_topics='+ selected_topics;
		};

		$.ajax({
			type: "POST",
			url: '<?php echo base_url()."play/quotes/".$play_type;?>',
			data: dataString,
			cache: false,
			success: function(result){
				window.location.replace('<?php echo base_url()."play/quotes/".$play_type;?>');
			}
		});
    });
</script>