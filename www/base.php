<style>
.thumb {
    display: inline-block;
    width: 200px;
    height: 200px;
    margin: 5px;
    border: 1px solid #362E38;
    background-position: center center;
    background-size: cover;
}
.thumbsmall {
    display: inline-block;
    width: 100px;
    height: 100px;
    margin: 3px;
    border: 1px solid #362E38;
    background-position: center center;
    background-size: cover;
}

</style>

<script>
	function newissue ()
		{
			location.replace("<? print("$baselocation");?>?u=upload");
		}
</script>

<div class="container" id="base" style="margin-top: 5px; display: none;">
<?
if ($pagetype == 0)
{
?>
	<div class="row">
		<div class="col-md-12">
			<h2>Üdv az MKKP városmódosító oldalán!</h2>
			<p style="margin-left: 15px;">
			Benőtte a gaz a szétrúgott elektromos szekrényt?<br />
			Kátyúba dőlt az összegrefitizett villanyoszlop?<br />
			Nem látszik a szeméttől a lekopott zebra, amin amúgy se lehetne átkelni kerekesszékkel?
			</p>
			<p style="margin-left: 15px;">
			Jelentsd be a térképen a problémákat, amiket a városodban látsz és mi megoldjuk!<br />
			Vagy legalább viccessé tesszük.<br />
			Vagy legalább széppé.
			</p>
			<p style="margin-left: 15px;">
			A bejelentések alatt kommentben várjuk az ötleteket, hogy mit kezdjünk az adott problémával.
			</p>
			<p style="margin-left: 15px;">
			Ha bármi kérdésed van az oldallal kapcsolatban, esetleg kezdtél valamit az egyik bejelentéssel, írj nekünk a <b>ketfarkukutya@gmail.com</b>-ra!
			</p>
			<p style="margin-left: 15px;">
			<b>MKKP Rendkívüli Ügyek Minisztériuma</b>
			</p>
		</div>
	</div>

	<div class="row" style="text-align: center;">
		<div class="active" onclick="newissue();">
			Probléma bejelentése
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6" style="text-align: center;">
			<div class="fb-page" data-href="https://www.facebook.com/Rendk&#xed;v&#xfc;li-&#xdc;gyek-Miniszt&#xe9;riuma-229535940504887/" data-tabs="timeline" data-width="400" data-height="70" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/Rendk&#xed;v&#xfc;li-&#xdc;gyek-Miniszt&#xe9;riuma-229535940504887/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Rendk&#xed;v&#xfc;li-&#xdc;gyek-Miniszt&#xe9;riuma-229535940504887/">Rendkívüli Ügyek Minisztériuma</a></blockquote></div>
		</div>
		<div class="col-md-6" style="text-align: center;">
			<div class="fb-page" data-href="https://www.facebook.com/justanotherwordpresspage/" data-tabs="timeline" data-width="400" data-height="70" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/justanotherwordpresspage/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/justanotherwordpresspage/">Magyar Kétfarkú Kutya Párt</a></blockquote></div>
		</div>
	</div>
<?
}
?>
</div>		