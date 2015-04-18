$(window).load(function() {
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
		};
		var dataString = 'selected_topics='+ selected_topics;
		$.ajax({
			type: "POST",
			url: '<?php echo base_url()."play/quotes/".$play_type;?>',
			data: dataString,
			cache: false,
			success: function(result){
				// alert(result);
				window.location.replace('<?php echo base_url()."play/quotes/".$play_type;?>');
			}
		});
    });
});