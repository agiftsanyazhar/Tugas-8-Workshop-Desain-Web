<?php
// Extract instrument ID from POST data...
$sn = $_POST['sn'];
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
    list($SN_dat, $A, $B, $C, $beta, $tau) = sscanf($line, "%s %f %f %f %f %f");
    if (strncasecmp($SN_dat, $sn, $len) == 0) {
        $found = 1;
    }
}
fclose($in);
if ($found == 0) {
    echo "Couldn't find this instrument.";
} else {
    // Build a table of outputs.
    echo "<p><table border='2'><tr><th>Quantity</th><th>Value</th></tr>";
    echo "<tr><td>Instrument ID</td><td>$sn</td></tr>";
    echo "<tr bgcolor='silver'><td colspan='2'>Calibration Constants</td></tr>";
    echo "<tr><td>A</td><td>$A</td></tr>";
    echo "<tr><td>B</td><td>$B</td></tr>";
    echo "<tr><td>C</td><td>$C</td></tr>";
    echo "<tr><td>&tau;</td><td>$tau</td></tr>";
    echo "<tr><td>&beta;</td><td>$beta</td></tr>";
    echo "</table>";
}
