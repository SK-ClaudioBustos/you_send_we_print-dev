<h1><?=$title?></h1>

<form method="post" id="checkout_form" action="<?=$app->page_full?>">
	<p>
		<label for="base_date">Date</label>
		<input type="text" name="base_date" id="base_date" value="<?=$base_datetime?>" />
	</p>
	<p>
		<label for="base_date">Turnaround</label>
		<input type="text" name="turnaround" id="turnaround" value="<?=$turnaround?>" />
	</p>
	<p>
		<input type="hidden" name="action" value="calc" />
		<button type="submit">Send</button>
	</p>

	<div style="margin: 20px 0;">
		<p><?=$show_info?></p>
	</div>

</form>