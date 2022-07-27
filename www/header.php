<div style="width: 100%; margin: 0px; padding: 2px;"></div>
<?
if ($pagetype == 0)
{
?>
<div class="row" style="text-align: center;">
			<img src="<? print($baselocation); ?>img/newbanner.png" style="padding: 10px; width: 95%; max-width: 900px;" />
		</div>
<?
}
?>
<div class="titlecontainer">
	<ul>
  <li><a href="<? print($baselocation); ?>?u=home">Kezdőoldal</a></li>
  <li><a href="<? print($baselocation); ?>?u=map">Térkép</a></li>
  <li><a href="<? print($baselocation); ?>?u=list">Bejelentések</a></li>
  <li><a href="<? print($baselocation); ?>?u=stat">Statisztikák</a></li>
  <li style="float:right"><a class="active" href="<? print($baselocation); ?>?u=upload">Probléma bejelentése</a></li>
</ul>
</div>

<div class="footerdiv">
Ön éppen a <b>Magyar Kétfarkú Kutya Párt</b> árnyékellenzéke által üzemeltetett <b>Rendkívüli Ügyek Minisztériumának</b> Ügyfélkapuján jár
</div>