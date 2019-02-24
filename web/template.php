<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=0"/>
	<title>Page post</title>

	<link rel="stylesheet" href="<?=ROOT.DS.LAYOUT_PATH.DS.'css/bootstrap.min.css'?>">
    <script type="text/javascript" src="<?=ROOT.DS.LAYOUT_PATH.DS.'js/jquery-1.9.1.js'?>"></script>
    <script type="text/javascript" src="<?=ROOT.DS.LAYOUT_PATH.DS.'js/bootstrap.min.js'?>"></script>
</head>
<body>
<?=isset($content)? $content : ""?>
</body>
</html>
