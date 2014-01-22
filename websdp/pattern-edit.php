<!-- Modified: Date            = 2014 Jan 22 -->
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
<LINK REL="stylesheet" HREF="style.css">

<?PHP
$PatternID = htmlspecialchars($_GET['pid']);
$UpdatedOnce = htmlspecialchars($_GET['up']);
$PageTitle = "Supportconfig Diagnostic Pattern";
$PageFunction = "Edit";
if ( isset($PatternID) ) {
	if ( ! is_numeric($PatternID) ) {
		die("<FONT SIZE=\"-1\"><B>ERROR</B>: Invalid Pattern ID, Only numeric values allowed.</FONT><BR>");			
	}
} else {
	die("<FONT SIZE=\"-1\"><B>ERROR</B>: Missing Pattern ID</FONT><BR>");
}

if ( ! isset($UpdatedOnce) ) { $UpdatedOnce = 0; }

include 'db-config.php';

//echo "<!-- Variable: UpdatedOnce     = $UpdatedOnce -->\n";
//echo "<!-- Variable: OrderBy         = $OrderBy -->\n";
//echo "<!-- Variable: OrderDir        = $OrderDir -->\n";
//echo "<!-- Variable: ToggleDir       = $ToggleDir -->\n";
//echo "<!-- Variable: Filter          = $Filter -->\n";
//echo "<!-- Variable: PatternID       = $PatternID -->\n";

