<?PHP //echo "<!-- Modified: Date       = 2014 Jun 30 -->\n"; ?>
<?PHP
$tmp = strtolower($Owner);
$pos = strrpos($tmp, ' ') + 1;
$Email = $tmp[0] . substr($tmp, $pos);
echo "<font style=\"courier\" size=\"-1\">\n";
echo "#!/usr/bin/perl<br><br>\n";
echo "# Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$Title<br>\n";
echo "# Description:&nbsp;$Description<br>\n";
echo "# Modified:&nbsp;&nbsp;&nbsp;&nbsp;$CurrentDate<br>\n";
echo "#<br>\n";
echo "##############################################################################<br>\n";
echo "#  Copyright (C) $Year $Company<br>\n";
echo "##############################################################################<br>\n";
echo "#<br>\n";
echo "#  This program is free software; you can redistribute it and/or modify<br>\n";
echo "#  it under the terms of the GNU General Public License as published by<br>\n";
echo "#  the Free Software Foundation; version 2 of the License.<br>\n";
echo "#<br>\n";
echo "#  This program is distributed in the hope that it will be useful,<br>\n";
echo "#  but WITHOUT ANY WARRANTY; without even the implied warranty of<br>\n";
echo "#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the<br>\n";
echo "#  GNU General Public License for more details.<br>\n";
echo "#<br>\n";
echo "#  You should have received a copy of the GNU General Public License<br>\n";
echo "#  along with this program; if not, see &lt;http://www.gnu.org/licenses/&gt;.<br>\n";
echo "#<br>\n";
echo "#&nbsp;&nbsp;Authors/Contributors:<br>\n";
if ( strlen($EmailDomain) > 0 ) {
	echo "#&nbsp;&nbsp;&nbsp;$Owner ($Email@$EmailDomain)<br>\n";
} else {
	echo "#&nbsp;&nbsp;&nbsp;$Owner<br>\n";
}
echo "#<br>\n";
echo "##############################################################################<br>\n";
echo "<br>\n";
echo "##############################################################################<br>\n";
echo "# Module Definition<br>\n";
echo "##############################################################################<br>\n";
echo "use strict;<br>\n";
echo "use warnings;<br>\n";
echo "use SDP::Core;<br>\n";
echo "use SDP::SUSE;<br>\n";
echo "<br>\n";
echo "##############################################################################<br>\n";
echo "# Overriden (eventually or in part) from SDP::Core Module<br>\n";
echo "##############################################################################<br>\n";
echo "<br>\n";
echo "@PATTERN_RESULTS = (<br>\n";
echo "\"META_CLASS=$Class\",<br>\n";
echo "\"META_CATEGORY=$Category\",<br>\n";
echo "\"META_COMPONENT=$Component\",<br>\n";
echo "\"PATTERN_ID=\$PATTERN_ID\",<br>\n";
echo "\"PRIMARY_LINK=$PrimaryLink\",<br>\n";
echo "\"OVERALL=\$GSTATUS\",<br>\n";
echo "\"OVERALL_INFO=NOT SET\",<br>\n";
if ( $TID ) { echo "\"META_LINK_TID=$TID\",<br>\n"; }
if ( $BUG ) { echo "\"META_LINK_BUG=$BUG\",<br>\n"; }
foreach ($URLS as $URLPair ) {
	if ( strlen($URLPair) > 0 ) {
		$URL = preg_split("/=/", "$URLPair");
		$URL_TAG = "META_LINK_$URL[0]";
		unset($URL[0]);
		$URL_VALUE = implode("=", $URL);
		echo "\"$URL_TAG=$URL_VALUE\",<br>\n";
	}
}
echo ");<br>\n";
echo "</font>\n";
?>
<pre>
##############################################################################
# Local Function Definitions
##############################################################################

sub checkSomething {
	SDP::Core::printDebug('> checkSomething', 'BEGIN');
	my $RCODE = 0;
	my @LINE_CONTENT = ();
	my $FILE_OPEN = 'filename.txt';
	my $SECTION = 'CommandToIdentifyFileSection';
	my @CONTENT = ();

	if ( SDP::Core::getSection($FILE_OPEN, $SECTION, \@CONTENT) ) {
		foreach $_ (@CONTENT) {
			next if ( m/^\s*$/ ); # Skip blank lines
			if ( /^SearchForThisContentAtBeginningofLine/ ) {
				SDP::Core::printDebug("MATCHED", $_);
				@LINE_CONTENT = split(/\s+/, $_);
				$RCODE++;
				last;
			}
		}
	} else {
		SDP::Core::updateStatus(STATUS_ERROR, "ERROR: checkSomething(): Cannot find \"$SECTION\" section in $FILE_OPEN");
	}
	SDP::Core::printDebug("< checkSomething", "Returns: $RCODE");
	return $RCODE;
}

##############################################################################
# Main Program Execution
##############################################################################

SDP::Core::processOptions();
if ( checkSomething() ) {
	SDP::Core::updateStatus(STATUS_CRITICAL, "A critical severity is set");
} else {
	SDP::Core::updateStatus(STATUS_ERROR, "Pattern does not apply");
}
SDP::Core::printPatternResults();
exit;
</pre>
