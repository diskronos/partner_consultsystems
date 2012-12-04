<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Ajex.FileManager v1.0.3</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name="author" content="Demphest Gorphek" />
		<meta name="copyright" content="© 2009 demphest.ru" />
		<link type="text/css" href="lib/dynatree/skin/ui.dynatree.css" rel="stylesheet" />
		<script type="text/javascript" src="lib/jquery.js"></script>
		<script type="text/javascript" src="lib/jquery-ui.js"></script>
		<script type="text/javascript" src="lib/jquery.form.js"></script>
		<script type="text/javascript" src="lib/jquery.cookie.js"></script>
		<script type="text/javascript" src="lib/jquery.MultiFile.js"></script>
		<script type="text/javascript" src="lib/ajex.filemanager.js"></script>
		<script type="text/javascript" src="lib/dynatree/jquery.dynatree.js"></script>
	</head>
<body>

<div id="dirs">
	<div class="dirsMenu">
		<div class="about"><a href="">About</a></div>
		<div class="folderMenu"></div>
	</div>
	<div id="dirsList"></div>
	<form id="filesUploadForm" action="" enctype="multipart/form-data">
	<input type="hidden" name="dir" value="" />
	<input type="hidden" name="type" value="file" />
	<div id="uploadList">
		<div class="selectLang"><span lang="chooseFileUpload">Choose file</span></div>
		<div class="selectFile"><div><input type="file" name="uploadFiles[]" class="multi" /></div></div>
	</div>
	<div class="resizeGraph">
		<span lang="resizeGraph">Resize graphics files to</span>:<br />
		<span lang="width" class="txtBlock">Width</span>: <input type="text" id="resizeWidth" name="resizeWidth" value="" />
		<span lang="or">or</span><br />
		<span lang="height" class="txtBlock">Height</span>: <input type="text" id="resizeHeight" name="resizeHeight" value="" />
	</div>
	</form>
</div>
<div id="files">
	<div id="menu">
		<div class="view">
			<span lang="view">View:</span>
			<label for="viewlist"><input type="radio" id="viewlist" name="view" value="" /> <span lang="list">List</span></label>
			<label for="viewthumb"><input type="radio" id="viewthumb" name="view" value="" checked="checked" /> <span lang="images">Images</span></label>
		</div>
		<div class="display">
			<!--span lang="display">Display:</span-->
			<label for="fileName"><input type="checkbox" id="fileName" name="fileName" value="" checked="checked" /> <span lang="fileName">File Name</span> </label>
			<label for="fileDate"><input type="checkbox" id="fileDate" name="fileDate" value="" /> <span lang="fileDate">Date</span> </label>
			<label for="fileSize"><input type="checkbox" id="fileSize" name="fileSize" value="" /> <span lang="fileSize">Size</span></label>
		</div>
		<div class="sort">
			<span lang="sort">Sort:</span>
			<label for="sortName"><input type="radio" id="sortName" name="sort" value="" checked="checked" /> <span lang="sortName">Name</span> </label>
			<label for="sortDate"><input type="radio" id="sortDate" name="sort" value="" /> <span lang="sortDate">Date</span> </label>
			<label for="sortSize"><input type="radio" id="sortSize" name="sort" value="" /> <span lang="sortSize">Size</span></label>
		</div>
	</div>
	<div id="fileList">
		<table>
			<thead>
				<tr>
					<td><input type="checkbox" id="checkAll" name="checkAll" value="1" /></td>
					<td><span lang="fileName">File Name</span></td>
					<td><span lang="fileDate">Date</span></td>
					<td><span lang="fileSize">Size</span></td>
				</tr>
			</thead>
			<tbody></tbody>
			<tfoot></tfoot>
		</table>
	</div>
	<div id="fileThumb"></div>
</div>
<div id="status"><div class="l"></div><div id="loading"></div><div class="r"><div></div></div></div>
<div id="dialog" title=""><div class="c"></div></div>
<div id="dowloaded"></div>

<div id="author"><div>
<strong>Author Demphest Gorphek (<a href="http://demphest.ru/ajex-filemanager">demphest.ru</a>)</strong>
<br />
<br />In the process of creation used the following components, for which it separate thanks ;-)
<br /><br />
<ul>
	<li>jQuery (<a href="http://jquery.com/">jquery.com</a>)
		<ul>
			<li>jQuery UI (<a href="http://jqueryui.com/about">jqueryui.com</a>)</li>
			<li>jquery.dynatree - Martin Wendt (<a href="http://wwWendt.de">wwWendt.de</a>)</li>
			<li>jquery.contextmenu - Matt Kruse (<a href="http://www.JavascriptToolbox.com/lib/contextmenu/">JavascriptToolbox.com</a>)</li>
			<li>jquery.cookie - Klaus Hartl (<a href="http://stilbuero.de">stilbuero.de</a>)</li>
			<li>jquery.multifile - Fyneworks.com (<a href="http://www.fyneworks.com/">fyneworks.com</a>)</li>
			<li>jquery.form - Form Plugin (<a href="http://malsup.com/jquery/form/">malsup.com</a>)</li>
		</ul>
	</li>
	<li>Jordan Michael - "120 different file extension icons" (<a href="http://www.jordan-michael.com">jordan-michael.com</a>)</li>
	<li>Mark James - "Icons used in menu" (<a href="http://www.famfamfam.com/">famfamfam.com</a>)</li>
</ul>
</div></div>

</body>
</html>