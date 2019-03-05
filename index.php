<?php
 // inputs
$input = ["Mark" => "S", "Adam" => "S", "Adam1" => "S", 'AA' => 'S', "DD" => "P", "EE" => "P"];

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
        echo '*****';
        print_r($results);
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

function recursiveSearch($values, $beatChoises)
{

    $previousName = "";
    $previousValue = "";
    $cloneValues = [];

    $index = 0;

    foreach ($values as $name => $val) {
        if ($previousValue != "") {
            if ($previousValue === $val) {
                $cloneValues = $cloneValues + [$previousName => $previousValue]; //$previous["name"] => $previous["value"]] ;
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
        print_r($cloneValues);
    }
    echo count($cloneValues);
    if (count($cloneValues) === 1) {
        return $cloneValues;
    } else {
        recursiveSearch($cloneValues, $beatChoises);
    }
}

echo getRPSWinner($input);
