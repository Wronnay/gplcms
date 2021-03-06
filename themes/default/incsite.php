<?php
/*
CMS by Christoph Miksche
Website: http://cms.wronnay.net
License: GNU General Public License
*/
$sql = "SELECT
            id,
            autor_id,
            title,
            text,
            date,
            description,
            tags,
            pic
        FROM
            ".$PREFIX."_sites
        WHERE
            lang = '".$lang."'
        AND
            id = '".$type_id."'
        ORDER BY
            id
		";
$dbpre = $dbc->prepare($sql);
$dbpre->execute();
if ($dbpre->rowCount() < 1) {
header("Location: index.php?site=error");
}
while ($row = $dbpre->fetch(PDO::FETCH_ASSOC)) {
$title = ''.nocss($row['title']).' - '.$site_title.'';
$description = nocss($row['description']);
$keywords = nocss($row['tags']);
$codebody = '<article>'.nocss2($row['text']).'</article>';
}
?>
