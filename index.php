<?php
 // inputs
$input = [
    "Mark" => "P",
    "Adam" => "R",
    "Adam1" => "S",
    'AA' => 'S',
    "DD" => "S",
    "EE" => "P"
];

/**
 * Get Winner
 * @param $input array of players with their inputs
 */
function getRPSWinner($input)
{

    try {
        $beatChoises = [
            "R" => "S",
            "S" => "P",
            "P" => "R"
        ];

        // If 1 or less players, the tournament will be cancelled
        if (count($input) <= 1) {
            return  "Tournament Cancelled";
        }
        // get all values
        $allValues = array_map('strtoupper', array_values($input));

        if (!checkForInvalidInput($allValues)) {
            return  "Invalid Game";
        }

        $results = recursiveSearch($input, $beatChoises);
        $name = ($results) ? array_key_first($results) : "Error";
        return $name;
    } catch (Error $ex) {
        return $ex->getMessage();
    }
}

/**
 * Check for invalid inputs
 */
function checkForInvalidInput($allValues)
{
    $gameValues = ['R', 'P', 'S'];
    $uniqueValues = array_unique($allValues);
    if (count($uniqueValues) > 3) {
        return false;
    }
    foreach ($uniqueValues as $uniqueValue) {

        if (!in_array($uniqueValue, $gameValues)) {
            return false;
        }
    }
    return true;
}
/**
 * Search final winner
 * @param $values inputs array
 * @param $beatChoises Options which can beat as key
 */
function recursiveSearch($values, $beatChoises)
{

    $previousName = "";
    $previousValue = "";
    $cloneValues = [];

    $index = 0;
    do {
        $cloneValues = [];
        foreach ($values as $name => $val) {
            if ($previousValue != "") {
                if ($previousValue === $val) {
                    $cloneValues = $cloneValues + [$previousName => $previousValue];
                } elseif ($beatChoises[$previousValue] === $val) {
                    $cloneValues = $cloneValues + [$previousName => $previousValue];
                } elseif ($beatChoises[$val] === $previousValue) {
                    $cloneValues = $cloneValues + [$name => $val];
                }
                $previousName = "";
                $previousValue = "";
            } else {
                $previousName =  $name;
                $previousValue = $val;
            }
        }
        $values = $cloneValues;
    } while (count($cloneValues) !== 1);
    return $cloneValues;
}

echo getRPSWinner($input);
