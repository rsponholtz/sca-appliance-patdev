<?PHP //echo "<!-- Modified: Date       = 2014 Jan 22 -->\n"; ?>
<?PHP

$ClassArray = array(
'Custom',
'Basic Health',
'HAE',
'NCS',
'eDirectory',
'Filr',
'GroupWise',
'OES',
'Print',
'Security',
'SLE',
);

if ( isset($Class) ) {
	foreach ( $ClassArray as $ThisOne ) {
		if ( $Class == $ThisOne ) {
			echo "<OPTION SELECTED>$ThisOne</OPTION>";
		} else {
			echo "<OPTION>$ThisOne</OPTION>";
		}
	}
} else {
	foreach ( $ClassArray as $ThisOne ) {
		echo "<OPTION>$ThisOne</OPTION>";
	}
}
echo "</SELECT>";
?>
