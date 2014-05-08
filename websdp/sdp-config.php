<?PHP //echo "<!-- Modified: Date       = 2014 May 08 -->\n"; ?>
<?PHP
	$DB_USER = 'sdpuser';
	$DB_PASS = "${DB_USER}_password";
	$DB_NAME = 'SCAPatterns';
	$TableName = 'Submissions';
	$EmailDomain = 'suse.com';
	$DB_HOST = 'localhost';
	$ResourceRefresh = 300;
	$StatsRefresh = 15;
	$StatusRefresh = 2;
	$FieldLength = 30;
	$DescLength = $FieldLength - 1;
	$NotesLength = $FieldLength * 3;
	$Company = 'SUSE LLC';	
	$Year = date('Y');
	$CurrentDate = date('Y M d');

	//echo "<!-- Config: DB_USER           = $DB_USER -->\n";
	//echo "<!-- Config: DB_NAME           = $DB_NAME -->\n";
	//echo "<!-- Config: TableName         = $TableName -->\n";
	//echo "<!-- Config: EmailDomain       = $EmailDomain -->\n";
	//echo "<!-- Config: DB_HOST           = $DB_HOST -->\n";
	//echo "<!-- Config: ResourceRefresh   = $ResourceRefresh -->\n";
	//echo "<!-- Config: StatsRefresh      = $StatsRefresh -->\n";
	//echo "<!-- Config: StatusRefresh     = $StatusRefresh -->\n";
	//echo "<!-- Config: FieldLength       = $FieldLength -->\n";
	//echo "<!-- Config: DescLength        = $DescLength -->\n";
	//echo "<!-- Config: NotesLength       = $NotesLength -->\n";
	//echo "<!-- Config: Company           = $Company -->\n";
	//echo "<!-- Config: Year              = $Year -->\n";
	//echo "<!-- Config: CurrentDate       = $CurrentDate -->\n";
	//echo "<!-- Config: Internal          = $Internal -->\n\n";
?>
