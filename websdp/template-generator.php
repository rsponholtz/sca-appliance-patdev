<?PHP //echo "<!-- Modified: Date       = 2014 May 08 -->\n"; ?>
<?PHP include 'checklogin.php';?>
<HTML>
<HEAD>
<?PHP
	$PatternID = $_GET['pid'];
	$ErrorsFound = 0;

	if ( isset($PatternID) ) {
		if ( ! is_numeric($PatternID) ) {
			die("<FONT SIZE=\"-1\"><B>ERROR</B>: Invalid Pattern ID, Only numeric values allowed.</FONT><BR>");			
		}
	} else { 
		die("<FONT SIZE=\"-1\"><B>ERROR</B>: Invalid Pattern ID, Only numeric values allowed.</FONT><BR>");			
	}
	include 'sdp-config.php';
	$Connection = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	if ($Connection->connect_errno()) {
		echo "<P CLASS=\"head_1\" ALIGN=\"center\">SDP Database Pattern Index</P>\n";
		echo "<H2 ALIGN=\"center\">Connect to Database: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\">Make sure the MariaDB database is configured properly.</P>\n";
		echo "</BODY>\n</HTML>\n";
		die();
	}
	$Query = "SELECT * FROM $TableName WHERE PatternID=$PatternID";
	$Result = $Connection->query($query);
	$row_cell = $Result->fetch_row();
	$PatternID		= htmlspecialchars($row_cell[0]);
	$Title 			= htmlspecialchars($row_cell[1]);
	$Description 	= htmlspecialchars($row_cell[2]);
	$Class 			= htmlspecialchars($row_cell[3]);
	$Category 		= htmlspecialchars($row_cell[4]);
	$Component 		= htmlspecialchars($row_cell[5]);
	$Notes 			= htmlspecialchars($row_cell[6]);
	$PatternFile 	= htmlspecialchars($row_cell[7]);
	$PatternType 	= htmlspecialchars($row_cell[8]);
	$Submitted 		= htmlspecialchars($row_cell[9]);
	$Modified 		= htmlspecialchars($row_cell[10]);
	$Released 		= htmlspecialchars($row_cell[11]);
	$Submitter 		= htmlspecialchars($row_cell[12]);
	$Owner 			= htmlspecialchars($row_cell[13]);
	$PrimaryLink   = htmlspecialchars($row_cell[14]);
	$TID 				= htmlspecialchars($row_cell[15]);
	$BUG 				= htmlspecialchars($row_cell[16]);
	$URL01 			= htmlspecialchars($row_cell[17]);
	$URL02 			= htmlspecialchars($row_cell[18]);
	$URL03 			= htmlspecialchars($row_cell[19]);
	$URL04 			= htmlspecialchars($row_cell[20]);
	$URL05 			= htmlspecialchars($row_cell[21]);
	$URL06 			= htmlspecialchars($row_cell[22]);
	$URL07 			= htmlspecialchars($row_cell[23]);
	$URL08 			= htmlspecialchars($row_cell[24]);
	$URL09 			= htmlspecialchars($row_cell[25]);
	$URL10 			= htmlspecialchars($row_cell[26]);
	$Status 			= htmlspecialchars($row_cell[27]);
	$URLS          = array();
	if ( strlen($URL01) > 0 && $URL01 != "NULL" ) { $URLS[] = $URL01; }
	if ( strlen($URL02) > 0 && $URL02 != "NULL" ) { $URLS[] = $URL02; }
	if ( strlen($URL03) > 0 && $URL03 != "NULL" ) { $URLS[] = $URL03; }
	if ( strlen($URL04) > 0 && $URL04 != "NULL" ) { $URLS[] = $URL04; }
	if ( strlen($URL05) > 0 && $URL05 != "NULL" ) { $URLS[] = $URL05; }
	if ( strlen($URL06) > 0 && $URL06 != "NULL" ) { $URLS[] = $URL06; }
	if ( strlen($URL07) > 0 && $URL07 != "NULL" ) { $URLS[] = $URL07; }
	if ( strlen($URL08) > 0 && $URL08 != "NULL" ) { $URLS[] = $URL08; }
	if ( strlen($URL09) > 0 && $URL09 != "NULL" ) { $URLS[] = $URL09; }
	if ( strlen($URL10) > 0 && $URL10 != "NULL" ) { $URLS[] = $URL10; }

	//echo "<!-- template-generator.php \n";
	//var_dump($URLS);
	//echo "-->\n";

	$Result->close();
	$Connection->close();
	echo "<TITLE>$PatternType SDP Template</TITLE>\n";
	echo "</HEAD>\n";
	echo "<BODY>\n";

	if ( ! $Owner ) { $ErrOwner=1; } else { $ErrOwner=0; }
	if ( ! $Class ) { $ErrClass=1; } else { $ErrClass=0; }
	if ( $Category != '-Unassigned-' ) { $ErrCategory=0; } else { $ErrCategory=1; }
	if ( ! $Component )  { $ErrComponent=1; } else { $ErrComponent=0; }
	$Solutions = $TID . $BUG . $URL01 . $URL02 . $URL03 . $URL04 . $URL05 . $URL06 . $URL07 . $URL08 . $URL09 . $URL10;
	if ( ! $Solutions ) { $ErrSolution=1; } else { $ErrSolution=0; }
	$ErrorsFound = $ErrOwner + $ErrClass + $ErrComponent + $ErrSolution + $ErrCategory;
	$SolutionsArray = array();
	$I = 0;
	if ( isset($TID) ) {
		$SolutionsArray[$I++] = "$TID";
	} elseif ( isset($BUG) ) {
		$SolutionsArray[$I++] = "$BUG";
	} else {
		foreach ($URLS as $URLPair ) {
			$URL = preg_split("/=/", "$URLPair");
			if ( $URL[0] ) {
				break;
			}
		}
	}

	//echo "<!-- Variable: ErrOwner        = $ErrOwner -->\n";
	//echo "<!-- Variable: ErrClass        = $ErrClass -->\n";
	//echo "<!-- Variable: ErrCategory     = $ErrCategory -->\n";
	//echo "<!-- Variable: ErrComponent    = $ErrComponent -->\n";
	//echo "<!-- Variable: ErrSolution     = $ErrSolution -->\n";
	//echo "<!-- Variable: PrimaryLink     = $PrimaryLink -->\n";
	
	if ( $ErrorsFound ) {
		echo "<H2 ALIGN=\"center\">Generate SDP Template: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<TABLE ALIGN=\"center\">\n";
		if ($Owner) {
			echo "<TR><TD>Owner</TD><TD><FONT COLOR=\"green\">$Owner</FONT></TD></TR>\n";
		} else {
			echo "<TR><TD>Owner</TD><TD><FONT COLOR=\"red\">Missing</FONT></TD></TR>\n";
		}
		if ($Category != '-Unassigned-') {
			echo "<TR><TD>Category</TD><TD><FONT COLOR=\"green\">$Category</FONT></TD></TR>\n";
		} else {
			echo "<TR><TD>Category</TD><TD><FONT COLOR=\"red\">Unassigned</FONT></TD></TR>\n";
		}
		if ( ! $PrimaryLink ) {
			echo "<TR><TD>Primary Link</TD><TD><FONT COLOR=\"red\">Unassigned</FONT></TD></TR>\n";
		}
		echo "</TABLE>\n";
	} else {
		// Determine default primary link
	
		// Launch pattern type generator now that all the variables are loaded
		switch ($PatternType) {
		case "Bash":
			include 'template-bash.php';
			break;
		case "Perl":
			include 'template-perl.php';
			break;
		case "Python":
			include 'template-python.php';
			break;
		default:
			include 'template-other.php';
		};
	}
?>
</BODY>
</HTML>

