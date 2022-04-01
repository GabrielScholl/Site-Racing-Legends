    <div class='navBar'>

        <a href='javascript:void(0);' class='menuOp' onclick='menuDrop()'>
        <div class='menuOpener'>
        <div class='sq1'></div>
        <div class='sq2'></div>
        <div class='sq3'></div>
        </div>
        </a>

        <a class = 'start' href='index.php'>HOME</a>
        <a class = 'auction' href='auction.php'>AUCTION PRICES</a>
        
        <a class = 'pic' href='https://www.youtube.com/channel/UCacRuG098TWXAXjkJLOTFKw' target="_blank" rel="noopener noreferrer">
        <div class='header'>
        <img src="imgs/LA.png" width='90' height='90' alt='LA' onmouseover="this.src='imgs/LAhover.png';" onmouseout="this.src='imgs/LA.png'">
        </div>
        </a>

        <a class = 'gpc' href='bg.php'>QUALITY WALLPAPERS</a>
        <a class = 'about' href='about.php'>ABOUT</a>

        <div class='nothing'></div>

    </div>

    <div class='menuMobile'>
        <div id='myLinks'>
        <a href='index.php'>HOME</a>
        <a href='auction.php'>AUCTION PRICES</a>
        <a href='bg.php'>QUALITY WALLPAPERS</a>
        <a href='about.php'>ABOUT</a>
        </div>
    </div>

    <!-- Menu opening function -->
<script>
    function menuDrop() {
        var el = document.getElementById('myLinks');

        if (el.style.display === 'block'){
            el.style.display = 'none';
        }
        else{
            el.style.display = 'block';
        }
    }
</script>