<?php
function calculateBMI(float $kg, float $m): string {
    $bmi = $kg / ($m * $m);
    $bmiRounded = round($bmi, 1);

    if ($bmi < 18.5) {
        $category = "Underweight";
    } elseif ($bmi <= 24.9) {
        $category = "Normal";
    } else {
        $category = "Overweight";
    }

    return "BMI: $bmiRounded ($category)";
}

echo calculateBMI(68, 1.75);
?>