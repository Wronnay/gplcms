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
if($DBTYPE == 'sqlite') {
$dbc = new PDO(''.$DBTYPE.':../db/'.$DB.'.sql.db');
}
elseif($DBTYPE == 'mysql') {
$dbc = new PDO(''.$DBTYPE.':host='.$HOST.';dbname='.$DB.'', ''.$USER.'', ''.$PW.'');
}
include '../inc/functions.php'; // Funktionen
include '../inc/data.php'; // Informationen
include 'inc/check.php';
include 'inc/header.php';
?>
<article>
<h2><?php echo w55; ?>:</h2>

<div style="float:left;"> <!-- class="spalte" -->
<?php
echo '<p>';
	if (isset($_POST['submit'])){
		$sql = "INSERT INTO ".$PREFIX."_kat1 (name, lang) VALUES ('".presql($_REQUEST['catname'])."', '".$lang."')";
		$dbpre = $dbc->prepare($sql);
		$dbpre->execute();
		if($dbpre->rowCount() == 1) {
			echo w56;
		} 
        else{
			echo w57;
     	}
	 }
    $sql = "SELECT
	                id,
                        name
            FROM
                    ".$PREFIX."_kat1
           ";
    $dbpre = $dbc->prepare($sql);
    $dbpre->execute();
	if ($dbpre->rowCount() < 1) {
	    echo w58;
	}
    while ($row = $dbpre->fetch(PDO::FETCH_ASSOC)) {
?>
<a href="cats.php?id=<?php echo nocss($row['id']); ?>"><img title="<?php echo w52; ?>" src="../../design/pics/icons/standard/close2r.png" alt="" /></a>
<?php echo nocss($row['name']); ?> (<b>id</b>: <?php echo nocss($row['id']); ?>)<br>
<?php
	}
?>

</p>
<?php
    if (is_numeric($_GET['id'])) {
?>
<div class="title"><b><?php echo w59; ?>:</b></div>
<p>
<?php	
    $catid = presql($_GET['id']);
    $query = "DELETE
                          FROM
				 ".$PREFIX."_kat1
			  WHERE
				 id = '".$catid."'";
	$dbpre = $dbc->prepare($query);
    $dbpre->execute(); 
    if($dbpre) {
		echo w60;
	}
	else{
		echo w61;
    }
?>
</p>
<?php
}
?>
</div>
<div style="float:right;">
<div class="title"><b><?php echo w62; ?>:</b></div>
<form action="cats.php" method="post" name="cat">
<input name="catname" class="li" type="text" size="40" /> <input name="submit" class="lb" type="submit" value="<?php echo w62; ?>" />
</form>
</div>

<div style="clear:right; padding-top:10px;"> 
<div style="float:left;"> <!-- class="spalte" -->
<div class="title"><b><?php echo w63; ?>:</b></div>
<?php
echo '<p>';
	if (isset($_POST['submit2'])){
        $sql = "INSERT INTO ".$PREFIX."_kat2 (name, kat1_id, beschreibung, lang) VALUES ('".presql($_REQUEST['cat2name'])."', '".presql($_REQUEST['kat1_id'])."', '".presql($_REQUEST['beschreibung'])."', '".$lang."')";
	$dbpre = $dbc->prepare($sql);
	$dbpre->execute(); 
	if($dbpre->rowCount() == 1) {
        echo w64;
	 } 
        else{
        echo w65;
     	}
	 }
    $sql = "SELECT
	                id,
                        name,
                        kat1_id,
                        beschreibung
            FROM
                    ".$PREFIX."_kat2
           ";
    $dbpre = $dbc->prepare($sql);
    $dbpre->execute();
	if ($dbpre->rowCount() < 1) {
	    echo w66;
	}
    while ($row = $dbpre->fetch(PDO::FETCH_ASSOC)) {
?>
<a href="cats.php?id2=<?php echo nocss($row['id']); ?>"><img title="<?php echo w52; ?>" src="../../design/pics/icons/standard/close2r.png" alt="" /></a>
<b><?php echo nocss($row['name']); ?></b><br>
<?php echo nocss($row['beschreibung']); ?>
<br>
<?php
	}
?>
</p>
<?php
    if (is_numeric($_GET['id2'])) {
?>
<div class="title"><b><?php echo w67; ?>:</b></div>
<p>
<?php	

    $catid2 = presql($_GET['id2']);
     
    $query = "DELETE
                          FROM
				 ".$PREFIX."_kat2
			  WHERE
				 id = '" . presql($catid2) . "'";
    
	$dbpre = $dbc->prepare($query);
	$dbpre->execute();
    if($dbpre) {
    echo w68;
	}
	else{
    echo w69;
    }
?>
</p>
<?php
}
?>
</div><div style="float:right;">
<div class="title"><b><?php echo w70; ?>:</b></div>
<p>
<form action="cats.php" method="post" name="cat">
<table>
	  <tr><td><?php echo w71; ?>: </td><td><input name="kat1_id" class="li" type="text" size="5" /></td></tr>
	  <tr><td><?php echo w4; ?>: </td><td><input name="cat2name" class="li" type="text" size="40" /> </td></tr>
      <tr><td><?php echo w72; ?>: </td><td>
      <textarea id="nachricht" class="li" name="beschreibung" cols="40" rows="10"></textarea></td></tr>
	  </table>
<input name="submit2" class="lb" type="submit" value="<?php echo w70; ?>" />
</form>
</p>
</div>
</div>
</article>
<?php
include 'inc/footer.php';
ob_end_flush();
?>
