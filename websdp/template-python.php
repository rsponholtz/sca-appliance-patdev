<?PHP //echo "<!-- Modified: Date       = 2014 Jun 30 -->\n"; ?>
<?PHP
$tmp = strtolower($Owner);
$pos = strrpos($tmp, ' ') + 1;
$Email = $tmp[0] . substr($tmp, $pos);
echo "<font style=\"courier\" size=\"-1\">\n";
echo "#!/usr/bin/python<br><br>\n";
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
echo "<br>\n";
echo "import os<br>\n";
echo "import Core<br>\n";
echo "<br>\n";
echo "##############################################################################<br>\n";
echo "# Overriden (eventually or in part) from SDP::Core Module<br>\n";
echo "##############################################################################<br>\n";
echo "<br>\n";
echo "META_CLASS = \"$Class\"<br>\n";
echo "META_CATEGORY = \"$Category\"<br>\n";
echo "META_COMPONENT = \"$Component\"<br>\n";
echo "PATTERN_ID = os.path.basename(__file__)<br>\n";
echo "PRIMARY_LINK = \"$PrimaryLink\"<br>\n";
echo "OVERALL = Core.TEMP<br>\n";
echo "OVERALL_INFO = \"NOT SET\"<br>\n";
$OTHER_LINKS='';
if ( $TID ) { 
	if ( strlen($OTHER_LINKS) > 0 ) {
		$OTHER_LINKS="${OTHER_LINKS}|META_LINK_TID=$TID";
	} else {
		$OTHER_LINKS="META_LINK_TID=$TID";
	}
}
if ( $BUG ) { 
	if ( strlen($OTHER_LINKS) > 0 ) {
		$OTHER_LINKS="${OTHER_LINKS}|META_LINK_BUG=$BUG";
	} else {
		$OTHER_LINKS="META_LINK_BUG=$BUG";
	}
}
foreach ($URLS as $URLPair ) {
	if ( strlen($URLPair) > 0 ) {
		if ( strlen($OTHER_LINKS) > 0 ) {
			$OTHER_LINKS="${OTHER_LINKS}|META_LINK_${URLPair}";
		} else {
			$OTHER_LINKS="META_LINK_${URLPair}";
		}
	}
}
echo "OTHER_LINKS = \"$OTHER_LINKS\"<br>\n";
echo "<br>\n";
echo "Core.init(META_CLASS, META_CATEGORY, META_COMPONENT, PATTERN_ID, PRIMARY_LINK, OVERALL, OVERALL_INFO, OTHER_LINKS)<br>\n";
echo "</font>\n";
?>
<pre>
##############################################################################
# Local Function Definitions
##############################################################################

def checkSomething():
	fileOpen = "filename.txt"
	section = "CommandToIdentifyFileSection"
	content = {}
	if Core.getSection(fileOpen, section, content):
		for line in content:
			if "something" in content[line]:
				return True
	return False

##############################################################################
# Main Program Execution
##############################################################################

if( checkSomething() ):
	Core.updateStatus(Core.CRIT, "A critical severity is set")
else:
	Core.updateStatus(Core.IGNORE, "Ignore this pattern, not applicable")

Core.printPatternResults()
</pre>
