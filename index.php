<?php

require_once("config.inc.php");
require_once("functions.inc.php");


$theme = $omv_theme;

$manga = null;
$manga_escaped = null;

$chapter = null;
$chapter_number = null;
$chapter_number_escaped = null;
$previous_chapter = null;
$next_chapter = null;

$page = null;

$description = "";
$title = $omv_title;

$mangas = omv_get_mangas();
if (isset($_GET["manga"])) {
	$manga_title = omv_decode($_GET["manga"]);
	if (in_array($manga_title, $mangas)) {
		$manga = $manga_title;
		$manga_escaped = $_GET["manga"];
	}
}

if ($manga) {
	$description = "Read " . $manga . " Manga Online";
	$title .= " - " . $manga;

	$chapters = omv_get_chapters($manga);
	if (isset($_GET["chapter"])) {
		$chapter_number = omv_decode($_GET["chapter"]);
		$index = omv_get_chapter_index($chapters, $chapter_number);
		if ($index != -1) {
			$chapter = $chapters[$index];
			$chapter_number_escaped = $_GET["chapter"];
			if ($omv_chapters_sorting == SORT_ASC) {
				if ($index > 0) {
					$previous_chapter = $chapters[$index - 1];
				}
				if ($index < (count($chapters) -  1)) {
					$next_chapter = $chapters[$index + 1];
				}
			} else {
				if ($index < (count($chapters) -  1)) {
					$previous_chapter = $chapters[$index + 1];
				}
				if ($index > 0) {
					$next_chapter = $chapters[$index - 1];
				}
			}
		}
	} else {
		$chapter = $chapters[0];
		$chapter_number = $chapters[0]["number"];
		$chapter_number_escaped = omv_encode($chapter_number);
		
		if (count($chapters) > 1) {
			if ($omv_chapters_sorting == SORT_ASC) {
				$next_chapter = $chapters[1];
			} else {
				$previous_chapter = $chapters[1];
			}
		}
	}

	if ($chapter) {
		$pages = omv_get_pages($manga, $chapter["folder"]);
		if (isset($_GET["page"])) {
			$_page = intval($_GET["page"]);
			if (($_page >= 1) && ($_page <= count($pages))) {
				$page = $_page;
			}
		} else if (count($pages) > 0) {
			$page = 1;
		}

		$title .= " - Chapter " . $chapter_number;

		if ($page) {
			$title .= " - Page " . $page;
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
<base href="<?php echo $omv_base_url ?>" />
<meta name="Keywords" content="<?php echo str_replace(' ', ',', $description) ?>" />
<meta name="Description" content="<?php echo $description ?>" />
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta http-equiv="Content-Language" content="en" />
<title><?php echo $title ?></title>
<link rel="stylesheet" href="themes/<?php echo $theme ?>/omv.css" type="text/css" media="screen" />

<script type="text/javascript">
function change_manga(manga) {
	if (manga != 0) {
		document.location = "<?php echo $omv_base_url ?>" + manga;
	}
}

function change_chapter(manga, chapter) {
	if (manga != 0) {
		document.location = "<?php echo $omv_base_url ?>" + manga + "/" + chapter;
	}
}

function change_page(manga, chapter, page) {
	if (manga != 0) {
		document.location = "<?php echo $omv_base_url ?>" + manga + "/" + chapter + "/" + page;
	}
}
</script>

</head>

<body>

<div id="omv">

<table>
<tr class="line">
<td class="up_left"><img src="themes/<?php echo $theme ?>/spacer.gif" alt="" /></td>
<td class="up"></td>
<td class="up_right"><img src="themes/<?php echo $theme ?>/spacer.gif" alt="" /></td>
</tr>
<tr>
<td class="mid_left"></td>
<td class="mid">
<table>
<tr>
<td>
<?php
$omv_pager = "";

$omv_pager .= "<div class=\"pager\">\n";

$omv_pager .= "<span>Manga <select name=\"manga\" onchange=\"change_manga(this.value)\">";
$omv_pager .= "<option value=\"0\">Select Manga Title...</option>";
for ($i = 0; $i < count($mangas); $i++) {
	$m = $mangas[$i];
	$omv_pager .= "<option value=\"" . omv_encode($m) . "\"" . (($m == $manga) ? " selected=\"selected\"" : "") . ">" . $m . "</option>";
}
$omv_pager .= "</select></span>\n";

if ($manga) {
	if ($chapter) {
		$omv_pager .= "<span>Chapter <select name=\"chapter\" onchange=\"change_chapter('$manga_escaped', this.value)\">";
		for ($i = 0; $i < count($chapters); $i++) {
			$cnumber = $chapters[$i]["number"];
			$omv_pager .= "<option value=\"" . omv_encode($cnumber) . "\"" . (($cnumber == $chapter_number) ? " selected=\"selected\"" : "") . ">" . $cnumber . (isset($chapters[$i]["title"]) ? (" - " . $chapters[$i]["title"]) : "") . "</option>";
		}
		$omv_pager .= "</select></span>\n";

		if ($page) {
			$prevhtml = "";
			if ($page <= 1) {
				$prevhtml = "<img src=\"themes/$theme/no-previous.png\" alt=\"\" />";
			} else {
				$prevhtml = "<a href=\"$manga_escaped/$chapter_number_escaped/" . ($page - 1) . "\"><img src=\"themes/$theme/previous.png\" alt=\"Previous Page\" title=\"Previous Page\" /></a>";
			}
			$nexthtml = "";
			if ($page >= count($pages)) {
				$nexthtml = "<img src=\"themes/$theme/no-next.png\" alt=\"\" />";
			} else {
				$nexthtml = "<a href=\"$manga_escaped/$chapter_number_escaped/" . ($page + 1) . "\"><img src=\"themes/$theme/next.png\" alt=\"Next Page\" title=\"Next Page\" /></a>";
			}

			$omv_pager .= "<span>$prevhtml Page <select name=\"page\" onchange=\"change_page('$manga_escaped', '$chapter_number_escaped', this.value)\">";
			for ($p = 1; $p <= count($pages); $p++) {
				$omv_pager .= "<option value=\"" . $p . "\"" . (($p == $page) ? " selected=\"selected\"" : "") . ">#" . $p . "</option>";
			}
			$omv_pager .= "</select> of " . count($pages) . " $nexthtml</span>\n";
		}
	}
}

$omv_pager .= "</div>\n";

echo $omv_pager;
?>
</td>
</tr>
<tr>
<td>
<div class="ads">
<!-- Begin Advertisement -->
<img src="ads.png" alt="Ads" width="468" height="60" />
<!-- End Advertisement -->
</div>
</td>
</tr>
<tr>
<td><?php
if ($manga) {
	if ($chapter) {
		if ($page) {
			$img = "mangas/" . $manga . "/" . $chapter["folder"] . "/" . $pages[$page - 1];
			$imgsize = omv_get_image_size($img);
			$imghtml = "<img src=\"$img\" alt=\"\" width=\"" . $imgsize["width"] . "\" height=\"" . $imgsize["height"] . "\" class=\"picture\" />";
			
			$prev_page_path = omv_get_previous_page($manga_escaped, $chapter_number_escaped, $page, $previous_chapter);
			$next_page_path = omv_get_next_page($manga_escaped, $chapter_number_escaped, $page, count($pages), $next_chapter);
			
			if ($next_page_path) {
				$imghtml = "<a href=\"$next_page_path\">" . $imghtml . "</a>";
			}
			echo $imghtml;
		} else {
			echo "<div class=\"warn\">There is no selected page!</div>";
		}
	} else {
		echo "<div class=\"warn\">There is no selected chapter!</div>";
	}
} else {
	echo "<div class=\"warn\">Select a manga title to get started!</div>";
}
?></td>
</tr>
<?php
if ($manga && $chapter && $page) {
?>
<tr>
<td>
<div class="ads">
<!-- Begin Advertisement -->
<img src="ads.png" alt="Ads" width="468" height="60" />
<!-- End Advertisement -->
</div>
<script type="text/javascript">
function omvKeyPressed(e) {
	var keyCode = 0;
	
	if (navigator.appName == "Microsoft Internet Explorer") {
		if (!e) {
			var e = window.event;
		}
		if (e.keyCode) {
			keyCode = e.keyCode;
			if ((keyCode == 37) || (keyCode == 39)) {
				window.event.keyCode = 0;
			}
		} else {
			keyCode = e.which;
		}
	} else {
		if (e.which) {
			keyCode = e.which;
		} else {
			keyCode = e.keyCode;
		}
	}
	
	switch (keyCode) {
<?php
if ($prev_page_path) {
?>
		case 37:
		window.location = "<?php echo $omv_base_url . $prev_page_path ?>";
		return false;
		
<?php
}
if ($next_page_path) {
?>
		case 39:
		window.location = "<?php echo $omv_base_url . $next_page_path ?>";
		return false;
		
<?php
}
?>
		default:
		return true;
	}
}
document.onkeydown = omvKeyPressed;
</script>
</td>
</tr>
<tr>
<td>
<?php
echo $omv_pager;
?>
</td>
</tr>
<?php
} else {
?>
<tr>
<td><br /></td>
</tr>
<?php
}
?>
</table>
</td>
<td class="mid_right"></td>
</tr>
<tr class="line">
<td class="down_left"></td>
<td class="down"></td>
<td class="down_right"></td>
</tr>
</table>

</div>

<div class="w3c">
<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" width="88" height="31" /></a> 
<a href="http://jigsaw.w3.org/css-validator/check?uri=referer"><img src="http://www.w3.org/Icons/valid-css.png" alt="Valid CSS 2.1" width="88" height="31" /></a> 
</div>

</body>

</html>
