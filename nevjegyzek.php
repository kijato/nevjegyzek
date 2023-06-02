<?php

/*
Az alábbi hibaüzenetek esetén, a php.ini-ben a következő(ke)t kell beállítani:
	# Warning: file_get_contents(): Unable to find the wrapper "https" - did you forget to enable it when you configured PHP? in ...
		-> extension=openssl
	# Warning: file_get_contents(https://www.fomi.hu/portal/foldmerok/irm_lekerdezese_iframe.php): Failed to open stream: No such file or directory in ...
	# Warning: file_get_contents(https://www.fomi.hu/portal/foldmerok/foldm_ig_lekerdezese_iframe.php): Failed to open stream: No such file or directory in ...
		-> allow_url_fopen = On
*/

if ( isset($_GET["tipus"]) )    { $tipus =    htmlspecialchars( $_GET['tipus'] );    } else { $tipus=''; }
if ( isset($_GET["nev"]) )      { $nev =      htmlspecialchars( $_GET['nev'] );      } else { $nev=''; }
if ( isset($_GET["megye"]) )    { $megye =    htmlspecialchars( $_GET['megye'] );    } else { $megye='Mindenhol'; }
if ( isset($_GET["formatum"]) ) { $formatum = htmlspecialchars( $_GET['formatum'] ); } else { $formatum='raw'; }

switch ($tipus) {
    case 'irm':
		$url = 'https://www.fomi.hu/portal/foldmerok/irm_lekerdezese_iframe.php';
        break;
    case 'fmig':
		$url = 'https://www.fomi.hu/portal/foldmerok/foldm_ig_lekerdezese_iframe.php';
        break;
}

$data = array( 'nev' => $nev, 'megye' => $megye );
$options = array(
        'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    )
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$result = strtr($result,
					array (
						'/portal/images/kepek/sablonhoz/kukac_ltk.gif'=>'https://www.fomi.hu/portal/images/kepek/sablonhoz/kukac_ltk.gif',
						'Újabb keresés'=>'',
						'https://lechnerkozpont.hu/themes/bootstrap_barrio/subtheme/css/colors.css?qdti4c'=>''
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

#  Fatal error: Uncaught Error: Call to undefined function curl_init() in D:\srv\httpd-2.4.54-win64-VS16\htdocs\nevjegyzek.php:30 Stack trace: #0 {main} thrown in D:\srv\httpd-2.4.54-win64-VS16\htdocs\nevjegyzek.php on line 30

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
