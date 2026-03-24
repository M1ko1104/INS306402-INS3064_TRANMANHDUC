<?php
$students = [
    ["name" => "Alice", "grade" => 90],
    ["name" => "Bob", "grade" => 75],
    ["name" => "Charlie", "grade" => 88],
];

echo "<table border='1'>";
echo "<tr><th>Name</th><th>Grade</th></tr>";

foreach ($students as $student) {
    echo "<tr>";
    echo "<td>" . $student["name"] . "</td>";
    echo "<td>" . $student["grade"] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>