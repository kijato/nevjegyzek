<?php

/*
Az alábbi hibaüzenetek esetén, a php.ini-ben a következő(ke)t kell beállítani:
	# Warning: file_get_contents(): Unable to find the wrapper "https" - did you forget to enable it when you configured PHP? in ...
		-> extension=openssl
	# Warning: file_get_contents(https://www.fomi.hu/portal/foldmerok/irm_lekerdezese_iframe.php): Failed to open stream: No such file or directory in ...
	# Warning: file_get_contents(https://www.fomi.hu/portal/foldmerok/foldm_ig_lekerdezese_iframe.php): Failed to open stream: No such file or directory in ...
		-> allow_url_fopen = On
*/

if ( isset($_GET["nev"]) ) { $nev = htmlspecialchars( $_GET['nev'] ); } else { $nev='kis'; }
if ( isset($_GET["page"]) ) { $page = htmlspecialchars( $_GET['page'] ); } else { $page='0'; }
if ( isset($_GET["size"]) ) { $size = htmlspecialchars( $_GET['size'] ); } else { $size='100'; }

$url="https://geoszaki-portal.eing.foldhivatal.hu/api/public/geoszaki-portal-szakerto-service-v1/filter";

$data = array( 'page' => $page, 'size' => $size,  'viseltNev' => $nev );

$options = array(
        'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        #'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    )
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
#echo json_encode($result, true);
#var_dump( json_decode($result, true) );


$array = json_decode($result, true);
print "<style>
table { margin-left:auto; margin-right:auto; border-collapse:collapse;  background-color:whitesmoke; font-family: verdana,tahoma,sans-serif; font-size: small; }
table, caption, th, td { border:1px solid gray; padding: 3px; }
th { background-color:cornsilk; align: left }
</style>";
print("<table>\n");
#print("<caption>https://geoszaki-portal.eing.foldhivatal.hu/szakertok/</caption>\n");
print("<tr>
<th>&nbsp</th>
<th>Név</th>
<th>Elérhetőségek</th>
<th>Hivatali földmérő</th>
<th>Státusz</th>
<th>Jogosultsági adatok</th>
</tr>\n");
$sorszam=0;
foreach($array["content"] as $content) {
	#foreach($content as $key => $value) {
		print("<tr id=".$content['id'].">");
		/*print("<td>{$content['viseltNev']}</td>");*/
		/*print("<td>$key : $value</td>");*/
		print( "<td>".++$sorszam."</td>" );
		print( isset($content['viseltNev']) ? "<td>".         $content['viseltNev']."</td>"         : "<td>-</td>" );
		print( isset($content['allandoTelepules']) ? "<td>".  $content['allandoTelepules'].", "     : "-, " );
		print( isset($content['allandoLakcim']) ?             $content['allandoLakcim']."<br>"      : "-<br>" );
		print( isset($content['email']) ?                     $content['email']."<br>"              : "-<br>" );
		print( isset($content['telefonszam']) ?               $content['telefonszam']               : "-" );
		print( isset($content['hivataliFoldmero']) ? "<td>".( $content['hivataliFoldmero'] ? "igen" : "nem" )."</td>" : "<td>?</td>" );
		print( isset($content['statusz']) ? "<td>".           $content['statusz']."</td>"           : "<td>-</td>" );
		if ( isset($content['szakertoJogosultsagList']) && is_array($content['szakertoJogosultsagList']) ) {
			print "<td>";
			$i = 0;
			//print( sizeof(array($content["szakertoJogosultsagList"])[0])."<br>" );
			foreach($content["szakertoJogosultsagList"] as $jogosultsag) {
				print( "Jogosultság: " . ( isset($jogosultsag['jogosultsag']['nev']) ? $jogosultsag['jogosultsag']['nev']         : "-," ) . "<br>" );
				print( "Azonosító: " .   ( isset($jogosultsag['azonositoszam'])      ? $jogosultsag['azonositoszam']              : "-" ) . "<br>" );
				print( "Érvényes: " .    ( isset($jogosultsag['ervenyessegKezdete']) ? $jogosultsag['ervenyessegKezdete']."-tól " : "? " ) .
				                         ( isset($jogosultsag['ervenyessegVege'])    ? $jogosultsag['ervenyessegVege']."-ig"      : "visszavonásig" ) );
				if ( ++$i < sizeof(array($content["szakertoJogosultsagList"])[0]) ) {
					print "<hr>";
				}
			}
			print "</td>";
		}
		
		print("</tr>\n");
	#}
}
print("</table>\n");


exit;


$result = strtr($result,
					array (
						//'/portal/images/kepek/sablonhoz/kukac_ltk.gif'=>'https://www.fomi.hu/portal/images/kepek/sablonhoz/kukac_ltk.gif',
						//'<img style="margin: 0px; vertical-align: bottom;" src="/portal/images/kepek/sablonhoz/kukac_ltk.gif">'=>'@',
						'Újabb keresés'=>'',
						'https://lechnerkozpont.hu/themes/bootstrap_barrio/subtheme/css/colors.css?qdti4c'=>'',
					)
				);

switch ($formatum) {
    case 'csv':
		/*
		https://stackoverflow.com/questions/7429136/get-a-complete-table-with-php-domdocument-and-print-it
		*/
		$xml = new DOMDocument();
		$xml->validateOnParse = true;
		$xml->loadHTML($result);

		$xpath = new DOMXPath($xml);
		$table =$xpath->query("//table")->item(0);

		// for printing the whole html table just type: print $xml->saveXML($table); 

		$rows = $table->getElementsByTagName("tr");

		$csv='';
		foreach ($rows as $row) {
			$cells = $row -> getElementsByTagName('td');
			foreach ($cells as $cell) {
				//print $cell->nodeValue.';'; // print cells' content as 124578
				$csv .= $cell->nodeValue.';';
			}
			$csv .= "<br>\n";
		}
		print $csv;
		break;
    case 'table':
		/*
		https://stackoverflow.com/questions/7429136/get-a-complete-table-with-php-domdocument-and-print-it
		*/
		$xml = new DOMDocument();
		$xml->validateOnParse = true;
		$xml->loadHTML($result);

		$xpath = new DOMXPath($xml);
		$table =$xpath->query("//table")->item(0);

		// for printing the whole html table just type: print $xml->saveXML($table); 

		$rows = $table->getElementsByTagName("tr");

		$i=0;
		$csv='<table>';
		foreach ($rows as $row) {
			$csv.='<tr>';
			$i++;
			$cells = $row -> getElementsByTagName('td');
			foreach ($cells as $cell) {
				//print $cell->nodeValue.';'; // print cells' content as 124578
				$csv .= $i==1 ? '<th>'.$cell->nodeValue.'</th>' : '<td>'.$cell->nodeValue.'</td>';
			}
			$csv .= '</tr>';
		}
		print $csv .= '</tabla>';
		break;
    case 'var_dump':
		var_dump($result);
        break;
	case 'raw':
		print($result);	
		break;
	default:
		print($result);	
		break;
}



/*

#  Fatal error: Uncaught Error: Call to undefined function curl_init() in ..\nevjegyzek.php:30 Stack trace: #0 {main} thrown in D:\srv\httpd-2.4.54-win64-VS16\htdocs\nevjegyzek.php on line 30

$url = 'https://www.fomi.hu/portal/foldmerok/irm_lekerdezese_iframe.php';
$myvars = 'nev='.$nev.'&'.'megye='.$megye;
$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
*/

?>
