<?php
// Extract instrument ID from POST data...
$sn = $_POST['station'];
$len = strlen($sn);
// Open WV instrument calibration constant file...
$inFile = "WVdata.dat";
$in = fopen($inFile, "r") or die("Can't open file");
// Read one header line...
$line = fgets($in);
// Search the rest of the file for SN match...
$found = 0;
while ((!feof($in)) && ($found == 0)) {
    $line = fgets($in);
    list($station_dat, $sMean, $s5Tile, $s95Tile, $mMean, $m5Tile, $m95Tile, $dMean, $d5Tile, $d95Tile, $rr) = sscanf($line, "%s %f %f %f %f %f %f %f %f %f %f");
    if (strncasecmp($station_dat, $sn, $len) == 0) {
        $found = 1;
    }
}
fclose($in);
if ($found == 0) {
    echo "Couldn't find this instrument.";
} else {
    // Build a table of outputs.
    echo "Instrument ID: $sn";
    echo "<table border='2'><tr><th rowspan='2'>Station</th><th colspan='3'>Simulated</th><th colspan='3'>Measured</th><th colspan='3'>Difference</th><th rowspan='2'>R<sup>2</sup></th></tr>";
    echo "<tr><td>Mean</td><td>5% tile</td><td>95% tile</td><td>Mean</td><td>5% tile</td><td>95% tile</td><td>Mean</td><td>5% tile</td><td>95% tile</td></tr>";
    echo "<tr><td>$sn</td><td>$sMean</td><td>$s5Tile</td><td>$s95Tile</td><td>$mMean</td><td>$m5Tile</td><td>$m95Tile</td><td>$dMean</td><td>$d5Tile</td><td>$d95Tile</td><td>$rr</td></tr>";
    echo "</table>";
}
