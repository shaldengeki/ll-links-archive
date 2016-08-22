<?php

//lsearch.php
//handler for link searches.

include_once('includes.php');

if (!logged_in()) {
    //eject this user.
    header("Location: index.php?r=".urlencode($_SERVER['REQUEST_URI']));
    exit;
}

display_header("Advanced Search");

?>
<h1>Advanced Search</h1>
  <br /><form action="links.php" method="get">
  <input type="hidden" name="mode" value="as">
  <table class="search">
    <tr>
      <th rowspan="5" width="33%"><b>Find links</b></th>
      <th width="34%">with <b>all</b> of the words</th>

      <th width="33%"><input type="text" name="s_aw" size="25"></th>
    </tr>
    <tr>
      <th>with the <b>exact phrase</b></th>
      <th><input type="text" name="s_ep" size="25"></th>
    </tr>
    <tr>
      <th>with <b>at least one</b> of the words</th>

      <th><input type="text" name="s_ao" size="25"></th>
    </tr>
    <tr>
      <th><b>without</b> the words</th>
      <th><input type="text" name="s_wo" size="25"></th>
    </tr>
    <tr>

      <th>in</th>
      <th>
        <input type="radio" name="s_to" value="0" checked="true">All fields</input>&nbsp;
        <input type="radio" name="s_to" value="1">Title</input>
      </th>
    </tr>
    <tr>

      <td><b>Date added is</b></td>
      <td><select name="t_t" size="1"><option value="1">within<option value="2">older than</select></td>
      <td><input type="text" name="t_f" size="11"> <select name="t_m" size="1"><option value="60">minutes<option value="3600">hours<option value="86400" selected>days</select></td>
    </tr>
    <tr>

      <td><b>Link rating is</b></td>
      <td><select name="v_t" size="1"><option value="1">at least<option value="2">no more than</select></td>
      <td><input type="text" name="v_f" size="25"></td>
    </tr>
    <tr>
      <td><b>Number of votes is</b></td>
      <td><select name="n_t" size="1"><option value="1">at least<option value="2">no more than</select></td>

      <td><input type="text" name="n_f" size="25"></td>
    </tr>
    <tr>
      <th colspan="3" style="text-align: center"><b>Categories</b></th>
    </tr>
    <tr>
      <input type="hidden" name="exclude" value="0">
      <input type="hidden" name="category" value="0">
      <th></th>
      <th style="text-align: center;">

    <div class="filter-container">
	<div class="filter-column">&nbsp;
	</div>
      <div class="filter-column">
        <b>Must include</b><br />
        <select name="c_is" size="10" multiple="multiple"><option value="Anime">Anime</option><option value="Books">Books</option><option value="Comics">Comics</option><option value="Console Games">Console Games</option><option value="Educational">Educational</option><option value="Freebies/Deals">Freebies/Deals</option><option value="Foreign Language">Foreign Language</option><option value="Furry">Furry</option><option value="Gay Porn">Gay Porn</option><option value="Hentai">Hentai</option><option value="Humor">Humor</option><option value="Movies">Movies</option><option value="Music">Music</option><option value="News Article">News Article</option><option value="NLS">NLS</option><option value="PC Games">PC Games</option><option value="Pictures">Pictures</option><option value="Porn">Porn</option><option value="Portable Games">Portable Games</option><option value="Shopping">Shopping</option><option value="Software">Software</option><option value="Sports">Sports</option><option value="Traditional Games">Traditional Games</option><option value="TV Shows">TV Shows</option><option value="Text">Text</option><option value="Uploads">Uploads</option><option value="Videos">Videos</option><option value="Other">Other</option></select><br />
      </div>
	 <div class="filter-column">&nbsp;
	 </div>
	  </div>      </th>
      <th></th>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center"><input type="submit" name="go" value="Search"></th>
    </tr>
  </table>
  </form>
  <?php
  display_footer();
  ?>