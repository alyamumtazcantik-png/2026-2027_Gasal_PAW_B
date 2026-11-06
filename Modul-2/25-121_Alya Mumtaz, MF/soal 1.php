<?php

$matkul = ["PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];
$praktikum = ["JARKOM", "PAW"];

for ($i = 0; $i < count($matkul); $i++) {

    if ($matkul[$i] == $praktikum[0] || $matkul[$i] == $praktikum[1]) {
        echo "Saya sedang mengambil matkul " . $matkul[$i] . " termasuk praktikumnya";
    } elseif ($i == 6 || $i == 7) {
        echo "Saya belum mengambil matkul " . $matkul[$i];
    } else {
        echo "Saya sudah mengambil matkul " . $matkul[$i] . " semester lalu";
    }

    echo "<br>";
}

?>



<?php
// Array untuk menyimpan tanggal hari libur
$hariLibur = [
    "October" => [22, 29, 30],
    "November" => [10]
];

// Fungsi untuk menampilkan kalender
function tampilKalender($bulan, $tahun, $hariLibur) {
    $jumlahHari = cal_days_in_month(CAL_GREGORIAN,
        date('n', strtotime("1 $bulan $tahun")), $tahun);

    $tanggalPertama = date('w', strtotime("1 $bulan $tahun"));
    $hariIni = date('j');
    $bulanIni = date('F');

    echo "<h2>$bulan</h2>";
    echo "<table border='1' cellspacing='2' cellpadding='4'>";
    echo "<tr>
            <th>Sun</th><th>Mon</th><th>Tue</th>
            <th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
          </tr><tr>";

    // Mengatur posisi tanggal pertama
    for ($i = 0; $i < $tanggalPertama; $i++) {
        echo "<td></td>";
    }

    for ($tanggal = 1; $tanggal <= $jumlahHari; $tanggal++) {
        $hari = ($tanggalPertama + $tanggal - 1) % 7;

        $warna = "";
        if ($hari == 0 || in_array($tanggal, $hariLibur[$bulan] ?? [])) {
            $warna = "color:red;";
        }

        // Menandai tanggal hari ini
        $highlight = ($tanggal == $hariIni && $bulan == $bulanIni)
            ? "background:yellow;" : "";

        echo "<td style='$warna $highlight'>$tanggal</td>";

        if ($hari == 6 && $tanggal != $jumlahHari) {
            echo "</tr><tr>";
        }
    }

    echo "</tr></table><br>";
}

// Menampilkan kalender Oktober dan November
$tahun = 2026;
tampilKalender("October", $tahun, $hariLibur);
tampilKalender("November", $tahun, $hariLibur);
?>

<style>
    body {
        font-family: Arial;
        margin: 30px;
    }

    h2 {
        margin-bottom: 10px;
    }

    table {
        border-collapse: separate;
    }

    th {
        font-weight: bold;
    }
</style>
