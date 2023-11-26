<?php
// Create a new DOMDocument
$dom = new DOMDocument();
$dom->loadHTML('<!DOCTYPE html>');
$dom->encoding = 'utf-8';
$dom->preserveWhiteSpace = false;

// Create the head section
$head = $dom->createElement('head');
$dom->appendChild($head);

// Add meta tags
$metaCharset = $dom->createElement('meta');
$metaCharset->setAttribute('charset', 'UTF-8');
$head->appendChild($metaCharset);

$metaViewport = $dom->createElement('meta');
$metaViewport->setAttribute('name', 'viewport');
$metaViewport->setAttribute('content', 'width=device-width, initial-scale=1.0');
$head->appendChild($metaViewport);

// Create the title element
$title = $dom->createElement('title', 'Document');
$head->appendChild($title);

// Create and link the stylesheet
$link = $dom->createElement('link');
$link->setAttribute('href', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
$link->setAttribute('rel', 'stylesheet');
$link->setAttribute('integrity', 'sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC');
$link->setAttribute('crossorigin', 'anonymous');
$head->appendChild($link);

// Create the body
$body = $dom->createElement('body');
$dom->appendChild($body);

// Open and read the CSV file
$CSVfp = fopen("quotes.csv", "r");
if ($CSVfp !== FALSE) {
    fgetcsv($CSVfp, 1000, "|");

    // Create a container div
    $container = $dom->createElement('div');
    $container->setAttribute('class', 'phppot-container');
    $body->appendChild($container);

    // Create the table
    $table = $dom->createElement('table');
    $table->setAttribute('class', 'table table-success table-striped-columns');
    $container->appendChild($table);

    // Create the table header
    $thead = $dom->createElement('thead');
    $table->appendChild($thead);
    $headerRow = $dom->createElement('tr');
    $thead->appendChild($headerRow);

    $headerColumns = ['quote', 'source', 'dob-dod', 'wplink', 'wpimg', 'category'];

    foreach ($headerColumns as $column) {
        $headerCell = $dom->createElement('th', $column);
        $headerRow->appendChild($headerCell);
    }

    while (!feof($CSVfp)) {
        $data = fgetcsv($CSVfp, 1000, "|");
        if (!empty($data)) {
            $row = $dom->createElement('tr');
            $table->appendChild($row);

            foreach ($data as $cellData) {
                $cell = $dom->createElement('td');
                $cell->nodeValue = $cellData;
                $row->appendChild($cell);
            }
        }
    }

    // Output the HTML
    echo $dom->saveHTML();
}
fclose($CSVfp);
?>
