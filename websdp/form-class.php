<?PHP //echo "<!-- Modified: Date       = 2021 Mar 12 -->\n"; ?>
<?PHP

$ClassArray = array(
'Basic Health',
'Cloud',
'HAE',
'HPC',
'Security',
'SES',
'SLE',
'SUMA',
'Custom'
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
