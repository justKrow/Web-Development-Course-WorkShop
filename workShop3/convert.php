<?php
// Input CSV file

// Output XML file
$outputFilename = 'output.xml';

// Open CSV file for reading
$inputFile = fopen('D:\fullStackEnvironment\laragon\www\Web-Development-Course-WorkShop\workShop3\quotes.csv', 'r');

if ($inputFile !== false) {
    // Read the headers (first row) to use as XML element names
    $headers = fgetcsv($inputFile, 1000, '|');
    
    // Create a new XML document
    $doc = new DOMDocument();
    $doc->formatOutput = true;

    // Create a root element for the XML
    $root = $doc->createElement('data');
    $root = $doc->appendChild($root);

    // Loop through each row in the CSV
    while (($row = fgetcsv($inputFile, 1000, '|')) !== false) {
        $rowElement = $doc->createElement('record');
        
        foreach ($headers as $index => $header) {
            $field = $doc->createElement($header);
            $field->appendChild($doc->createTextNode($row[$index]));
            $rowElement->appendChild($field);
        }
        
        $root->appendChild($rowElement);
    }

    // Save the XML to the output file
    $doc->save($outputFilename);

    // Close the CSV file
    fclose($inputFile);

    echo "Conversion completed. Output file: $outputFilename";
} else {
    echo "Failed to open the input CSV file.";
}
?>
