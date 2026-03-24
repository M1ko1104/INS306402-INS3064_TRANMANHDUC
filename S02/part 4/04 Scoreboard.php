<?php
$scores = [70, 85, 90, 60, 75];

$sum = 0;
foreach ($scores as $score) {
    $sum += $score;
}

$avg = $sum / count($scores);
$max = max($scores);
$min = min($scores);

// Filter scores > average
$topScores = [];
foreach ($scores as $score) {
    if ($score > $avg) {
        $topScores[] = $score;
    }
}

echo "Average: " . round($avg, 2) . "<br>";
echo "Max: $max<br>";
echo "Min: $min<br>";
echo "Top (above avg): ";
print_r($topScores);
?>