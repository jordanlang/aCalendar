<li>
	<h2>
		<?php echo $title; ?>
	</h2>
	<p class="text-right text-small">
		created by <?php echo $autor; ?>
	</p>
	<p> 
		<?php echo $content; ?>
	</p>
	<p class="text-right">
		<?php if($editRight) { ?>
		<a href="<?=BASEURL?>/index.php/note/update_note/<?php echo $id; ?>"> Edit </a>
		<?php } ?>
		<?php if($deleteRight) { ?>
		<br>
		<a href="<?=BASEURL?>/index.php/note/delete_note_shared/<?php echo $id; ?>"> Delete </a>
		<?php } ?>
	</p>
	<p class="text-right text-small">
		last edit by <?php echo $lastEditer; ?>
		<br>
		added <?php echo $addDate; ?>
	</p>
</li>