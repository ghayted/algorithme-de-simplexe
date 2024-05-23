<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css"> <!-- Assurez-vous que le chemin du fichier CSS est correct -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body class="bg-slate-900">
<?php
// Déclarations des fonctions
function findPivotColumn($tableau) {
    $secondRow = $tableau[1];
    $minValue = min(array_slice($secondRow, 1));
    return array_search($minValue, $secondRow);
}

function findPivotRow($tableau, $pivotColumn) {
    $ratios = array();
    for ($rowIndex = 2; $rowIndex < count($tableau); $rowIndex++) {
        $row = $tableau[$rowIndex];
        if ($row[$pivotColumn] > 0) {
            $ratios[$rowIndex] = $row[count($row) - 1] / $row[$pivotColumn];
        }
    }
    return array_search(min($ratios), $ratios);
}

function findpivot($tableau, $pivotRow, $pivotColumn) {
    return $tableau[$pivotRow][$pivotColumn];
}

function pivot($tableau, $pivotRow, $pivotColumn, $pivotValue) {
    // Divide pivot row by pivot value
    foreach ($tableau[$pivotRow] as &$value) {
        $value /= $pivotValue;
    }
    unset($value);

    // Perform row operations to make pivot column zeros
    for ($rowIndex = 1; $rowIndex < count($tableau); $rowIndex++) {
        $row = $tableau[$rowIndex];
        if ($rowIndex !== $pivotRow) {
            $multiplier = $row[$pivotColumn];
            for ($i = 0; $i < count($row); $i++) {
                $row[$i] -= $multiplier * $tableau[$pivotRow][$i];
            }
            $tableau[$rowIndex] = $row;
        }
    }

    return $tableau;
}

// Traitement du formulaire si soumis
if (isset($_POST['submit1'])) {
    $numVariables = intval($_POST['num-variables']);
    $numConstraints = intval($_POST['num-constraints']);
    $coefficients = array();
    $operators = array();
    
    $numbreLigne = $numConstraints + 2;
    $numbreColumn = $numVariables + $numConstraints + 2;
    $table = array_fill(0, $numbreLigne, array_fill(0, $numbreColumn, 0));
    
    // Affichage de la première ligne du tableau (Z)
    $table[0][0] = "Z";
    for ($j = 1; $j <= $numVariables; $j++) {
        $table[0][$j] = "x".$j ;
    }
    
    // Ajout des entêtes pour les contraintes (e_i)
    for ($i = 1; $i <= $numConstraints; $i++) {
        $table[0][$i + $numVariables] = "e".$i;
    }
    $table[0][$numbreColumn-1] = "=";
    
    // Extraction des coefficients de la fonction objectif
    $table[1][0] = 1;
    for ($i = 1; $i <= $numVariables; $i++) {
        $coefficient1 = intval($_POST['objective_coefficient_' . $i]);
        if ($coefficient1 < 0) {
            $coefficient1 = abs($coefficient1); // Convertir en positif
            $table[1][$i] =  $coefficient1; // Afficher avec le signe négatif
        } else {
            $table[1][$i] = "-" . $coefficient1; // Afficher avec le signe positif
        }
    }
    
    // Initialisation des coefficients des contraintes à zéro
    for ($i = 1; $i <= $numConstraints; $i++) {
        $table[1][$numVariables + $i] = 0;
    }
    
    // Affichage des lignes pour les contraintes
    for ($i = 2; $i < $numbreLigne; $i++) {
        $table[$i][0] = 0;
        // Ajout des coefficients des variables pour la contrainte actuelle
        for ($j = 1; $j <= $numVariables; $j++) {
            $xVAL = intval($_POST['constraint_coefficient_' . ($i - 1) . '_' . $j]);
            $table[$i][$j] = $xVAL;
        }
        // Ajout des 0 et 1 pour les autres contraintes
        for ($k = 2; $k < $numbreLigne; $k++) {
            if ($k == $i) {
                $table[$i][$k + $numVariables - 1] = 1;
            } else {
                $table[$i][$k + $numVariables] = 0;
            }
        }
        $contVal = intval($_POST['constraint_value_'. ($i - 1)]);
        $table[$i][$numbreColumn - 1] = $contVal;
    }
    
    // Affichage du tableau initial
    echo "<h2>Initial Table</h2>";
    echo "<div class='relative overflow-x-auto'>";
    echo "<table class='w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400'>";
    // Affichage de l'en-tête du tableau
    echo "<thead class='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400'>";
    echo "<tr>";
    for ($j = 0; $j < $numbreColumn; $j++) {
        echo "<th scope='col' class='px-6 py-3'>{$table[0][$j]}</th>";
    }
    echo "</tr>";
    echo "</thead>";
    // Affichage du corps du tableau
    echo "<tbody>";
    for ($i = 1; $i < $numbreLigne; $i++) {
        echo "<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700'>";
        for ($j = 0; $j < $numbreColumn; $j++) {
            echo "<td class='px-6 py-4'>{$table[$i][$j]}</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    // Initialisation des variables pivotRow et pivotColumn
    $pivotRow = 0; // Vous devez initialiser cette variable
    $pivotColumn = 0; // Vous devez initialiser cette variable

    // Boucle de résolution
    echo "<h2>Resolution Process</h2>";
    while (min(array_slice($table[1], 1)) < 0) {
        // Trouver la colonne pivot
        $pivotColumn = findPivotColumn($table);
        // Trouver la ligne pivot
        $pivotRow = findPivotRow($table, $pivotColumn);
        // Trouver la valeur pivot
        $pivotValue = findpivot($table, $pivotRow, $pivotColumn);
        // Effectuer l'opération pivot
        $table = pivot($table, $pivotRow, $pivotColumn, $pivotValue);

        // Affichage du tableau mis à jour avec la couleur verte pour la ligne pivot
        echo "<div class='relative overflow-x-auto'>";
        echo "<table class='w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400'>";
        // Affichage de l'en-tête du tableau mis à jour
        echo "<thead class='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400'>";
        echo "<tr>";
        for ($j = 0; $j < $numbreColumn; $j++) {
            // Determine if it's the pivot row
            $isPivotRow = ($j == $pivotRow);
            // Determine if it's the pivot column
            $isPivotColumn = ($j == $pivotColumn);
            $cellClass = $isPivotRow ? 'bg-white-500' : '';
            echo "<th scope='col' class='px-6 py-3 {$cellClass}'>{$table[0][$j]}</th>";
        }
        echo "</tr>";
        echo "</thead>";
        // Affichage du corps du tableau mis à jour
        echo "<tbody>";
        for ($i = 0; $i < $numbreLigne; $i++) {
            // Determine if it's the pivot row
            $isPivotRow = ($i == $pivotRow);
            $rowClass = $isPivotRow ? 'bg-green-500' : 'bg-white-100';
            echo "<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700 {$rowClass}'>";
            for ($j = 0; $j < $numbreColumn; $j++) {
                // Determine if it's the pivot column
                $isPivotColumn = ($j == $pivotColumn);
                $cellClass = $isPivotColumn ? 'pivot-column' : '';
                echo "<td class='px-6 py-4 {$cellClass}'>{$table[$i][$j]}</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
}
?>
<style>
    h2{
        font-family: Arial, Helvetica, sans-serif,bold;
        color: #ffffff; /* Changement de couleur de texte en blanc */
        background-color: #4299e1; /* Changement de couleur de fond en bleu */
        padding: 10px; /* Ajout de remplissage */
        border-radius: 5px; /* Ajout de bord arrondi */
    }
    body{
        background-color: blue; /* Changement de couleur de fond de page en bleu */
    }
</style>
</body>
</html>
