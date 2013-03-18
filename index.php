<?php
	header("Content-Type: text/turtle; charset=utf-8");
	echo "@prefix hxl:  <http://hxl.humanitarianresponse.info/ns/#> .\n \n";

	$fts_orgs_list = 'http://fts.unocha.org/api/v1/organization.xml';

	$xml = simplexml_load_file($fts_orgs_list);	 	

	foreach ($xml as $org):
		echo '
<http://hxl.humanitarianresponse.info/data/organisations/'.squeeze($org->name).'> a hxl:Organisation ;
          hxl:ftsID '.$org->id.' ;
          hxl:orgName "'.esc($org->name).'" ;
          hxl:abbreviation "'.esc($org->abbreviation).'" ;
          hxl:description "FTS Category: '.esc($org->type).'" .
';
    endforeach;    

//removes blanks and makes $name all lower case
function squeeze($name){

	// character replacement table
	$table = array(
        ' '=>'-', 'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj', 'Ž'=>'Z', 'ž'=>'z', 'C'=>'C', 'c'=>'c', 'C'=>'C', 'c'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'R'=>'R', 'r'=>'r', "'"=>'', '"'=>''
    );

	$name = strtolower($name); //lower case
	$name = preg_replace('/\s+/', '', $name); // all kinds of blanks
	$name = strtr($name, $table); // accents and umlauts
	return $name;
}

// escapes quotes for turtle output
function esc($string){
	return str_replace('"', '\"', $string);
}


?>