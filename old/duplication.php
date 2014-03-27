<?php
$start_time = time();
include("db.php");
$db = new db();
$deleted = 0;
for ($j=0;$j<100;$j++){
	$words = $db->fetchAll("SELECT * FROM `words_en` WHERE checked=0 ORDER by id LIMIT 5000;");
	foreach ($words as $w){
		$check_dupl = $db->fetchAll("SELECT * FROM `words_en` WHERE word='".$w['word']."';");
		if(count($check_dupl) > 1){
			$i = 0;
			foreach ($check_dupl as $c){
				if ($i!=0){
					$db->query("DELETE FROM `words_en` WHERE id='".$c['id']."';");
					$deleted++;
				}
				$i++;
			}
		}
		$db->query("UPDATE `words_en` SET checked=1 WHERE id=".$w['id']);
		
	}
}
$time = time()-$start_time;
echo $time. " " .$deleted;