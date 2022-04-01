<div onload="download()"></div>
<a id="dl" style="display: none" href="" download>Download</a>

<script>
    (function download() {
        // running on https://www.racinglegends.xyz/walls.php?wall=ImgNameL.png
        let params = new URLSearchParams(location.search);
        var wall = params.get('wall');
        var link = 'https://www.racinglegends.xyz/walls/' + wall;
        document.getElementById('dl').href = link;
        document.getElementById('dl').click();
        close();
    })()
</script>