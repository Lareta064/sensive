
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<div class="d-flex flex-row">
		<input class="form-control" name="s" placeholder="Search" required="" type="text" value="<?php echo get_search_query(); ?>"  id="s">
		<button class="click-btn btn btn-default bbtns" id="searchsubmit"><i class="ti-search"></i></button>
	</div>
</form>
