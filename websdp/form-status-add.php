<?PHP //echo "<!-- Modified: Date       = 2014 Jan 22 -->\n"; ?>
<?PHP

$StatusArray = array(
'Proposed',
'Assigned',
'In-Progress',
);

if ( isset($Status) ) {
	foreach ( $StatusArray as $ThisStatus ) {
		if ( $Status == $ThisStatus ) {
			echo "    <OPTION SELECTED>$ThisStatus</OPTION>\n";
		} else {
			echo "    <OPTION>$ThisStatus</OPTION>\n";
		}
	}
} else {
	foreach ( $StatusArray as $ThisStatus ) {
		echo "    <OPTION>$ThisStatus</OPTION>\n";
	}
}
echo "  </SELECT>\n";
?>
