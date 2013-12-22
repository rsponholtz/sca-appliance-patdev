<?PHP
$tmp = strtolower($Owner);
$pos = strrpos($tmp, ' ') + 1;
$Email = $tmp[0] . substr($tmp, $pos);
echo "<font style=\"courier\" size=\"-1\">\n";
echo "Generic Pattern Requirements<br>\n";
echo "<br>\n";
echo "Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$Title<br>\n";
echo "Description:&nbsp;$Description<br>\n";
echo "Modified:&nbsp;&nbsp;&nbsp;&nbsp;$CurrentDate<br>\n";
echo "<br>\n";
echo "Copyright (C) $Year $Company<br>\n";
echo "<br>\n";
echo "  This program is free software; you can redistribute it and/or modify<br>\n";
echo "  it under the terms of the GNU General Public License as published by<br>\n";
echo "  the Free Software Foundation; version 2 of the License.<br>\n";
echo "<br>\n";
echo "  This program is distributed in the hope that it will be useful,<br>\n";
echo "  but WITHOUT ANY WARRANTY; without even the implied warranty of<br>\n";
echo "  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the<br>\n";
echo "  GNU General Public License for more details.<br>\n";
echo "<br>\n";
echo "  You should have received a copy of the GNU General Public License<br>\n";
echo "  along with this program; if not, write to the Free Software<br>\n";
echo "  Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.<br>\n";
echo "<br>\n";
echo "&nbsp;&nbsp;Authors/Contributors:<br>\n";
echo "&nbsp;&nbsp;&nbsp;$Owner ($Email@$EmailDomain)<br>\n";
echo "<br>\n";
echo "</font>\n";
?>
<pre>
Pattern Requirements

A supportconfig diagnostic pattern has the following requirements:
1. Be executable, so bash can execute it by referencing the filename only
2. Accept a -p start up parameter with the value of the path to the extracted archive
3. Write a case sensitive, order dependent information string to stdout
4. A pattern supports a maximum of 12 solution links - one TID, one BUG and 10 custom links
5. Provide at least one solution link
6. Set the OVERALL value to 0-5, -1 being invalid
	0 = SUCCESS
	1 = RECOMMEND
	2 = PROMOTION
	3 = WARNING
	4 = CRITICAL
	5 = ERROR
7. Set the OVERALL_INFO value to the report's display string

META_CLASS=&lt;string&gt;|META_CATEGORY=&lt;string&gt;|META_COMPONENT=&lt;string&gt;|PATTERN_ID=&lt;pattern_filename&gt;|PRIMARY_LINK=META_LINK_&lt;TAG&gt;|OVERALL=[0-5]|OVERALL_INFO=&lt;message string&gt;|META_LINK_&lt;TAG&gt;=&lt;URL&gt;[|META_LINK_&lt;TAG&gt;=&lt;URL&gt;]
</pre>
<?PHP
echo "<font style=\"courier\" size=\"-1\">\n";
echo "Variable Definitions for this Pattern<br>\n";
echo "<br>\n";
echo "META_CLASS = \"$Class\"<br>\n";
echo "META_CATEGORY = \"$Category\"<br>\n";
echo "META_COMPONENT = \"$Component\"<br>\n";
echo "PATTERN_ID = $PatternFile<br>\n";
echo "PRIMARY_LINK = \"$PrimaryLink\"<br>\n";
echo "OVERALL = \"-1\"<br>\n";
echo "OVERALL_INFO = \"NOT SET\"<br>\n";
if ( $TID ) { echo "META_LINK_TID = \"$TID\"<br>\n"; }
if ( $BUG ) { echo "META_LINK_BUG =\"$BUG\"<br>\n"; }
foreach ($URLS as $URLPair ) {
	if ( strlen($URLPair) > 0 ) {
		$URL = preg_split("/=/", "$URLPair");
		$URL_TAG = "META_LINK_$URL[0]";
		unset($URL[0]);
		$URL_VALUE = implode("=", $URL);
		echo "$URL_TAG = \"$URL_VALUE\"<br>\n";
	}
}
echo "</font>\n";
?>

