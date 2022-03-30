<style>
    /* footer{
        position: relative;
        left: 0;
        bottom: 0;
        width: 100%;
    } */
</style>

<footer class="py-2 px-4 bg-dark fixed-bottom">
    <div class="float-right d-none d-sm-block">
        <b id="footerTimer"></b>
    </div>
    <strong><a class="text-white"href="https://www.pricon.com.ph/index.php/en/" target="_blank">Pricon Microelectronics, Inc.</a></strong>
</footer>

<script type="text/javascript">
	setInterval( () => {
		var now = new Date();
		$("#footerTimer").text(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
	}, 1000);
</script>