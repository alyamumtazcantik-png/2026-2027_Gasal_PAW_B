<?php
$a = array("A");
echo 'Array awal: ("A")<br>';
array_push($a, "B");
echo "Hasil array_push: " . implode(" ", $a);

echo "<br><br>";
$a = array("A", "B");
$b = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$c = array_merge($a, $b);
echo "Hasil array_merge: " . implode(" ", $c);

echo "<br><br>";
$a = array("x"=>1, "y"=>2);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo "Hasil array_values: " . implode(" ", array_values($a));

echo "<br><br>";
$a = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: " . array_search("B", $a);

echo "<br><br>";
$a = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo "Hasil array_filter: " . implode(" ", array_filter($a));

echo "<br><br>";
$a = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
sort($a);
echo "Hasil sort: " . implode(" ", $a);
rsort($a);
echo "<br>Hasil rsort: " . implode(" ", $a);

echo "<br><br>";
$a = array("Peter"=>35, "Ben"=>37, "Joe"=>43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

asort($a);
echo "Hasil asort: ";
foreach ($a as $nama => $umur) {
    echo "$nama=> $umur, ";
}

ksort($a);
echo "<br>Hasil ksort: ";
foreach ($a as $nama => $umur) {
    echo "$nama=> $umur, ";
}

arsort($a);
echo "<br>Hasil arsort: ";
foreach ($a as $nama => $umur) {
    echo "$nama=> $umur, ";
}

krsort($a);
echo "<br>Hasil krsort: ";
foreach ($a as $nama => $umur) {
    echo "$nama=> $umur, ";
}
?>