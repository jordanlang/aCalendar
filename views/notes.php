<li>
	<h2>
		<?php echo $title; ?>
	</h2>
	<p> 
		<?php echo $content; ?>
	</p>
	<p class="text-right">
		<a href="<?=BASEURL?>/index.php/note/update_note/<?php echo $id; ?>"> Edit </a>
		<br>
		<a href="<?=BASEURL?>/index.php/note/delete_note/<?php echo $id; ?>"> Delete </a>
	</p>
	<p class="text-right text-small">
		last edit by <?php echo $lastEditer; ?>
		<br>
		<?php echo $addDate; ?>
	</p>
</li>