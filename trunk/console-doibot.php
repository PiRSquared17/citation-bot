<?
// $Id: $
error_reporting(E_ALL^E_NOTICE);
$slowMode=false;
$fastMode=false;
$editInitiator = '[Pu35a]';
$accountSuffix='_1';

$ON = true;
$ON = false;
include("expandFns.php");

function nextPage(){
	#return 'User:DOI bot/Zandbox';
	die ("\n**EXIT: nextPage is disabled!\n");
  //return 'Template:Cite doi/10.1001.2Farchinternmed.2009.6';
	global $db;
	$result = mysql_query ("SELECT page FROM citation ORDER BY fast ASC") or die(mysql_error());
	if(rand(1, 5000) == 100000)	{
		print "** Updating backlog...\nSeeing what links to 'Cite Journal'...";
		$cite_journal = whatTranscludes2("Cite_journal", 0);
		print "\nand 'Citation'... ";
		$citation =  whatTranscludes2("Citation", 0);
		$pages = array_merge($cite_journal["title"], $citation["title"]);
		$ids = array_merge($cite_journal["id"], $citation["id"]);
		print "and writing to file...";
		$count = count($pages);
		for ($i=0; $i<$count; $i++){
			$result = mysql_query("SELECT page FROM citation WHERE id = {$ids[$i]}") or die (mysql_error());
			if (!mysql_fetch_row($result)) {
				mysql_query("INSERT INTO citation (id, page) VALUES ('{$ids[$i]}', '". addslashes($pages[$i]) ."')" )or die(mysql_error());
				print "<br>{$pages[$i]} @ {$ids[$i]}";
			} else print ".";
		}
		print "\ndone.";
	}
	$result = mysql_query("SELECT page FROM citation ORDER BY fast ASC") or die (mysql_error());
	// Increment i< for # erroneous pages here.
	for ($i=0; $i<7; $i++) $chaff = mysql_fetch_row($result);
	$result = mysql_fetch_row($result);
	return $result[0];
}

#$page = nextPage();
#$page = "F�lix d'Herelle";
$page = "User:DOI bot/Zandbox";
include("expand.php");