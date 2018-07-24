<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
</head>

<body>

<h2>First soap request</h2>
<form action="" method="post">
	<input type="text" name="numb" placeholder="Enter a number in numbers">
	<button type="submit">Transform</button>
</form>
<div>
<?php
if($resNumb) echo($_POST["numb"] . " = " . $resNumb->NumberToWordsResult);
?>
</div>

<h2>Second soap request</h2>
<p>Select the country</p>

<form action="" method="post">
	<select name="country">
		<?php if($resCountrys) : ?>
		<?php foreach($resCountrys as $country) : ?>
		<option value="<?=$country->sISOCode?>"><?=$country->sName?></option>
		<?php endforeach; ?>
		<?php endif; ?>
	</select>
	<button type="submit">Get info</button>
</form>
<?php
if($info) var_dump($info);
?>

</body>
</html>