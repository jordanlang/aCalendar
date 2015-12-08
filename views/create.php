<h2 class="text-center">Create new note</h2>

<form method="post" action="<?=BASEURL?>/index.php/note/add_note">
	<div class="formline">
		<label for="title">Title</label>
		<input type="text" id="title" name="title">
	</div>
	<div class="formline">
		<label for="content">Text</label>
		<textarea type="text" id="content" name="content" rows="8"></textarea>
	</div>
	<div class="formline">
		<input type="submit" value="Create">
	</div>
</form>