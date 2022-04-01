    <div class='navBar'>

        <a href='javascript:void(0);' class='menuOp' onclick='menuDrop()'>
        <div class='menuOpener'>
        <div class='sq1'></div>
        <div class='sq2'></div>
        <div class='sq3'></div>
        </div>
        </a>

        <a class = 'start' href='index.php'>INÍCIO</a>
        <a class = 'auction' href='auction.php'>PREÇOS DE LEILÃO</a>
        
        <a class = 'pic' href='https://www.youtube.com/channel/UCeU32v7EnsSKpcGSrLrXcnQ/' target="_blank" rel="noopener noreferrer">
        <div class='header'>
        <img src="imgs/LA.png" width='90' height='90' alt='LA' onmouseover="this.src='imgs/LAhover.png';" onmouseout="this.src='imgs/LA.png'">
        </div>
        </a>

        <a class = 'gpc' href='bg.php'>PAPÉIS DE PAREDE</a>
        <a class = 'about' href='about.php'>SOBRE</a>

        <div class='nothing'></div>

    </div>

    <div class='menuMobile'>
        <div id='myLinks'>
        <a href='index.php'>INÍCIO</a>
        <a href='auction.php'>PREÇOS DE LEILÃO</a>
        <a href='bg.php'>PAPÉIS DE PAREDE</a>
        <a href='about.php'>SOBRE</a>
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