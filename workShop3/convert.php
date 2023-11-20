<?php
    function convertToXML($input_file) {
        // Input CSV file
// Output XML file
        $outputFilename = 'output.xml';

        // Open CSV file for reading
        $input_file = fopen($input_file, 'r');

        if ($input_file !== false) {
            // Read the headers (first row) to use as XML element names
            $headers = fgetcsv($input_file, 1000, '|');

            // Create a new XML document
            $doc = new DOMDocument();
            $doc->formatOutput = true;

            // Create a root element for the XML
            $root = $doc->createElement('data');
            $root = $doc->appendChild($root);

            // Loop through each row in the CSV
            $recordId = 1;
            while (($row = fgetcsv($input_file, 1000, '|')) !== false) {
                $rowElement = $doc->createElement('record');
                $rowElement->setAttribute('id', $recordId);
                $rowElement->setAttribute('category', $row[count($row) - 1]);
                foreach ($headers as $index => $header) {
                    $field = $doc->createElement($header);
                    $field->appendChild($doc->createTextNode($row[$index]));
                    $rowElement->appendChild($field);
                }

                $root->appendChild($rowElement);
                $recordId++;
            }

            // Save the XML to the output file
            $doc->save($outputFilename);

            // Close the CSV file
            fclose($input_file);

            echo "Conversion completed. Output file: $outputFilename";
        } else {
            echo "Failed to open the input CSV file.";
        }
    }

    convertToXML('D:\fullStackEnvironment\laragon\www\Web-Development-Course-WorkShop\workShop3\quotes.csv');
?>