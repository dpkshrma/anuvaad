<div class="container">
	<h3 style="color:#46b525">Quotes &amp; Famous Dialogues</h3>
	<hr>

	<div class="row-fluid">
		<div class="col-md-8 main_content">
			<div class="row-fluid quot_elmnts">
					<div class="col-md-12">
						<span style="font-size:16px;color:#444">Original Quote: </span><br><br>
						<div class="english_div">
							<!-- <img id="loading" src="<?php //echo base_url().'assets/images/ajax-loader.gif'?>"> -->
							<span id="english_quote"></span>&nbsp;		
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="row-fluid quot_elmnts">
					<div class="col-md-12">
						<span style="font-size:16px;color:#444">Google Translation</span><br><br>
						<div class="english_div">
							<!-- <img id="loading" src="<?php //echo base_url().'assets/images/ajax-loader.gif'?>"> -->
							<span id="hindi_quote"></span>&nbsp;		
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="row-fluid quot_elmnts">
					<div class="col-md-12">
						<span style="font-size:16px;color:#444">Your Translation</span><br><br>
						<textarea class="form-control" id="en_trans" style="width:100%" rows="5"></textarea>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="row-fluid" id="btns_row">
					<div class="col-md-12">
						<a href="#" class="btn btn-success pull-right" id="submit_quote">Submit</a>
					</div>
				</div>
		</div>
	</div>
</div>
<script> var s = document.createElement('script'); s.setAttribute('src','http://developer.quillpad.in/static/js/quill.js?lang=Hindi&key=9f335b3d7dd39ce98b759b118cbfce92'); s.setAttribute('id','qpd_script'); document.head.appendChild(s); </script> 
<script type="text/javascript">
$(document).ready(function(){
	var en_trans;
	$("#english_quote").html("<?php echo $english_text; ?>");
	$("#hindi_quote").html("<?php echo $hindi_text; ?>");
	$("#submit_quote").click(function(){
		en_trans = $("#en_trans").val();
		window.location.replace("<?php echo base_url().'contribute/submit_improved_quote/'.$quote_id.'/';?>"+en_trans);
	});
});
</script>