<?PHP //echo "<!-- Modified: Date       = 2014 Jun 10 -->\n"; ?>
<!--
<?PHP include 'checklogin.php';?>
-->
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
<LINK REL="stylesheet" HREF="style.css">
<TITLE>Pattern Summary</TITLE>
</HEAD>
<BODY BGPROPERTIES=FIXED BGCOLOR=#FFFFFF TEXT=#000000>
<H2 ALIGN="center">Pattern Summary</H2>
<TABLE CELLPADDING=2 ALIGN="center" WIDTH="25%">

<?PHP
$OrderBy = $_GET['by'];
$OrderDir = $_GET['dir'];
$ToggleDir = $_GET['td'];
$Filter = $_GET['filter'];
$Check = $_GET['ck'];

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
$Connection = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($Connection->connect_errno) {
	echo "<P CLASS=\"head_1\" ALIGN=\"center\">SDP Database Summary</P>\n";
	echo "<H2 ALIGN=\"center\">Connect to Database: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
	echo "<P ALIGN=\"center\">Make sure the MariaDB database is configured properly.</P>\n";
	echo "</BODY>\n</HTML>\n";
	die();
}

// Get the total number of patterns
$Query = "SELECT Count(PatternID) FROM $TableName";
//echo "<!-- Query: Submitted          = $Query -->\n";
$Result = $Connection->query($Query);
$Num = $Result->num_rows;
if ( $Result ) {
	//echo "<!-- Query: Result             = Success -->\n";
	//echo "<!-- Query: Rows               = $Num -->\n";
} else {
	//echo "<!-- Query: Result             = FAILURE -->\n";
}
$Row_Cell = $Result->fetch_row();
$TotalPatterns = htmlspecialchars($Row_Cell[0]);
echo "<TR CLASS=\"head_2\"><TD>Total Patterns</TD><TD>$TotalPatterns</TD><TR>\n";
$Result->close();

// Count the patterns grouped by Status
$Query = "SELECT Status, Count(Status) FROM $TableName GROUP BY Status";
//echo "<!-- Query: Submitted          = $Query -->\n";
$Result = $Connection->query($Query);
$Num = $Result->num_rows;
if ( $Result ) {
	//echo "<!-- Query: Result             = Success -->\n";
	//echo "<!-- Query: Rows               = $Num -->\n";
} else {
	//echo "<!-- Query: Result             = FAILURE -->\n";
}
echo "<TR CLASS=\"head_2\"><TD COLSPAN=\"2\" ALIGN=\"center\">Count by Status</TD></TR>\n";
$i=0;
while ( $Row_Cell = $Result->fetch_row() ) {
	$Key				= htmlspecialchars($Row_Cell[0]);
	$Key_Count		= htmlspecialchars($Row_Cell[1]);
	if ( $i%2 == 0 ) { $Row_Color="tdGrey"; } else { $Row_Color="tdGreyLight"; }
	echo "<TR CLASS=\"$Row_Color\"><TD>$Key</TD><TD>$Key_Count</TD><TR>\n";
	$i++;
}
$Result->close();

// Count the patterns grouped by Class
$Query = "SELECT Class, Count(Class) FROM $TableName GROUP BY Class";
//echo "<!-- Query: Submitted          = $Query -->\n";
$Result = $Connection->query($Query);
$Num = $Result->num_rows;
if ( $Result ) {
	//echo "<!-- Query: Result             = Success -->\n";
	//echo "<!-- Query: Rows               = $Num -->\n";
} else {
	//echo "<!-- Query: Result             = FAILURE -->\n";
}
echo "<TR CLASS=\"head_2\"><TD COLSPAN=\"2\" ALIGN=\"center\">Count by Class</TD></TR>\n";
$i=0;
while ( $Row_Cell = $Result->fetch_row() ) {
	$Key				= htmlspecialchars($Row_Cell[0]);
	$Key_Count		= htmlspecialchars($Row_Cell[1]);
	if ( $i%2 == 0 ) { $Row_Color="tdGrey"; } else { $Row_Color="tdGreyLight"; }
	echo "<TR CLASS=\"$Row_Color\"><TD>$Key</TD><TD>$Key_Count</TD><TR>\n";
	$i++;
}
$Result->close();

// Count the patterns grouped by Type
$Query = "SELECT PatternType, Count(PatternType) FROM $TableName GROUP BY PatternType";
//echo "<!-- Query: Submitted          = $Query -->\n";
$Result = $Connection->query($Query);
$Num = $Result->num_rows;
if ( $Result ) {
	//echo "<!-- Query: Result             = Success -->\n";
	//echo "<!-- Query: Rows               = $Num -->\n";
} else {
	//echo "<!-- Query: Result             = FAILURE -->\n";
}
echo "<TR CLASS=\"head_2\"><TD COLSPAN=\"2\" ALIGN=\"center\">Count by Pattern Type</TD></TR>\n";
$i=0;
while ( $Row_Cell = $Result->fetch_row() ) {
	$Key				= htmlspecialchars($Row_Cell[0]);
	$Key_Count		= htmlspecialchars($Row_Cell[1]);
	if ( $i%2 == 0 ) { $Row_Color="tdGrey"; } else { $Row_Color="tdGreyLight"; }
	echo "<TR CLASS=\"$Row_Color\"><TD>$Key</TD><TD>$Key_Count</TD><TR>\n";
	$i++;
}
$Result->close();

echo "<FORM>";
$Connection->close();
echo "<TR CLASS=\"head_2\"><TD COLSPAN=\"2\" ALIGN=\"center\"><INPUT TYPE=\"BUTTON\" VALUE=\"Close\" ONCLICK=\"window.location.href='patterns.php?by=$OrderBy&dir=$OrderDir&td=0&filter=$Filter&ck=$Check'\"></TD></TR>\n";
?> 
</FORM>
</TABLE>
</BODY>
</HTML>

