<?php
require_once('Dabbler.php');

$dataUrl = 'http://austinphp.dabbledb.com/publish/austinphp/1cd36039-6a43-456d-86ca-1ad832b29f58/allentries.jsonp';

$d = new Dabbler($dataUrl);

$entries = $d->getEntries();
print_r($entries);

echo "\n\n";

$findByFirstName = $d->getEntry('Joshua', 'First Name');

print_r($findByFirstName);