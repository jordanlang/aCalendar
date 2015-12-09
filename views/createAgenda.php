<h2 class="text-center">Création d'un nouveau calendrier</h2>

<form method="post" action="<?=BASEURL?>/index.php/calendar/add_calendar">
	<div class="formline">
		<label for="title">Titre</label>
		<input type="text" id="title" name="title">
	</div>
	<div class="formline">
		<label for="content">Description</label>
		<textarea type="text" id="content" name="content" rows="8"></textarea>
	</div>
	<div class="formline">
		<input type="checkbox" name="intersection" value="Permettre les intersections d'activités">
		<input type="checkbox" name="prive" value="Calendrier public">
		<input type="checkbox" name="partage" value="Calendrier en partage">
	</div>
	
	<div class="formline">
		<input type="submit" value="Create">
	</div>
</form>