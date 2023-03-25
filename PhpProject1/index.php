<?php

/**
 * metodo che si occupa di trovare i file e i relativi path di appartenenza
 * @param string $dir   path della cartella in input di cui fare l'elaborazione
 * @return array [$files]   viene ritornato un array con una struttura: ["filename"] => [dir1,dir2,dir3...]  
 */
function fileScanner($dir) {
    $files = [];
    if (is_dir($dir)) {
        $scan = scandir($dir);
        foreach ($scan as $file) {
            if (!in_array($file, array(".", ".."))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                    //effettuo ricorsione per prendere informazioni all'interno della cartella in esame
                    $r = fileScanner($dir . DIRECTORY_SEPARATOR . $file);
                    if (count($r) > 0) {
                        //uso la funzione php array_merge_recursive per far si che se ci sono stesse chiavi associative
                        //non vado a sovrascrivere le informazioni me le collezione tutte
                        $files = array_merge_recursive($files, $r);
                    }
                } else {
                    //se trovo un file lo salvo come nome della chiave assoviativa e inserisco al suo interno la lista
                    //delle cartelle che lo contengono
                    $files[$file][] = $dir;
                }
            }
        }
    } else {
        //se viene passato in input un file, segnalo che path deve essere di una cartella
        echo 'The inserted path must be pointing to a directory.';
        exit();
    }

    return $files;
}

/**
 * metodo che si occupa dell'inserimento in file csv dei dati elaborati
 * @param array $files  contiene le informazioni necessarie per
 * @return bool   [true] se l'inserimento in file csv è riuscito | [false] se l'elaborazione fallisce
 */
function csvGenerator($files) {
    $csv = "Filename,Occurrences,Paths\n";
    $csvStartingLength = strlen($csv);

    //ciclo per creare stringa con i dati da inserire in file csv
    foreach ($files as $fileName => $dirPaths) {
        $count = count($dirPaths);
        if ($count > 1) {
            $paths = implode(";", $dirPaths);
            $csv .= "*  " . $fileName . ", " . $count . ", " . $paths . "\n";
        }
    }

    //controllo se la lunghezza della stringa $csv è cambiato o rimasta come all'inizio 
    //andro a creare il file .csv solo se la lunghezza sarà cambiata
    if (strlen($csv) == $csvStartingLength) {
        echo 'The elaboration didn\'t find duplicates files. File .csv has not been created.';
        exit();
    } else {
        
        //insesisco nel file csv le informazioni trovate
        $r = file_put_contents('elaborationResults.csv', $csv);

        if ($r === false) {
            echo 'The creation of the .csv file with the processed data has failed.';
            return false;
        }
    }

    return true;
}

// richiesta tramite command line di inserire un path di ingresso da elaborare
$path = readline("Enter the directory to elaborate: ");
//$path = 'C:\MAMP\htdocs\cartellaTestTree';

if ($path === false || strlen($path) === 0) {
    echo 'The inserted path is not valid.';
} else {
// mostro a schermo il path entrato dallo user
    echo "You entered: $path" . "\n";
    $directory = $path;
    $files = fileScanner($directory);
    $csv = csvGenerator($files);

    if ($csv === true) {
        echo 'Elaboration succeed! Created file "elaborationResults.csv" with processed data.';
    }
}
?>
