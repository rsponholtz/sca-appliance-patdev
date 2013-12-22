<?PHP

$DefaultValue = 'Python';
$TypeArray = array(
'Bash',
'Perl',
'Python',
'Other',
);

if ( isset($PatternType) ) {
	foreach ( $TypeArray as $ThisOne ) {
		if ( $PatternType == $ThisOne ) {
			echo "<OPTION SELECTED>$ThisOne</OPTION>";
		} else {
			echo "<OPTION>$ThisOne</OPTION>";
		}
	}
} else {
	foreach ( $TypeArray as $ThisOne ) {
		if ( $ThisOne == $DefaultValue ) {
			echo "<OPTION SELECTED>$ThisOne</OPTION>";
		} else {
			echo "<OPTION>$ThisOne</OPTION>";
		}
	}
}
echo "</SELECT>";
?>
