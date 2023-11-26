<?php
$doc = new DOMDocument();

$HTML = $doc->createElement('HTML');
$doc->append($HTML);

$HEAD = $doc->createElement('HEAD');
$doc->append($HEAD);

$TITLE = $doc->createElement('TITLE', 'quotes_xml_to_html');
$HEAD->append($TITLE);

$style = $doc->createElement('style', '
    .headings {
        background: grey;
    }

    .data {
        background: whitesmoke;
    }
');
$style->setAttribute('type', 'text/css');
$HEAD->appendChild($style);

$BODY = $doc->createElement('BODY');
$doc->append($BODY);

$H1 = $doc->createElement('H1', 'Quotes from CSV data');
$BODY->append($H1);

$TABLE = $doc->createElement('TABLE');
$BODY->append($TABLE);

$thead = $doc->createElement('thead');
$TABLE->append($thead);

$xml = simplexml_load_file('D:\fullStackEnvironment\laragon\www\Web-Development-Course-WorkShop\quotes.xml');
$headings = ['quote', 'source', 'dob-dod', 'wplink', 'wpimg', 'category'];
$records = $xml->record;

for ($i = 0; $i < count($headings); $i++) {
    $td = $doc->createElement('td', $headings[$i]);
    $td->setAttribute('class', 'headings');
    $thead->append($td);
}

foreach ($records as $record) {
    $tr = $doc->createElement('tr');
    $TABLE->append($tr);
    foreach ($headings as $heading) {
        if ($heading == 'wplink') {
            $td = $doc->createElement('td');
            $A = $doc->createElement('A', $record->$heading);
            $A->setAttribute('HREF', $record->$heading);
            $A->setAttribute('TARGET', '_blank');
            $td->append($A);
        } else if ($heading == 'wpimg') {
            $td = $doc->createElement('td');
            $img = $doc->createElement('img');
            $img->setAttribute('src', $record->$heading);
            $img->setAttribute('width', '120');
            $img->setAttribute('height', '150');
            $td->append($img);
        } else {
            $td = $doc->createElement('td', $record->$heading);
        }
        $td->setAttribute('class', 'data');
        $tr->append($td);
    }
}

echo $doc->saveHTML();
?>