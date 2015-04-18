<div class="container">
	<h3 style="color:#46b525">Quotes &amp; Famous Dialogues</h3>
	<hr>

	<div class="row-fluid">
		<div class="col-md-8">
		<?php if ($written) {?>
		<p>Your quote translation has been successfully uploaded. Thanks for your contribution!</p>
		<?php }else{?>
		<p>A translation for this quote has already been registered. Thanks for your support.</p>
		<?php }?>
		Please click <a href="<?php echo base_url().'play/quotes/practice';?>">here</a> to continue.
		</div>
	</div>
</div>