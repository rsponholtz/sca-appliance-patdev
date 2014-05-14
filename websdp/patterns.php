<?PHP //echo "<!-- Modified: Date       = 2014 May 12 -->\n"; ?>
<?PHP include 'checklogin.php';?>
<HTML>
<?PHP
	include 'sdp-config.php';

	$OrderBy = htmlspecialchars($_GET['by']);
	$OrderDir = htmlspecialchars($_GET['dir']);
	$ToggleDir = htmlspecialchars($_GET['td']);
	$Filter = htmlspecialchars($_GET['filter']);
	$Check = htmlspecialchars($_GET['ck']);

	//Validate and assign the default views
	if ( isset($OrderBy) ) {
		switch ($OrderBy) {
		case "PatternID":
		case "Title":
		case "Class":
		case "Category":
		case "Component":
		case "PatternFile":
		case "Modified":
		case "Submitter":
		case "Owner":
		case "Status":
			break;
		default:
			$OrderBy = "Status";
		}
	} else {
		$OrderBy = "Status";
	}

	if ( isset($OrderDir) ) {
		switch ($OrderDir) {
		case 'DESC':
		case 'ASC':
			break;
		default:
			$OrderDir = 'ASC';
		}
	} else {
		$OrderDir = 'ASC';
	}
	if ( isset($ToggleDir) ) {
		switch ($ToggleDir) {
		case '0':
		case '1':
			break;
		default:
			$ToggleDir = 0;
		}
	} else {
		$ToggleDir = 0;
	}
	if ( isset($Filter) ) {
		switch ($Filter) {
		case 'all':
		case 'dev':
		case 'testing':
		case 'release':
			break;
		default:
			$Filter = 'dev';
		}
	} else {
		$Filter = 'dev';
	}
	if ( isset($Check) ) {
		switch ($Check) {
		case '0':
		case '1':
			break;
		default:
			$Check = 0;
		}
	} else {
		$Check = 0;
	}

	//echo "<!-- Variable: OrderBy         = $OrderBy -->\n";
	//echo "<!-- Variable: OrderDir        = $OrderDir -->\n";
	//echo "<!-- Variable: ToggleDir       = $ToggleDir -->\n";
	//echo "<!-- Variable: Filter          = $Filter -->\n";
	//echo "<!-- Variable: Check           = $Check -->\n";

	$SubmitText = "Update Marked Patterns";
	$PatternFields = "PatternID,Title,Class,Category,Component,PatternFile,Modified,Submitter,Owner,Status";
	$ButtonsVisible = 1;
	switch ($Filter) {
	case "all":
		$StatusFilter = '';
		break;
	case "dev":
		$StatusFilter = "WHERE Status='Proposed' OR Status='Assigned' OR Status='In-Progress'";
		$ButtonsVisible = 0;
		break;
	case "testing":
		$StatusFilter = "WHERE Status='Complete' OR Status='Staging'";
		break;
	case "release":
		$StatusFilter = "WHERE Status='Released' OR Status='Maintenance'";
		break;
	}
	$Query="SELECT $PatternFields FROM $TableName $StatusFilter ORDER BY $OrderBy $OrderDir,Owner,Status";

	//Change sort order direction if requested
	if ( $ToggleDir > 0 ) {
		if ( $OrderDir == "ASC" ) { $OrderDir = "DESC"; } else { $OrderDir = "ASC"; }
	}

	echo "<META HTTP-EQUIV=\"Content-Style-Type\" CONTENT=\"text/css\">\n";
	echo "<LINK REL=\"stylesheet\" HREF=\"style.css\">\n";
	echo "<TITLE>SDP Submissions</TITLE>\n";
	echo "</HEAD>\n";
	echo "<BODY BGPROPERTIES=FIXED BGCOLOR=\"#FFFFFF\" TEXT=\"#000000\">\n";
	echo "\n<P CLASS=\"head_1\" ALIGN=\"center\">Supportconfig Diagnostic Patterns</P>\n";

	$Connection = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	if ($Connection->connect_errno) {
		echo "<P CLASS=\"head_1\" ALIGN=\"center\">SDP Database Pattern Index</P>\n";
		echo "<H2 ALIGN=\"center\">Connect to Database: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\">Make sure the MariaDB database is configured properly.</P>\n";
		echo "</BODY>\n</HTML>\n";
		die();
	}
	//echo "<!-- Query: Submitted          = $Query -->\n";
	$Result = $Connection->query($Query);
	$Num = $Result->num_rows;
	if ( $Result ) {
		//echo "<!-- Query: Result             = Success -->\n";
		//echo "<!-- Query: Rows               = $Num -->\n";
	} else {
		//echo "<!-- Query: Result             = FAILURE -->\n";
	}

	if ( isset($_POST['multi-edit']) ) {
		$UpdateErrors = 0;
		$PatternsUpdated = 0;
		$NewStatus = htmlspecialchars($_POST["form_status"]);
		if ( $NewStatus == "-Unchanged-" ) {
			echo "<H2 ALIGN=\"center\">$SubmitText: <FONT COLOR=\"blue\">Status Unchanged</FONT></H2>\n";
		} else {
			$i=0;
			while ( $row_cell = $Result->fetch_row() ) {
				$PatternID		= htmlspecialchars($row_cell[0]);
				$Title			= htmlspecialchars($row_cell[1]);
				$Class			= htmlspecialchars($row_cell[2]);
				$Category		= htmlspecialchars($row_cell[3]);
				$Component		= htmlspecialchars($row_cell[4]);
				$PatternFile	= htmlspecialchars($row_cell[5]);
				$Modified		= date('Y\-m\-d'); // row_cell[6] ignored
				$Released      = $Modified;
				$Submitter		= htmlspecialchars($row_cell[7]);
				$Owner			= htmlspecialchars($row_cell[8]);
				$Status			= $NewStatus; // row_cell[9] ignored
				$UpdateStatus	= htmlspecialchars($_POST["update_status_$PatternID"]); 

				if ( $UpdateStatus ) {
					switch ($Status) {
					case "Released":
					case "Maintenance":
						$Query = "UPDATE $TableName SET Status='$Status',Modified='$Modified',Released='$Released' WHERE PatternID=$PatternID";
						break;
					default:
						$Query = "UPDATE $TableName SET Status='$Status',Modified='$Modified' WHERE PatternID=$PatternID";				
					}

					//echo "<!-- Query: Submitted          = $Query -->\n";
					$UpdateResult = $Connection->query($Query);
					if ( $UpdateResult ) {
						//echo "<!-- Query: Result             = Success -->\n";
						$PatternsUpdated++;
					} else {
						//echo "<!-- Query: Result             = FAILURE -->\n";
						$UpdateErrors++;
					}
					$UpdateResult->close();

				} else {
					//echo "<!-- Variable: UpdateStatus    = Not Checked for PatternID $PatternID -->\n";
					//echo "<!-- Query: Result             = Skipped -->\n";
				}
			}
			$Result->close();

			if ( $UpdateErrors ) {
				echo "<H2 ALIGN=\"center\">$SubmitText: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
				echo "<H3 ALIGN=\"center\">Errors Found: $UpdateErrors</H3>\n";
			} else {
				echo "<H2 ALIGN=\"center\">$SubmitText: <FONT COLOR=\"green\">Success</FONT></H2>\n";
				echo "<H3 ALIGN=\"center\">Pattern Statuses Updated: $PatternsUpdated</H3>\n";
			}
		}
		echo "<P ALIGN=\"center\">Return to <A HREF=\"patterns.php?by=$OrderBy&dir=$OrderDir&td=$ToggleDir&filter=$Filter&ck=0\">SDP Submissions</A></P>\n";
	} else { // end _POST['multi-edit']

		if ( $Check ) { $CheckMark="CHECKED"; } else { $CheckMark=""; }

		// Menu
		echo "<P CLASS=\"head3b\" ALIGN=\"center\">";
		echo "[&nbsp;<A HREF=\"pattern-add.php?by=$OrderBy&dir=$OrderDir&filter=$Filter&ck=$Check\">Create A Pattern</A>&nbsp;";
		echo "|&nbsp;<A HREF=\"pattern-summary.php?by=$OrderBy&dir=$OrderDir&td=0&filter=$Filter&ck=$Check\">Summary</A>&nbsp;";
		echo "|&nbsp;<A HREF=\"help-sdp.html\" TARGET=\"_blank\">Documentation</A>&nbsp;";
		echo "|&nbsp;Filters:&nbsp;";
		if ( $Filter == "dev" ) { echo " Dev&nbsp;"; } else { echo " <A HREF=\"patterns.php?by=$OrderBy&dir=$OrderDir&td=0&filter=dev&ck=0\">Dev</A>&nbsp;"; }
		if ( $Filter == "testing" ) { echo " Testing&nbsp;"; } else { echo " <A HREF=\"patterns.php?by=$OrderBy&dir=$OrderDir&td=0&filter=testing&ck=0\">Testing</A>&nbsp;"; }
		if ( $Filter == "release" ) { echo " Released&nbsp;"; } else { echo " <A HREF=\"patterns.php?by=$OrderBy&dir=$OrderDir&td=0&filter=release&ck=0\">Released</A>&nbsp;"; }
		if ( $Filter == "all" ) { echo " All&nbsp;"; } else { echo " <A HREF=\"patterns.php?by=$OrderBy&dir=$OrderDir&td=0&filter=all&ck=0\">All</A>&nbsp;"; }
		echo "]</P>\n";

		// Create table header
		echo "<TABLE ALIGN=\"center\" WIDTH=100% CELLPADDING=2>\n";
		echo "<TR CLASS=\"head_2\">";
		echo "<TH><A HREF=\"patterns.php?by=PatternID&dir=$OrderDir&td=1&filter=$Filter&ck=$Check\" CLASS=\"head_2\">ID</A></TH>\n";
		echo "<TH ALIGN=\"left\"><A HREF=\"patterns.php?by=Title&dir=$OrderDir&td=1&filter=$Filter&ck=$Check\" CLASS=\"head_2\">Title</A></TH>\n";
		echo "<TH><A HREF=\"patterns.php?by=Class&dir=$OrderDir&td=1&filter=$Filter&ck=$Check\" CLASS=\"head_2\">Class</A></TH>\n";
		echo "<TH><A HREF=\"patterns.php?by=Category&dir=$OrderDir&td=1&filter=$Filter&ck=$Check\" CLASS=\"head_2\">Category</A></TH>\n";
		echo "<TH><A HREF=\"patterns.php?by=Component&dir=$OrderDir&td=1&filter=$Filter&ck=$Check\" CLASS=\"head_2\">Component</A></TH>\n";
		echo "<TH><A HREF=\"patterns.php?by=PatternFile&dir=$OrderDir&td=1&filter=$Filter&ck=$Check\" CLASS=\"head_2\">Pattern<BR>Filename</A></TH>\n";
		echo "<TH><A HREF=\"patterns.php?by=Modified&dir=$OrderDir&td=1&filter=$Filter&ck=$Check\" CLASS=\"head_2\">Date<BR>Last Modified</A></TH>\n";
		echo "<TH><A HREF=\"patterns.php?by=Submitter&dir=$OrderDir&td=1&filter=$Filter&ck=$Check\" CLASS=\"head_2\">Submitter</A></TH>\n";
		echo "<TH><A HREF=\"patterns.php?by=Owner&dir=$OrderDir&td=1&filter=$Filter&ck=$Check\" CLASS=\"head_2\">Owner</A></TH>\n";
		echo "<TH CLASS=\"head_2\">Multi-Status<BR>Edit</TH>\n";
		echo "<TH><A HREF=\"patterns.php?by=Status&dir=$OrderDir&td=1&filter=$Filter&ck=$Check\" CLASS=\"head_2\">Status</A></TH>\n";
		echo "</TR>\n";

		echo "<FORM METHOD=post>\n";
		$i=0;
		while ( $row_cell = $Result->fetch_row() ) {
			$PatternID		= htmlspecialchars($row_cell[0]);
			$Title			= htmlspecialchars($row_cell[1]);
			$Class			= htmlspecialchars($row_cell[2]);
			$Category		= htmlspecialchars($row_cell[3]);
			$Component		= htmlspecialchars($row_cell[4]);
			$PatternFile	= htmlspecialchars($row_cell[5]);
			$Modified		= htmlspecialchars($row_cell[6]);
			$Submitter		= htmlspecialchars($row_cell[7]);
			$Owner			= htmlspecialchars($row_cell[8]);
			$Status			= htmlspecialchars($row_cell[9]);
			if ( $Class == "" ) { $Class="&nbsp;"; }
			if ( $Category == "" ) { $Category="&nbsp;"; }
			if ( $Component == "" ) { $Component="&nbsp;"; }
			if ( $PatternFile == "" ) { $PatternFile="&nbsp;"; }
			if ( $Owner == "" ) { $Owner="&nbsp;"; }

			// Set row color
			if ( $i%2 == 0 ) { $row_color="tdGrey"; } else { $row_color="tdGreyLight"; }

			//Create table rows with data
			echo "<TR ALIGN=\"center\" CLASS=\"$row_color\">";
			echo "<TD>$PatternID</TD>";
			echo "<TD ALIGN=\"left\"><A HREF=\"pattern-edit.php?pid=$PatternID\" TARGET=\"_blank\">$Title</A></TD>";
			echo "<TD>$Class</TD>";
			echo "<TD>$Category</TD>";
			echo "<TD>$Component</TD>";
			echo "<TD>$PatternFile</TD>";
			echo "<TD>$Modified</TD>";
			echo "<TD>$Submitter</TD>";
			echo "<TD>$Owner</TD>";
			if ( $ButtonsVisible ) {
				echo "<TD><INPUT TYPE=\"checkbox\" NAME=\"update_status_$PatternID\" $CheckMark></TD>";
			} else {
				echo "<TD>-</TD>";
			}
			echo "<TD>$Status</TD>";
			echo "</TR>\n";
		}
		if ( $Num > 0 && $ButtonsVisible ) {
			echo "<TR CLASS=\"head_2\">\n";
			echo "<TD ALIGN=\"center\" COLSPAN=\"11\">\n";
			echo "<INPUT TYPE=\"BUTTON\" VALUE=\"Select None\" ONCLICK=\"window.location.href='patterns.php?by=$OrderBy&dir=$OrderDir&td=0&filter=$Filter&ck=0'\">&nbsp;&nbsp;\n";
			echo "<INPUT TYPE=\"BUTTON\" VALUE=\"Select All\" ONCLICK=\"window.location.href='patterns.php?by=$OrderBy&dir=$OrderDir&td=0&filter=$Filter&ck=1'\">&nbsp;&nbsp;\n";
			echo "<SELECT NAME=\"form_status\">";
            include 'form-status-edit-multiple.php';
			echo "&nbsp;&nbsp;<INPUT TYPE=\"submit\" NAME=\"multi-edit\" ID=\"multi-edit\" VALUE=\"$SubmitText\"></TD>\n";
			echo "</TR>\n";
		} elseif ( $Num > 0 ) {
			echo "<TR CLASS=\"head_2\"><TD ALIGN=\"center\" COLSPAN=\"11\">&nbsp;</TD></TR>\n";
		} else {
			echo "<TR CLASS=\"head_2\"><TD ALIGN=\"center\" COLSPAN=\"11\">No Applicable Patterns</TD></TR>\n";
		}
		echo "</TABLE>\n\n";

		echo "</FORM>\n";
	}
	$Result->close();
	$Connection->close();

	//echo "<!-- Variable: OrderBy         = $OrderBy -->\n";
	//echo "<!-- Variable: OrderDir        = $OrderDir -->\n";
	//echo "<!-- Variable: ToggleDir       = $ToggleDir -->\n";
	//echo "<!-- Variable: Filter          = $Filter -->\n";
	//echo "<!-- Variable: Check           = $Check -->\n";
?>
</BODY>
</HTML>

