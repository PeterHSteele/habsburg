<?php

/* renders a searchbar
*
* @package hapsburg

*/

?>

<form method='get' action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="control">
		<input type='text' required placeholder="search" id='search' name='s'>
		<button type="submit">
			<i class="fa fa-search"></i>
		</button>
	</div>
</form> 
