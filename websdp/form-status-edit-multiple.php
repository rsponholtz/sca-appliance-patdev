<?PHP //echo "<!-- Modified: Date       = 2014 Jan 22 -->\n"; ?>
<?PHP

$StatusArray = array(
'-Unchanged-',
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

foreach ( $StatusArray as $ThisOne ) {
	echo "<OPTION>$ThisOne</OPTION>";
}
echo "</SELECT>";
?>
