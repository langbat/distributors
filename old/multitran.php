<?php
$start_time = time();
function transcription($row){
			$transcriptionDom = new DOMDocument();
			$transcriptionDom->loadHTML($row);
			$transcription = $transcriptionDom->getElementsByTagName("img");
			$transcription_count = $transcription->length;
			$t = "";
			for ($k=0;$k<$transcription_count;$k++){
				$tmp_transcription = new DOMDocument();
				$tmp_transcription->appendChild($tmp_transcription->importNode($transcription->item($k), true));
				$trans = trim($tmp_transcription->saveHTML());
			
				$start = strpos($trans, 'scr="/gif/')+15; 
				$end = strpos($trans, '.gif');
				$diff = $end-$start;

				// Корневое слово
				$trans = substr($trans, $start, $diff);
				switch ($trans){
					default:
						$letter = "";
						break;
					case "%5B":
						$letter = "[";
						break;
					case "%5D":
						$letter = "]";
						break;
					case "34":
						$letter = "&#716;";
						break;
					case "39":
						$letter = "&#712;";
						break;
					case "40":
						$letter = "(";
						break;
					case "41":
						$letter = ")";
						break;
					case "58":
						$letter = "&#720;";
						break;
					case "65":
						$letter = "&#652;";
						break;
					case "68":
						$letter = "&#240;";
						break;
					case "69":
						$letter = "&#604;";
						break;
					case "73":
						$letter = "&#618;";
						break;
					case "78":
						$letter = "&#331;";
						break;
					case "79":
						$letter = "&#596;";
						break;
					case "80":
						$letter = "&#594;";
						break;
					case "81":
						$letter = "&#593;";
						break;
					case "83":
						$letter = "&#643;";
						break;
					case "84":
						$letter = "&#952;";
						break;
					case "86":
						$letter = "&#650;";
						break;
					case "90":
						$letter = "&#658;";
						break;
					case "97":
						$letter = "a";
						break;
					case "98":
						$letter = "b";
						break;
					case "100":
						$letter = "d";
						break;
					case "101":
						$letter = "e";
						break;
					case "102":
						$letter = "f";
						break;
					case "103":
						$letter = "g";
						break;
					case "104":
						$letter = "h";
						break;
					case "105":
						$letter = "i";
						break;
					case "106":
						$letter = "j";
						break;
					case "107":
						$letter = "k";
						break;
					case "108":
						$letter = "l";
						break;
					case "109":
						$letter = "m";
						break;
					case "110":
						$letter = "n";
						break;
					case "112":
						$letter = "p";
						break;
					case "113":
						$letter = "&#601;";
						break;
					case "114":
						$letter = "r";
						break;
					case "115":
						$letter = "s";
						break;
					case "116":
						$letter = "t";
						break;
					case "117":
						$letter = "u";
						break;
					case "118":
						$letter = "v";
						break;
					case "119":
						$letter = "w";
						break;
					case "120":
						$letter = "&#230;";
						break;
					case "122":
						$letter = "z";
						break;
				}
				$t .= $letter;
			}

	return $t;
}
header("content-type=text/html; charset=utf-8");
include("db.php");
setlocale(LC_ALL, 'en_GB');
$db = new db();
$words = $db->fetchAll("SELECT * FROM `words_en` WHERE checked!=1 ORDER by id LIMIT 100;");
foreach ($words as $w){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://www.multitran.ru/c/m.exe");
	curl_setopt($ch, CURLOPT_HTTPHEADER,array('User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_3) AppleWebKit/536.29.13 (KHTML, like Gecko) Version/6.0.4 Safari/536.29.13 ','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8 '));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "CL=1&s=".$w['word']."&l1=1");
	curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$html = curl_exec($ch);
	curl_close($ch);

	// Загружаем всю страницу
	$newDom = new DOMDocument();
	$newDom->loadHTML($html);
	$newDom->preserveWhiteSpace = false;
	// Ищем таблицы
	$sections = $newDom->getElementsByTagName('table');
	$nodeNo = $sections->length;
	$tmp_dom = new DOMDocument();
	$tmp_dom->appendChild($tmp_dom->importNode($sections->item(10), true));
	// Берем страницу с переводами
	$innerHTML = trim($tmp_dom->saveHTML()); 
	$rowsDom = new DOMDocument();
	$rowsDom->loadHTML($innerHTML);
	// Разбираем таблицу на строки
	$rows = $rowsDom->getElementsByTagName('tr');
	$rows_no = $rows->length;

	$final_array = array();
	// Пробегаем по все строчкам
	$row_array = array();
	for ($i=0;$i<$rows_no;$i++){

		$tmp_row = new DOMDocument();
		$tmp_row->appendChild($tmp_row->importNode($rows->item($i), true));
		$row = trim($tmp_row->saveHTML()); 
		if (strpos($row,'#start') || $i==0){ 
			$start = strpos($row, '<a'); 
			$end = strpos($row, "</a>")+4;
			$diff = $end-$start;

			$href = mb_substr($row, $start, $diff, "UTF-8");
			$start = strpos($href, '">')+2; 
			$end = strpos($href, "</a>");
			$diff = $end-$start;

			// Корневое слово
			$word = mb_substr($href, $start, $diff, "UTF-8");

			if ((strpos($word,'<i>') == false) && (strpos($word,'<span>') == false)){
				$row_array['word'] = $w['word'];
			}else{
				$row_array['word'] = $word;
			}

			// Определяем тип
			$start = strpos($row, '<em>')+4; 
			$end = strpos($row, "</em>");
			$diff = $end-$start;
			$type = substr($row, $start, $diff);
			$row_array['type'] = $type;

			// Транскрипция
			$transcription = transcription($row);
			$row_array['transcription'] = $transcription;
		}else{
			$row_array['translations'] = array();
			$translationsDom = new DOMDocument();
			$translationsDom->loadHTML($row);
			$translations = $translationsDom->getElementsByTagName('a');
			$translations_count = $translations->length;
			for ($j=0;$j<$translations_count;$j++){
				$tmp_translation = new DOMDocument();
				$tmp_translation->appendChild($tmp_translation->importNode($translations->item($j), true));
				$translation = trim($tmp_translation->saveHTML());
				//echo $translation;
				if (!strpos($translation, "title")){
					if (strpos($translation, "<i>")){
						//echo count($row_array['translations']);
						unset($row_array['translations'][count($row_array['translations'])-1]);
					}else{
						$start = strpos($translation, '">')+2; 
						$end = strpos($translation, "</a>");
						$diff = $end-$start;

						// Корневое слово
						$translation = mb_substr($translation, $start, $diff, "UTF-8");
						$row_array['translations'][] = $translation;
					}
				}else{
					// Получаем полное название словаря
					$start = strpos($translation, 'title="')+7; 
					$end = stripos($translation, '" ');
					$diff = $end-$start;
					$row_array['vocabulary'] = mb_substr($translation, $start, $diff, "UTF-8");

					// Получаем короткое название словаря
					$start = strpos($translation, '<i>')+3; 
					$end = stripos($translation, '</i>'); 
					$diff = $end-$start;
					$row_array['vocabulary_short'] = mb_substr($translation, $start, $diff, "UTF-8");
				}

			}
		}
		if (!empty($row_array['translations'])){
			$final_array[] = $row_array;
		}
		
	}
	echo "<pre>";
	print_r($final_array);
	echo "</pre><br/>";
	if (!empty($final_array)){
		$updated = false;
		foreach ($final_array as $result){
			$result['word'] = html_entity_decode($result['word'], ENT_NOQUOTES, 'UTF-8');
			
			if ($w['word'] === $result['word']){
				if (!$updated){
					if ($result['transcription'] != ''){
						$trans = ", transcription='".$result['transcription']."'";
					}else{
						$trans = "";
					}
					$db->query("UPDATE `words_en` SET checked=1".$trans." WHERE id=".$w['id']);
					$updated = true;
				}
				$en_id = $w['id'];
			}else{
				$check_en = $db->fetchRow("SELECT * FROM `words_en` WHERE word='".$result['word']."';");
				if (count($check_en) == 0){
					$data = array(
						"word" => $result['word'],
						"checked" => 1
					);
					$en_id = $db->insert('words_en', $data);
				}else{
					$db->query("UPDATE `words_en` SET checked=1".$trans." WHERE id=".$check_en['id']);
					$en_id = $check_en['id'];
				}
			}

			// Проверяем и добавляем словарь
			$check_voc = $db->fetchRow("SELECT * FROM `vocabulary` WHERE title='".html_entity_decode($result['vocabulary'], ENT_NOQUOTES, 'UTF-8')."';");
			if (count($check_voc) == 0){
				$data = array(
					'title' => html_entity_decode($result['vocabulary'], ENT_NOQUOTES, 'UTF-8'),
					'short' => html_entity_decode($result['vocabulary_short'], ENT_NOQUOTES, 'UTF-8')
				);
				//echo mb_strlen($result['vocabulary'])."<br/>";
				$voc_id = $db->insert('vocabulary', $data);
			}else{
				$voc_id = $check_voc['id'];
			}


			foreach ($result['translations'] as $t){
				$t = html_entity_decode($t, ENT_NOQUOTES, 'UTF-8');

				if (strpos($t,'<i>') != false){
					$start = strpos($t, '<i>')+3; 
					$end = stripos($t, '</i>');
					$diff = $end-$start;
					$t = mb_substr($t, $start, $diff, "UTF-8");
				}
				if (($t != '') && (strpos($t,'<span>') == false)){
					// Проверяем - русское ли слово мы добавляем
					if(preg_match('#^[ -~£±§]*$#', $t)) {
						// Слово английское - добавляем в словарь английского
					    $data = array(
							"word" => $t,
							"checked" => 0
						);
						$db->insert('words_en', $data);
					}else{
						// Добавляем русское слово, если его нет
						$check_ru = $db->fetchAll("SELECT * FROM `words_ru` WHERE word='".$t."'");
						if (count($check_ru) == 0){
							$data = array(
								"word" => $t,
							);
							$ru_id = $db->insert('words_ru', $data);
						}else{
							$ru_id = $check_ru[0]['id'];
						}

						// Добавляем перевод
						$data = array(
							"word_ru_id" => $ru_id,
							"word_en_id" => $en_id,
							"type" => html_entity_decode($result['type'], ENT_NOQUOTES, 'UTF-8'),
							"voc_id" => $voc_id
						);
						$db->insert('translation_en_ru', $data);
					}
				}
			}
		}
	}else{
		$db->query("UPDATE `words_en` SET checked=1 WHERE id=".$w['id']);
	}
}
$time = time()-$start_time;
echo $time;