<?php
/*
CMS by Christoph Miksche
Website: http://cms.wronnay.net
License: GNU General Public License
*/
error_reporting(0);
ini_set('session.use_only_cookies', 1);
session_start();
ob_start();
include '../inc/lang.php'; // Sprache
include '../inc/config.php'; // Datenbankdaten
if($DBTYPE == 'sqlite') { $dbc = new PDO(''.$DBTYPE.':../db/'.$DB.'.sql.db'); }
elseif($DBTYPE == 'mysql') { $dbc = new PDO(''.$DBTYPE.':host='.$HOST.';dbname='.$DB.'', ''.$USER.'', ''.$PW.''); }
include '../inc/functions.php'; // Funktionen
include '../inc/data.php'; // Informationen
include 'inc/check.php';
include 'inc/header.php';
?>
<article>
 <?php
switch($_GET["action"]){
  case "":
?>
<h2><?php echo w37; ?>:</h2>
<div style="float:left; margin:10px; padding:10px;"><a href="sites.php?action=new"><?php echo w50; ?></a></div>
<?php
    $sql = "SELECT
	                id,
	                autor_id,
		        name,
                        title,
                        text,                
			date,
                        description,
                        tags,
                        pic,
                        lang
            FROM
                    ".$PREFIX."_sites
            ORDER BY
                    date DESC
           ";
    $dbpre = $dbc->prepare($sql);
    $dbpre->execute();
		if ($dbpre->rowCount() < 1) {
	    echo w110;
	}
    while ($row = $dbpre->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class=\"comment\"><b>".nocss($row['title'])."</b> <a href=\"sites.php?action=edit&id=".nocss($row['id'])."\" title=\"".w8."\"> <img src=\"../../design/pics/icons/silk/page_white_edit.png\" alt=\"".w8."\" title=\"".w8."\" /></a>
<a href=\"sites.php?id=".nocss($row['id'])."&action=del\" title=\"".w52."\"><img src=\"../../design/pics/icons/standard/close2r.png\" alt=\"".w52."\" title=\"".w52."\" /></a><p style=\"padding:5px; margin:0px;\">".w53.": ".nocss($row['date'])."</p></div>\n";
    }
?>
<?php
  break;
  case "new":
include 'inc/newsite.php';
  break;
  case "del":
if(isset($_GET['id'])){
      $dbpre = $dbc->prepare("DELETE FROM ".$PREFIX."_sites WHERE id='".presql($_GET['id'])."'");
      $dbpre->execute();
	  echo w111;
}
  break;
  case "edit":
include 'inc/editsite.php';
  break;
}
?>
</article>
<?php
include 'inc/footer.php';
ob_end_flush();
?>
