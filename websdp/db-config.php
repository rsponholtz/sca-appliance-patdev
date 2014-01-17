<?PHP
	$User = 'sdpuser';
	$Password = "${User}_password";
	$Database = 'SCAPatterns';
	$TableName = 'Submissions';
	$EmailDomain = 'suse.com';
	$DBHost = 'localhost';
	$ResourceRefresh = 300;
	$StatsRefresh = 15;
	$StatusRefresh = 2;
	$FieldLength = 30;
	$DescLength = $FieldLength - 1;
	$NotesLength = $FieldLength * 3;
	$Company = 'SUSE LLC';	
	$Year = date('Y');
	$CurrentDate = date('Y M d');

	echo "<!-- Config: User              = $User -->\n";
	echo "<!-- Config: Database          = $Database -->\n";
	echo "<!-- Config: TableName         = $TableName -->\n";
	echo "<!-- Config: EmailDomain       = $EmailDomain -->\n";
	echo "<!-- Config: DBHost            = $DBHost -->\n";
	echo "<!-- Config: ResourceRefresh   = $ResourceRefresh -->\n";
	echo "<!-- Config: StatsRefresh      = $StatsRefresh -->\n";
	echo "<!-- Config: StatusRefresh     = $StatusRefresh -->\n";
	echo "<!-- Config: FieldLength       = $FieldLength -->\n";
	echo "<!-- Config: DescLength        = $DescLength -->\n";
	echo "<!-- Config: NotesLength       = $NotesLength -->\n";
	echo "<!-- Config: Company           = $Company -->\n";
	echo "<!-- Config: Year              = $Year -->\n";
	echo "<!-- Config: CurrentDate       = $CurrentDate -->\n";
	echo "<!-- Config: Internal          = $Internal -->\n\n";
?>
