<?PHP //echo "<!-- Modified: Date       = 2014 May 15 -->\n"; ?>
<?PHP include 'checklogin.php';?>
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
<LINK REL="stylesheet" HREF="style.css">

<?PHP
	$PageFunction = "Add";
	$Submitted = date('Y\-m\-d');
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


include 'sdp-config.php';

if (isset($_POST['add-sdp'])) {
	$Connection = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	if ($Connection->connect_errno) {
		echo "</HEAD>\n";
		echo "<BODY>\n";
		echo "<P CLASS=\"head_1\" ALIGN=\"center\">$PageTitle</P>\n";
		echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
		echo "<H2 ALIGN=\"center\">Add Pattern: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\"><B>ERROR:</B> Failed to connect to database.</P>\n";
		echo "<P ALIGN=\"center\">Make sure the database is setup and configured properly.</P>\n";
		die();
	}
	if (!($Statement = $Connection->prepare("INSERT INTO $TableName VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"))) {
		echo "</HEAD>\n";
		echo "<BODY>\n";
		echo "<P CLASS=\"head_1\" ALIGN=\"center\">$PageTitle</P>\n";
		echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
		echo "<H2 ALIGN=\"center\">Prepare: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\"><B>ERROR(" . $Connection->errno . "):</B> " . $Connection->error . "</P>\n";
		die();
	}
//	if (!($Statement->bind_param('issssssssssssssssssssssssssss', $PatternID,'$Title',$Description,'$Class','$Category','$Component',$Notes,$PatternFile,'$PatternType','$Submitted','$Modified',$Released,'$Submitter',$Owner,$PrimaryLink,$TID,$BUG,$URL01,$URL02,$URL03,$URL04,$URL05,$URL06,$URL07,$URL08,$URL09,$URL10,'$Status'))) {
	if (!($Statement->bind_param('isssssssssssssssssssssssssss', $PatternID,$Title,$Description,$Class,$Category,$Component,$Notes,$PatternFile,$PatternType,$Submitted,$Modified,$Released,$Submitter,$Owner,$PrimaryLink,$TID,$BUG,$URL01,$URL02,$URL03,$URL04,$URL05,$URL06,$URL07,$URL08,$URL09,$URL10,$Status))) {
		echo "</HEAD>\n";
		echo "<BODY>\n";
		echo "<P CLASS=\"head_1\" ALIGN=\"center\">$PageTitle</P>\n";
		echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
		echo "<H2 ALIGN=\"center\">Bind Parameters: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\"><B>ERROR(" . $Statement->errno . "):</B> " . $Statement->error . "</P>\n";
		die();
	}

//	$Statement->bind_param('issssssssssssssssssssssssssss', )
//$stmt = $mysqli->prepare("INSERT INTO SampleTable VALUES (?)");
//$stmt->bind_param('s', $sample);   // bind $sample to the parameter

//$Query = "INSERT INTO $TableName VALUES ($PatternID,'$Title',$Description,'$Class','$Category','$Component',$Notes,$PatternFile,
//'$PatternType','$Submitted','$Modified',$Released,'$Submitter',$Owner,$PrimaryLink,$TID,$BUG,
//$URL01,$URL02,$URL03,$URL04,$URL05,$URL06,$URL07,$URL08,$URL09,$URL10,'$Status')";
	$PatternID     = 0;
	$Title 			= $Connection->real_escape_string($_POST['form_title']);
	$Description 	= $Connection->real_escape_string($_POST['form_description']);
	$Class 			= $Connection->real_escape_string($_POST['form_class']);
	$Category 		= $Connection->real_escape_string($_POST['form_category']);
	$Component 		= $Connection->real_escape_string($_POST['form_component']);
	$Notes 			= $Connection->real_escape_string($_POST['form_notes']);
	$PatternFile 	= $Connection->real_escape_string($_POST['form_pattern_file']);
	$PatternType 	= $Connection->real_escape_string($_POST['form_pattern_type']);
//	$Submitted     = date('Y\-m\-d'); # Must be set above
	$Modified 		= $Submitted;
	$Released 		= NULL;
	$Submitter 		= $Connection->real_escape_string($_POST['form_submitter']);
	$Owner 			= $Connection->real_escape_string($_POST['form_owner']);
	$TID 				= $_POST['form_tid'];
	$BUG 				= $_POST['form_bug'];
	$URL01 			= $_POST['form_url1'];
	$URL02 			= $_POST['form_url2'];
	$URL03 			= $_POST['form_url3'];
	$URL04 			= $_POST['form_url4'];
	$URL05 			= $_POST['form_url5'];
	$URL06 			= 'NULL';
	$URL07 			= 'NULL';
	$URL08 			= 'NULL';
	$URL09 			= 'NULL';
	$URL10 			= 'NULL';
	$Status 			= $_POST['form_status'];
	if ( strlen($TID) > 0 ) { $PrimaryLink = "'META_LINK_TID'"; }
	elseif ( strlen($BUG) > 0 ) { $PrimaryLink = "'META_LINK_BUG'"; }
	elseif ( strlen($URL01) > 0 ) { $URL = preg_split("/=/", "$URL01"); $PrimaryLink = "'META_LINK_$URL[0]'"; }
	elseif ( strlen($URL02) > 0 ) { $URL = preg_split("/=/", "$URL02"); $PrimaryLink = "'META_LINK_$URL[0]'"; }
	elseif ( strlen($URL03) > 0 ) { $URL = preg_split("/=/", "$URL03"); $PrimaryLink = "'META_LINK_$URL[0]'"; }
	elseif ( strlen($URL04) > 0 ) { $URL = preg_split("/=/", "$URL04"); $PrimaryLink = "'META_LINK_$URL[0]'"; }
	elseif ( strlen($URL05) > 0 ) { $URL = preg_split("/=/", "$URL05"); $PrimaryLink = "'META_LINK_$URL[0]'"; }
	else { $PrimaryLink = 'NULL'; }

	$Connection->query("LOCK TABLES $TableName WRITE") or die("<FONT SIZE=\"-1\"><B>ERROR</B>: Database: Table $TableName Lock -> <B>FAILED</B></FONT><BR>\n");
//	echo "<!-- Database: Table           = Locked $TableName -->\n";

	if ( $Title && $Submitter && $Category && $Component ) {
		if ( $Status == "Complete" && $Owner == "" ) {
			echo "</HEAD>\n";
			echo "<BODY>\n";
			echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
			echo "<H2 ALIGN=\"center\">Submit Pattern: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
			echo "<P ALIGN=\"center\"><B>ERROR:</B> No assigned owner.</P>\n";
			echo "<P ALIGN=\"center\">Click <B>back</B>, and correct.</P>\n";
		} else {
			if ( ( $Status == "Assigned" || $Status == "In-Progress" ) && $Owner == "" ) {
				$Owner = "$Submitter";
				$Owner2submitter = 1;
				$LocalRefresh = $StatusRefresh * 3;
//				echo "<!-- Override: Owner           = $Owner -->\n";
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
			if( strlen($Description) > 0 ) { $Description = "'$Description'"; } else { $Description = 'NULL'; }
			if( strlen($Notes) > 0 ) { $Notes = "'$Notes'"; } else { $Notes = 'NULL'; }
			if( strlen($PatternFile) > 0 ) { $PatternFile = "'$PatternFile'"; } else { $PatternFile = 'NULL'; }
			if( strlen($Owner) > 0 ) { $Owner = "'$Owner'"; } else { $Owner = 'NULL'; }
			if( strlen($TID) > 0 ) { $TID = "'$TID'"; } else { $TID = 'NULL'; }
			if( strlen($BUG) > 0 ) { $BUG = "'$BUG'"; } else { $BUG = 'NULL'; }
			if( strlen($URL01) > 0 ) { $URL01 = "'$URL01'"; } else { $URL01 = 'NULL'; }
			if( strlen($URL02) > 0 ) { $URL02 = "'$URL02'"; } else { $URL02 = 'NULL'; }
			if( strlen($URL03) > 0 ) { $URL03 = "'$URL03'"; } else { $URL03 = 'NULL'; }
			if( strlen($URL04) > 0 ) { $URL04 = "'$URL04'"; } else { $URL04 = 'NULL'; }
			if( strlen($URL05) > 0 ) { $URL05 = "'$URL05'"; } else { $URL05 = 'NULL'; }
			if (!($Statement->execute())) {
				echo "</HEAD>\n";
				echo "<BODY>\n";
				echo "<P CLASS=\"head_1\" ALIGN=\"center\">$PageTitle</P>\n";
				echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
				echo "<H2 ALIGN=\"center\">Insert: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
				echo "<P ALIGN=\"center\"><B>ERROR(" . $Statement->errno . "):</B> " . $Statement->error . "</P>\n";
				die();
			}
			$Result = $Statement->get_result();
//			$Query = "INSERT INTO $TableName VALUES ($PatternID,'$Title',$Description,'$Class','$Category','$Component',$Notes,$PatternFile,'$PatternType','$Submitted','$Modified',$Released,'$Submitter',$Owner,$PrimaryLink,$TID,$BUG,$URL01,$URL02,$URL03,$URL04,$URL05,$URL06,$URL07,$URL08,$URL09,$URL10,'$Status')";
//			echo "<!-- Query: Submitted          = $Query -->\n";
//			$Result = $Connection->query($Query);
			if ($Result) {
//				echo "<!-- Query: Result             = Success -->\n";
				if ( ! isset($DEBUG) ) { echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$LocalRefresh;URL=patterns.php?by=$OrderBy&dir=$OrderDir&filter=$Filter&ck=$Check\">\n"; }
				echo "<BODY>\n";
				echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
				if ( $Owner2submitter ) {
					echo "<H2 ALIGN=\"center\"><FONT COLOR=\"blue\">Override</FONT>: Submitter Assigned to Missing Owner -> <FONT COLOR=\"blue\">Done</FONT></H2>\n";
				}
				if ( $Status2assigned ) {
					echo "<H2 ALIGN=\"center\"><FONT COLOR=\"blue\">Override</FONT>: Pre-existing Owner, Status Changed to Assigned -> <FONT COLOR=\"blue\">Done</FONT></H2>\n";
				}
				echo "<H2 ALIGN=\"center\">Submit Pattern: <FONT COLOR=\"green\">Success</FONT></H2>\n";
				$Result->close();
				$Statement->close();
			} else {
//				echo "<!-- Query: Result             = FAILED -->\n";
				echo "<BODY>\n";
				echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
				echo "<H2 ALIGN=\"center\">Submit Pattern: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
				echo "<P ALIGN=\"center\"><B>ERROR:</B> Unable to add record to database " . $Result->error . "</P>\n";
				echo "<P ALIGN=\"center\">Click <B>back</B>, and correct.</P>\n";
			}
		}
	} else {
		//echo "<!-- Variables Undefined       = Title and Submitter -->\n";
		echo "<BODY>\n";
		echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
		echo "<H2 ALIGN=\"center\">Submit Pattern: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\"><B>ERROR:</B> Missing Required Field(s).</P>\n";
		echo "<P ALIGN=\"center\">Click <B>back</B>, and correct.</P>\n";
	}

	$Connection->query("UNLOCK TABLES") or die("<FONT SIZE=\"-1\"><B>ERROR</B>: Database: Table $TableName Unlock -> <B>FAILED</B></FONT><BR>\n");
	//echo "<!-- Database: Table           = UnLocked $TableName -->\n";
	$Connection->close();
} else {
?>
</HEAD>
<BODY>

<?PHP
	echo "<H2 ALIGN=\"center\">$PageFunction</H2>\n";
?>

<FORM METHOD="post">
<TABLE ALIGN="center" BORDER=0>
<TR VALIGN="top"><TD>

<?PHP
	echo "<TABLE BORDER=0>\n";
	echo "<TR><TD>Submitter:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_submitter\" SIZE=$FieldLength><FONT COLOR=\"red\">*</FONT></TD></TR>\n";
	echo "<TR><TD>Owner:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_owner\" SIZE=$FieldLength></TD></TR>\n";
	echo "<TR><TD>Title (Max Length 60):</TD><TD><INPUT TYPE=\"text\" NAME=\"form_title\" SIZE=$FieldLength MAXLENGTH=60><FONT COLOR=\"red\">*</FONT></TD></TR>\n";
	echo "<TR><TD>Description:</TD><TD><TEXTAREA NAME=\"form_description\" COLS=$DescLength ROWS=4></TEXTAREA></TD></TR>\n";
	echo "<TR><TD>Class:</TD><TD>";
		echo "<SELECT NAME=\"form_class\" CLASS=\"text\">";
		include 'form-class.php';
	echo "</TD>";
	echo "<TR><TD>Category:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_category\" SIZE=$FieldLength><FONT COLOR=\"red\">*</FONT></TD></TR>\n";
	echo "<TR><TD>Component:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_component\" SIZE=$FieldLength><FONT COLOR=\"red\">*</FONT></TD></TR>\n";
	echo "<TR><TD>Status:</TD><TD>";
		echo "<SELECT NAME=\"form_status\" CLASS=\"text\">";
		include 'form-status-add.php';
	echo "</TD>";
	echo "</TABLE>\n";
?>

</TD><TD>

<?PHP
	echo "<TABLE BORDER=0>\n";
	echo "<TR><TD>Pattern ID:</TD><TD>Pending</TD></TR>\n";
	echo "<TR><TD>Pattern File:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_pattern_file\" SIZE=$FieldLength></TD></TR>\n";
	echo "<TR><TD>Pattern Type:</TD><TD>";
		echo "<SELECT NAME=\"form_pattern_type\" CLASS=\"text\">";
		include 'form-pattern-type.php';
	echo "</TD>";
	echo "<TR><TD>TID URL:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_tid\" SIZE=$FieldLength></TD></TR>\n";
	echo "<TR><TD>BUG URL:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_bug\" SIZE=$FieldLength></TD></TR>\n";
	echo "<TR><TD>URL Pair 1:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_url1\" SIZE=$FieldLength></TD></TR>\n";
	echo "<TR><TD>URL Pair 2:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_url2\" SIZE=$FieldLength></TD></TR>\n";
	echo "<TR><TD>URL Pair 3:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_url3\" SIZE=$FieldLength></TD></TR>\n";
	echo "<TR><TD>URL Pair 4:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_url4\" SIZE=$FieldLength></TD></TR>\n";
	echo "<TR><TD>URL Pair 5:</TD><TD><INPUT TYPE=\"text\" NAME=\"form_url5\" SIZE=$FieldLength></TD></TR>\n";
	echo "<TR><TD>Submission:</TD><TD>$Submitted</TD></TR>\n";
	echo "</TABLE>\n\n";
	echo "</TR><TR>\n";
	echo "<TD ALIGN=\"center\" COLSPAN=2>Notes:&nbsp;&nbsp;<TEXTAREA NAME=\"form_notes\" COLS=$NotesLength ROWS=3></TEXTAREA></TD>";

	echo "</TR>\n";
	echo "<TR><TD COLSPAN=2>&nbsp;</TD></TR>\n";
	echo "<TR ALIGN=\"center\"><TD COLSPAN=2>";
	echo "<INPUT TYPE=\"BUTTON\" VALUE=\"Help\" ONCLICK=\"window.open('help-pattern-add.html','_pat-add-help')\">&nbsp;&nbsp;";
	echo "<INPUT TYPE=\"BUTTON\" VALUE=\"Cancel\" ONCLICK=\"window.location.href='patterns.php?by=$OrderBy&dir=$OrderDir&filter=$Filter'\">&nbsp;&nbsp;";
	echo "<INPUT TYPE=\"submit\" NAME=\"add-sdp\" ID=\"add-sdp\" VALUE=\"Submit Pattern\">&nbsp;&nbsp;";
	echo "</TD></TR>\n";
?>

</TABLE>
</FORM>
<?PHP
}

//echo "<!-- Variable: OrderBy         = $OrderBy -->\n";
//echo "<!-- Variable: OrderDir        = $OrderDir -->\n";
//echo "<!-- Variable: ToggleDir       = $ToggleDir -->\n";
//echo "<!-- Variable: Filter          = $Filter -->\n";
//echo "<!-- Variable: PatternID       = $PatternID -->\n";
?> 

</BODY>
</HTML>

