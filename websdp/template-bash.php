<?PHP
$tmp = strtolower($Owner);
$pos = strrpos($tmp, ' ') + 1;
$Email = $tmp[0] . substr($tmp, $pos);
echo "<font style=\"courier\" size=\"-1\">\n";
echo "#!/bin/bash<br><br>\n";
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
echo "#  along with this program; if not, write to the Free Software<br>\n";
echo "#  Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.<br>\n";
echo "#<br>\n";
echo "#&nbsp;&nbsp;Authors/Contributors:<br>\n";
echo "#&nbsp;&nbsp;&nbsp;$Owner ($Email@$EmailDomain)<br>\n";
echo "#<br>\n";
echo "##############################################################################<br>\n";
echo "<br>\n";
echo "##############################################################################<br>\n";
echo "# Module Definition<br>\n";
echo "##############################################################################<br>\n";
echo "<br>\n";
echo "LIBS='Core.rc SUSE.rc'<br>\n";
echo "for LIB in \$LIBS; do [[ -s \${BASHLIB}/\${LIB} ]] && . \${BASHLIB}/\${LIB} || { echo \"Error: Library not found - \${BASHLIB}/\${LIB}\"; exit 5; }; done<br>\n";
echo "<br>\n";
echo "##############################################################################<br>\n";
echo "# Overriden (eventually or in part) from SDP::Core Module<br>\n";
echo "##############################################################################<br>\n";
echo "<br>\n";
echo "PATTERN_RESULTS=( \\<br>\n";
echo "\"META_CLASS=$Class\" \\<br>\n";
echo "\"META_CATEGORY=$Category\" \\<br>\n";
echo "\"META_COMPONENT=$Component\" \\<br>\n";
echo "\"PATTERN_ID=\$(basename \$0)\" \\<br>\n";
echo "\"PRIMARY_LINK=$PrimaryLink\" \\<br>\n";
echo "\"OVERALL=\$GSTATUS\" \\<br>\n";
echo "\"OVERALL_INFO=None\" \\<br>\n";
if ( $TID ) { echo "\"META_LINK_TID=$TID\" \\<br>\n"; }
if ( $BUG ) { echo "\"META_LINK_BUG=$BUG\" \\<br>\n"; }
foreach ($URLS as $URLPair ) {
	if ( strlen($URLPair) > 0 ) {
		$URL = preg_split("/=/", "$URLPair");
		$URL_TAG = "META_LINK_$URL[0]";
		unset($URL[0]);
		$URL_VALUE = implode("=", $URL);
		echo "\"$URL_TAG=$URL_VALUE\" \\<br>\n";
	}
}
echo ")<br>\n";
echo "<br>\n";
echo "</font>\n";
?>
<pre>
##############################################################################
# Local Function Definitions
##############################################################################

function checkSomething() {
	printDebug '> checkSomething'
	RC=0
	HEADER_LINES=0
	LINE=''
	FILE_OPEN='filename.txt'
	SECTION='CommandToIdentifyFileSection'

	getSection "$FILE_OPEN" "$SECTION" $HEADER_LINES
	if (( $? ))
	then
		LINE=$(echo "$CONTENT" | egrep 'SearchForThisContentInLine')
		if [[ -n "$LINE" ]]
		then
			printDebug '  checkSomething FOUND' "$LINE"
			((RC++))
		fi
	else
		updateStatus $STATUS_ERROR "ERROR: checkSomething: Cannot fine '$SECTION' section in $FILE_OPEN"
	fi
	printDebug '< checkSomething' "Returns: $RC"
	return $RC
}

##############################################################################
# Main Program Execution
##############################################################################

processOptions "$@"
checkSomething
if (( $? ))
then
	updateStatus $STATUS_CRITICAL "A critical severity is set"
else
	updateStatus $STATUS_ERROR "The pattern does not apply"
fi
printPatternResults
</pre>
