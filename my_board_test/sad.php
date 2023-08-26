<?
require_once("conf.php");

 echo "<center><h1>".$lang[1043]."</h1></center><br />";
			echo "<div class=\"admcats\"><form method=\"get\" action=\"".$h."a/\"><input type=\"hidden\" name=\"action\" value=\"ads\" /><select name=\"id_category\" onchange=\"selcat(this.value,'resultcat');\"><option value=\"no\" selected=\"selected\">".$lang[99]." &rarr;</option>";
			$selectcat=mysql_query("SELECT * FROM jb_board_cat WHERE root_category = 0 ORDER by sort_index"); //cq();
			$name_cat=(defined('JBLANG') && constant('JBLANG')=='en')?'en_name_cat':'name_cat'; 
			while($selectcategory=mysql_fetch_assoc($selectcat)) echo "<option value=\"".$selectcategory['id']."\">".$selectcategory[$name_cat]." &rarr; </option>";
			echo "</select> <div id=\"resultcat\"></div> <input style=\"float:left; width:50px\" type=\"submit\" value=\"&rarr;\"></form></div><div style=\"clear:both\"></div>";
			
?>