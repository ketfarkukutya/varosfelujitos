<?
if ($loggedin == 0)
{
?>
<script>
location.replace("<? print("$baselocation");?>admin/index.php");
</script>
<?
}
?>