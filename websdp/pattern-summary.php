<!-- Modified: Date            = 2014 Jan 22 -->
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
		case 0:
		case 1:
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
		case 0:
		case 1:
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

include 'db-config.php';
include 'db-open.php';

// Get the total number of patterns
$Query = "SELECT Count(PatternID) FROM $TableName";
//echo "<!-- Query: Submitted          = $Query -->\n";
$Result = mysql_query($Query);
$Num = mysql_numrows($Result);
if ( $Result ) {
	//echo "<!-- Query: Result             = Success -->\n";
	//echo "<!-- Query: Rows               = $Num -->\n";
} else {
	//echo "<!-- Query: Result             = FAILURE -->\n";
}
$Row_Cell = mysql_fetch_row($Result);
$TotalPatterns = $Row_Cell[0];
echo "<TR CLASS=\"head_2\"><TD>Total Patterns</TD><TD>$TotalPatterns</TD><TR>\n";

// Count the patterns grouped by Status
$Query = "SELECT Status, Count(Status) FROM $TableName GROUP BY Status";
//echo "<!-- Query: Submitted          = $Query -->\n";
$Result = mysql_query($Query);
$Num = mysql_numrows($Result);
if ( $Result ) {
	//echo "<!-- Query: Result             = Success -->\n";
	//echo "<!-- Query: Rows               = $Num -->\n";
} else {
	//echo "<!-- Query: Result             = FAILURE -->\n";
}
echo "<TR CLASS=\"head_2\"><TD COLSPAN=\"2\" ALIGN=\"center\">Count by Status</TD></TR>\n";
for ( $i=0; $i < $Num; $i++ ) {
	$Row_Cell		= mysql_fetch_row($Result);
	$Key				= htmlspecialchars($Row_Cell[0]);
	$Key_Count		= htmlspecialchars($Row_Cell[1]);
	if ( $i%2 == 0 ) { $Row_Color="tdGrey"; } else { $Row_Color="tdGreyLight"; }
	echo "<TR CLASS=\"$Row_Color\"><TD>$Key</TD><TD>$Key_Count</TD><TR>\n";
}

// Count the patterns grouped by Class
$Query = "SELECT Class, Count(Class) FROM $TableName GROUP BY Class";
//echo "<!-- Query: Submitted          = $Query -->\n";
$Result = mysql_query($Query);
$Num = mysql_numrows($Result);
if ( $Result ) {
	//echo "<!-- Query: Result             = Success -->\n";
	//echo "<!-- Query: Rows               = $Num -->\n";
} else {
	//echo "<!-- Query: Result             = FAILURE -->\n";
}
echo "<TR CLASS=\"head_2\"><TD COLSPAN=\"2\" ALIGN=\"center\">Count by Class</TD></TR>\n";
for ( $i=0; $i < $Num; $i++ ) {
	$Row_Cell		= mysql_fetch_row($Result);
	$Key				= htmlspecialchars($Row_Cell[0]);
	$Key_Count		= htmlspecialchars($Row_Cell[1]);
	if ( $i%2 == 0 ) { $Row_Color="tdGrey"; } else { $Row_Color="tdGreyLight"; }
	echo "<TR CLASS=\"$Row_Color\"><TD>$Key</TD><TD>$Key_Count</TD><TR>\n";
}

// Count the patterns grouped by Type
$Query = "SELECT PatternType, Count(PatternType) FROM $TableName GROUP BY PatternType";
//echo "<!-- Query: Submitted          = $Query -->\n";
$Result = mysql_query($Query);
$Num = mysql_numrows($Result);
if ( $Result ) {
	//echo "<!-- Query: Result             = Success -->\n";
	//echo "<!-- Query: Rows               = $Num -->\n";
} else {
	//echo "<!-- Query: Result             = FAILURE -->\n";
}
echo "<TR CLASS=\"head_2\"><TD COLSPAN=\"2\" ALIGN=\"center\">Count by Pattern Type</TD></TR>\n";
for ( $i=0; $i < $Num; $i++ ) {
	$Row_Cell		= mysql_fetch_row($Result);
	$Key				= htmlspecialchars($Row_Cell[0]);
	$Key_Count		= htmlspecialchars($Row_Cell[1]);
	if ( $i%2 == 0 ) { $Row_Color="tdGrey"; } else { $Row_Color="tdGreyLight"; }
	echo "<TR CLASS=\"$Row_Color\"><TD>$Key</TD><TD>$Key_Count</TD><TR>\n";
}

echo "<FORM>";
include 'db-close.php';
echo "<TR CLASS=\"head_2\"><TD COLSPAN=\"2\" ALIGN=\"center\"><INPUT TYPE=\"BUTTON\" VALUE=\"Close\" ONCLICK=\"window.location.href='patterns.php?by=$OrderBy&dir=$OrderDir&td=0&filter=$Filter&ck=$Check'\"></TD></TR>\n";
?> 
</FORM>
</TABLE>
</BODY>
</HTML>