if (isset($_POST['update-sdp'])) {
	$Title 			= $_POST['form_title'];
	$Description 	= $_POST['form_description'];
	$Class 			= $_POST['form_class'];
	$Category 		= $_POST['form_category'];
	$Component 		= $_POST['form_component'];
	$Notes 			= $_POST['form_notes'];
	$PatternFile 	= $_POST['form_pattern_file'];
	$PatternType 	= $_POST['form_pattern_type'];
	$Submitted 		= $_POST['form_submitted'];
	$Modified 		= date('Y\-m\-d');
	$Released 		= $_POST['form_released'];
	$Submitter 		= $_POST['form_submitter'];
	$Owner 			= $_POST['form_owner'];
	$PrimaryLink   = $_POST['form_plink'];
	$TID 				= $_POST['form_tid'];
	$BUG 				= $_POST['form_bug'];
	$URL01 			= $_POST['form_url1'];
	$URL02 			= $_POST['form_url2'];
	$URL03 			= $_POST['form_url3'];
	$URL04 			= $_POST['form_url4'];
	$URL05 			= $_POST['form_url5'];
	$Status 			= $_POST['form_status'];

	if ( $Status == "Released" || $Status == "Maintenance" ) {
		if ( $Released < 1 ) {
			$Released = $Modified;
		}
	}
	//echo "<!-- Variable: PrimaryLink     = $PrimaryLink -->\n";
	if ( strlen($PrimaryLink) < 1 ) {
		if ( strlen($TID) > 0 ) { $PrimaryLink = "META_LINK_TID"; }
		elseif ( strlen($BUG) > 0 ) { $PrimaryLink = "META_LINK_BUG"; }
		elseif ( strlen($URL01) > 0 ) { $URL = preg_split("/=/", "$URL01"); $PrimaryLink = "META_LINK_$URL[0]"; }
		elseif ( strlen($URL02) > 0 ) { $URL = preg_split("/=/", "$URL02"); $PrimaryLink = "META_LINK_$URL[0]"; }
		elseif ( strlen($URL03) > 0 ) { $URL = preg_split("/=/", "$URL03"); $PrimaryLink = "META_LINK_$URL[0]"; }
		elseif ( strlen($URL04) > 0 ) { $URL = preg_split("/=/", "$URL04"); $PrimaryLink = "META_LINK_$URL[0]"; }
		elseif ( strlen($URL05) > 0 ) { $URL = preg_split("/=/", "$URL05"); $PrimaryLink = "META_LINK_$URL[0]"; }
		else { $PrimaryLink = ''; }
	}

	$UpdatedOnce	= $_POST['form_updated_once'];
	
	include 'db-open.php';
	$Query = "LOCK TABLES $TableName WRITE";
	mysql_query($Query) or die("<FONT SIZE=\"-1\"><B>ERROR</B>: Database: Table $TableName Lock -> <B>FAILED</B></FONT><BR>\n");

	//echo "<!-- Query: Submitted          = $Query -->\n";
	//echo "<!-- Database: Table           = Locked $TableName -->\n";

	if ( $Title && $Submitter && $Category && $Component ) {
		if ( $Status == "Complete" && $Owner == "" ) {
			echo "</HEAD>\n";
			echo "<BODY>\n";
			echo "<P CLASS=\"head_1\" ALIGN=\"center\">$PageTitle</P>\n";
			echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
			echo "<H2 ALIGN=\"center\">Update Pattern: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
			echo "<P ALIGN=\"center\"><B>ERROR:</B> No assigned owner.</P>\n";
			echo "<P ALIGN=\"center\">Click <B>back</B>, and correct.</P>\n";
		} else {
			if ( ( $Status == "Assigned" || $Status == "In-Progress" ) && $Owner == "" ) {
				$Owner = $Submitter;
				$Owner2submitter = 1;
				$LocalRefresh = $StatusRefresh * 3;
				//echo "<!-- Override: Owner           = $Owner -->\n";
			} else {
				$Owner2submitter = 0;
				$LocalRefresh = $StatusRefresh;
			}
			if ( $Status == "Proposed" && $Owner != "" ) {
				$Status = 'Assigned'; 
				$Status2assigned = 1;
				$LocalRefresh = $StatusRefresh * 3;
				//echo "<!-- Override: Status          = $Status -->\n";
			} else {
				$Status2assigned = 0;
				$LocalRefresh = $StatusRefresh;
			}
			$Title = str_replace("'", "\'", $Title);
			$Description = str_replace("'", "\'", $Description);
			$Query = "UPDATE $TableName SET Title='$Title', Description='$Description', Class='$Class', Category='$Category', Component='$Component', Notes='$Notes', PatternFile='$PatternFile', PatternType='$PatternType', Submitted='$Submitted', Modified='$Modified', Released='$Released', Submitter='$Submitter', Owner='$Owner', PrimaryLink='$PrimaryLink', TID='$TID', BUG='$BUG', URL01='$URL01', URL02='$URL02', URL03='$URL03', URL04='$URL04', URL05='$URL05', Status='$Status' WHERE PatternID=$PatternID";

			//echo "<!-- Query: Submitted          = $Query -->\n";
			$Result=mysql_query($Query);
			if ($Result) {
				//echo "<!-- Query: Result             = Success -->\n";
				if ( ! isset($DEBUG) ) { echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$LocalRefresh;URL=pattern-edit.php?pid=$PatternID&by=$OrderBy&dir=$OrderDir&filter=$Filter&up=1\">\n"; }
				echo "<BODY>\n";
				echo "<P CLASS=\"head_1\" ALIGN=\"center\">$PageTitle</P>\n";
				echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
				if ( $Owner2submitter ) {
					echo "<H2 ALIGN=\"center\"><FONT COLOR=\"blue\">Override</FONT>: Submitter Assigned to Missing Owner -> <FONT COLOR=\"blue\">Done</FONT></H2>\n";
				}
				if ( $Status2assigned ) {
					echo "<H2 ALIGN=\"center\"><FONT COLOR=\"blue\">Override</FONT>: Pre-existing Owner, Status Changed to Assigned -> <FONT COLOR=\"blue\">Done</FONT></H2>\n";
				}
				echo "<H2 ALIGN=\"center\">Update Pattern: <FONT COLOR=\"green\">Success</FONT></H2>\n";
			} else {
				//echo "<!-- Query: Result             = FAILED -->\n";
				echo "<BODY>\n";
				echo "<P CLASS=\"head_1\" ALIGN=\"center\">$PageTitle</P>\n";
				echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
				echo "<H2 ALIGN=\"center\">Update Pattern: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
				echo "<P ALIGN=\"center\"><B>ERROR:</B> " . mysql_error() . "</P>\n";
				echo "<P ALIGN=\"center\">Click <B>back</B>, and correct.</P>\n";
			}
		}
	} else {
		echo "<BODY>\n";
		echo "<P CLASS=\"head_1\" ALIGN=\"center\">$PageTitle</P>\n";
		echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
		echo "<H2 ALIGN=\"center\">Update Pattern: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\"><B>ERROR:</B> Missing Required Field(s).</P>\n";
		echo "<P ALIGN=\"center\">Click <B>back</B>, and correct.</P>\n";
	}

	$Query = "UNLOCK TABLES";
	//echo "<!-- Query: Submitted          = $Query -->\n";
	mysql_query($Query) or die("<FONT SIZE=\"-1\">Database: <B>ERROR</B>, Table $TableName Unlock -> <B>FAILED</B></FONT><BR>\n");
	//echo "<!-- Database: Table           = UnLocked $TableName -->\n";

	include 'db-close.php';
} else {
?>
</HEAD>
<BODY>

<?PHP
	echo "<P CLASS=\"head_1\" ALIGN=\"center\">$PageTitle</P>\n";
	echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
	include 'db-open.php';
	if ( ! isset($PatternID) ) {
		die("<B>ERROR</B>: Undefined Variable \"PatternID\" -> <B>FAILED</B>\n");
	}
	$Query = "SELECT * FROM $TableName WHERE PatternID=$PatternID";
	$Result=mysql_query($Query);
	$NumRows=mysql_numrows($Result);
	//echo "<!-- Query: Submitted          = $Query -->\n";
	if ( $Result ) {
		//echo "<!-- Query: Result             = Success -->\n";
		//echo "<!-- Query: Rows               = $NumRows -->\n";
	} else {
		//echo "<!-- Query: Results            = FAILURE -->\n";
	}
	include 'db-close.php';
	$row_cell = mysql_fetch_row($Result);
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
//	$URL06 			= htmlspecialchars($row_cell[22]);
//	$URL07 			= htmlspecialchars($row_cell[23]);
//	$URL08 			= htmlspecialchars($row_cell[24]);
//	$URL09 			= htmlspecialchars($row_cell[25]);
//	$URL10 			= htmlspecialchars($row_cell[26]);
	$Status 			= htmlspecialchars($row_cell[27]);
?>

<FORM METHOD="post">
<TABLE ALIGN="center" BORDER=0>
<TR VALIGN="top"><TD>

<?PHP
	echo "<INPUT TYPE=\"hidden\" NAME=\"form_updated_once\" VALUE=\"Updated\">\n";
	echo "<TABLE BORDER=0>\n";
	echo "<TR><TD>Submitter:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_submitter\" SIZE=$FieldLength VALUE=\"$Submitter\"><FONT COLOR=\"red\">*</FONT></TD></TR>\n";
	echo "<TR><TD>Owner:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_owner\" SIZE=$FieldLength VALUE=\"$Owner\"></TD></TR>\n";
	echo "<TR><TD>Title (Max Length 60):</TD><TD><INPUT TYPE=\"text\" NAME=\"form_title\" SIZE=$FieldLength MAXLENGTH=60 VALUE=\"$Title\"><FONT COLOR=\"red\">*</FONT></TD></TR>\n";
	echo "<TR><TD>Description:</TD><TD><TEXTAREA NAME=\"form_description\" COLS=$DescLength ROWS=4>$Description</TEXTAREA></TD></TR>\n";
	echo "<TR><TD>Class:</TD><TD>";
		echo "<SELECT NAME=\"form_class\" CLASS=\"text\">";
		include 'form-class.php';
	echo "</TD>";
	echo "<TR><TD>Category:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_category\" SIZE=$FieldLength VALUE=\"$Category\"><FONT COLOR=\"red\">*</FONT></TD></TR>\n";
	echo "<TR><TD>Component:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_component\" SIZE=$FieldLength VALUE=\"$Component\"><FONT COLOR=\"red\">*</FONT></TD></TR>\n";
	echo "<TR><TD>Status:</TD><TD>";
		echo "<SELECT NAME=\"form_status\" CLASS=\"text\">";
		include 'form-status-edit.php';
	echo "</TD>";
	if ( $Released > 0 ) { $Msg = "$Released"; } else { $Msg = "Pending"; }
	echo "<TR><TD>Release:<INPUT TYPE=\"hidden\" NAME=\"form_released\" VALUE=\"$Released\"><INPUT TYPE=\"hidden\" NAME=\"form_submitted\" VALUE=\"$Submitted\"></TD><TD>$Msg</TD></TR>\n";
	echo "</TABLE>\n";
?>

</TD><TD>

<?PHP
	echo "<TABLE BORDER=0>\n";
	echo "<TR><TD>Pattern ID:</TD><TD>$PatternID</TD></TR>\n";
	echo "<TR><TD>Pattern File:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_pattern_file\" SIZE=$FieldLength VALUE=\"$PatternFile\"></TD></TR>\n";
	echo "<TR><TD>Pattern Type:</TD><TD>";
		echo "<SELECT NAME=\"form_pattern_type\" CLASS=\"text\">";
		include 'form-pattern-type.php';
	echo "</TD></TR>\n";

	//echo "<!-- Variable: PrimaryLink     = $PrimaryLink -->\n";
	echo "<TR><TD>";
	if ( $TID ) {
		if ( "$PrimaryLink" == "META_LINK_TID" ) { $CheckMark = "CHECKED=\"yes\""; }
		echo "<A HREF=\"$TID\" TARGET=\"_blank\">TID URL:</A></TD><TD><INPUT TYPE=\"text\" NAME=\"form_tid\" SIZE=$FieldLength VALUE=\"$TID\">";
		echo "<INPUT TYPE=\"radio\" NAME=\"form_plink\" VALUE=\"META_LINK_TID\" $CheckMark>";
		$CheckMark = '';
	} else {
		echo "TID URL:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_tid\" SIZE=$FieldLength VALUE=\"$TID\">";
	}
	echo "</TD></TR>\n";

	echo "<TR><TD>";
	if ( $BUG ) {
		if ( "$PrimaryLink" == "META_LINK_BUG" ) { $CheckMark = "CHECKED=\"yes\""; }
		echo "<A HREF=\"$BUG\" TARGET=\"_blank\">BUG URL:</A></TD><TD><INPUT TYPE=\"text\" NAME=\"form_bug\" SIZE=$FieldLength VALUE=\"$BUG\">";
		echo "<INPUT TYPE=\"radio\" NAME=\"form_plink\" VALUE=\"META_LINK_BUG\" $CheckMark>";
		$CheckMark = '';
	} else {
		echo "<TR><TD>BUG URL:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_bug\" SIZE=$FieldLength VALUE=\"$BUG\">";
	}
	echo "</TD></TR>\n";

	$URL_SEQ = 0; //Initialize sequence
	$CheckMark = '';

	echo "<TR><TD>";
	$URL_FULL = $URL01;
	$URL_SEQ++;
	$URL = preg_split("/=/", "$URL_FULL");
	$URL_TAG = "META_LINK_$URL[0]";
	unset($URL[0]);
	$URL_VALUE = implode("=", $URL);
	if ( $URL_VALUE ) {
		if ( "$PrimaryLink" == "$URL_TAG" ) { $CheckMark = "CHECKED=\"yes\""; }
		echo "<A HREF=\"$URL_VALUE\" TARGET=\"_blank\">URL Pair $URL_SEQ:</A></TD><TD><INPUT TYPE=\"text\" NAME=\"form_url$URL_SEQ\" SIZE=$FieldLength VALUE=\"$URL_FULL\">";
		echo "<INPUT TYPE=\"radio\" NAME=\"form_plink\" VALUE=\"$URL_TAG\" $CheckMark>";
		$CheckMark = '';
	} else {
		echo "URL Pair $URL_SEQ:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_url$URL_SEQ\" SIZE=$FieldLength VALUE=\"$URL_FULL\">";
	}
	echo "</TD></TR>\n";

	echo "<TR><TD>";
	$URL_FULL = $URL02;
	$URL_SEQ++;
	$URL = preg_split("/=/", "$URL_FULL");
	$URL_TAG = "META_LINK_$URL[0]";
	unset($URL[0]);
	$URL_VALUE = implode("=", $URL);
	if ( $URL_VALUE ) {
		if ( "$PrimaryLink" == "$URL_TAG" ) { $CheckMark = "CHECKED=\"yes\""; }
		echo "<A HREF=\"$URL_VALUE\" TARGET=\"_blank\">URL Pair $URL_SEQ:</A></TD><TD><INPUT TYPE=\"text\" NAME=\"form_url$URL_SEQ\" SIZE=$FieldLength VALUE=\"$URL_FULL\">";
		echo "<INPUT TYPE=\"radio\" NAME=\"form_plink\" VALUE=\"$URL_TAG\" $CheckMark>";
		$CheckMark = '';
	} else {
		echo "URL Pair $URL_SEQ:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_url$URL_SEQ\" SIZE=$FieldLength VALUE=\"$URL_FULL\">";
	}
	echo "</TD></TR>\n";

	echo "<TR><TD>";
	$URL_FULL = $URL03;
	$URL_SEQ++;
	$URL = preg_split("/=/", "$URL_FULL");
	$URL_TAG = "META_LINK_$URL[0]";
	unset($URL[0]);
	$URL_VALUE = implode("=", $URL);
	if ( $URL_VALUE ) {
		if ( "$PrimaryLink" == "$URL_TAG" ) { $CheckMark = "CHECKED=\"yes\""; }
		echo "<A HREF=\"$URL_VALUE\" TARGET=\"_blank\">URL Pair $URL_SEQ:</A></TD><TD><INPUT TYPE=\"text\" NAME=\"form_url$URL_SEQ\" SIZE=$FieldLength VALUE=\"$URL_FULL\">";
		echo "<INPUT TYPE=\"radio\" NAME=\"form_plink\" VALUE=\"$URL_TAG\" $CheckMark>";
		$CheckMark = '';
	} else {
		echo "URL Pair $URL_SEQ:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_url$URL_SEQ\" SIZE=$FieldLength VALUE=\"$URL_FULL\">";
	}
	echo "</TD></TR>\n";

	echo "<TR><TD>";
	$URL_FULL = $URL04;
	$URL_SEQ++;
	$URL = preg_split("/=/", "$URL_FULL");
	$URL_TAG = "META_LINK_$URL[0]";
	unset($URL[0]);
	$URL_VALUE = implode("=", $URL);
	if ( $URL_VALUE ) {
		if ( "$PrimaryLink" == "$URL_TAG" ) { $CheckMark = "CHECKED=\"yes\""; }
		echo "<A HREF=\"$URL_VALUE\" TARGET=\"_blank\">URL Pair $URL_SEQ:</A></TD><TD><INPUT TYPE=\"text\" NAME=\"form_url$URL_SEQ\" SIZE=$FieldLength VALUE=\"$URL_FULL\">";
		echo "<INPUT TYPE=\"radio\" NAME=\"form_plink\" VALUE=\"$URL_TAG\" $CheckMark>";
		$CheckMark = '';
	} else {
		echo "URL Pair $URL_SEQ:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_url$URL_SEQ\" SIZE=$FieldLength VALUE=\"$URL_FULL\">";
	}
	echo "</TD></TR>\n";

	echo "<TR><TD>";
	$URL_FULL = $URL05;
	$URL_SEQ++;
	$URL = preg_split("/=/", "$URL_FULL");
	$URL_TAG = "META_LINK_$URL[0]";
	unset($URL[0]);
	$URL_VALUE = implode("=", $URL);
	if ( $URL_VALUE ) {
		if ( "$PrimaryLink" == "$URL_TAG" ) { $CheckMark = "CHECKED=\"yes\""; }
		echo "<A HREF=\"$URL_VALUE\" TARGET=\"_blank\">URL Pair $URL_SEQ:</A></TD><TD><INPUT TYPE=\"text\" NAME=\"form_url$URL_SEQ\" SIZE=$FieldLength VALUE=\"$URL_FULL\">";
		echo "<INPUT TYPE=\"radio\" NAME=\"form_plink\" VALUE=\"$URL_TAG\" $CheckMark>";
		$CheckMark = '';
	} else {
		echo "URL Pair $URL_SEQ:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_url$URL_SEQ\" SIZE=$FieldLength VALUE=\"$URL_FULL\">";
	}
	echo "</TD></TR>\n";

	echo "<TR><TD>Modified:</TD><TD>$Modified</TD></TR>\n";
	echo "</TABLE>\n\n";
	echo "</TR><TR>\n";
	echo "<TD ALIGN=\"center\" COLSPAN=2>Notes:&nbsp;&nbsp;<TEXTAREA NAME=\"form_notes\" COLS=$NotesLength ROWS=3>$Notes</TEXTAREA></TD>";
	echo "</TR>\n";

	if ( $UpdatedOnce > 0 ) { $Action = "Return to List"; } else { $Action = "Cancel"; }
	//echo "<!-- Variable: UpdatedOnce     = $UpdatedOnce -->\n";
	//echo "<!-- Variable: Action          = $Action -->\n";

	echo "<TR><TD COLSPAN=2>&nbsp;</TD></TR>\n";
	echo "<TR ALIGN=\"center\"><TD COLSPAN=2>\n";
	echo "<INPUT TYPE=\"BUTTON\" VALUE=\"Help\" ONCLICK=\"window.open('help-pattern-edit.html','_pat-edit-help')\">&nbsp;&nbsp;\n";
	echo "<INPUT TYPE=\"BUTTON\" VALUE=\"$Action\" ONCLICK=\"window.close()\">&nbsp;&nbsp;\n";
	echo "<INPUT TYPE=\"submit\" NAME=\"update-sdp\" ID=\"update-sdp\" VALUE=\"Update Pattern\">&nbsp;&nbsp;\n";
	switch ($Status) {
	case "Proposed":
		break;
	default:
		echo "<INPUT TYPE=\"BUTTON\" VALUE=\"Generate Template\" ONCLICK=\"window.open('template-generator.php?pid=$PatternID','_pat-gen')\">&nbsp;&nbsp;\n";
	}
	switch ($PatternType) {
	case "Python":
		echo "<INPUT TYPE=\"BUTTON\" VALUE=\"Python Documentation\" ONCLICK=\"window.open('docs-python.html','_docs-python')\">\n";
		break;
	case "Perl":
		echo "<INPUT TYPE=\"BUTTON\" VALUE=\"Perl Documentation\" ONCLICK=\"window.open('docs-perl.html','_docs-perl')\">\n";
		break;
	}

	echo "</TD></TR>\n";
	echo "</TABLE>\n";
	echo "</FORM>\n";
	}
?>

</BODY>
</HTML>

