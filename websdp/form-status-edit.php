<?PHP

$StatusArray = array(
'Proposed',
'Assigned',
'In-Progress',
'Complete',
'Staging',
'Released',
'Maintenance',
'Obsolete',
'Rejected'
);

if ( isset($Status) ) {
	foreach ( $StatusArray as $ThisOne ) {
		if ( $Status == $ThisOne ) {
			echo "<OPTION SELECTED>$ThisOne</OPTION>";
		} else {
			echo "<OPTION>$ThisOne</OPTION>";
		}
	}
} else {
	foreach ( $StatusArray as $ThisOne ) {
		echo "<OPTION>$ThisOne</OPTION>";
	}
}
echo "</SELECT>";
?>
