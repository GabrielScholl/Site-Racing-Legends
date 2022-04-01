<html>

<!-- Tab and general settings -->
<head>
    <?php include ('head.php'); ?>
    <!-- AdSense -->
    <!-- <script data-ad-client="ca-pub-2074822244675680" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
</head>

<!-- Page content -->
<body class='auction'>

<!-- Container of header and main to position footer down -->
<div class='containerOfHeaderAndMain'>
    
    <!-- Upper part of the site -->
    <?php include ('header.php'); ?>

    <!-- Body or main part, between the header and the footer -->
    <h1>Faça a sua escolha</h1>
    <!-- <div class='mainAndAds'> -->
    
        <!-- <div class='adSpace'></div> -->
        <!-- <div class='divider'></div> -->

        <div class='mainWrapper'>
        
            <div class='main'>
                <div class='pills'>
                    <div class='red'><h2>Aprenda a analisar os gráficos</h2><a href="#learn">TOMAR</a></div>
                    <div class='blue'><h2>Só quero ir para os gráficos</h2><a href="#use">TOMAR</a></div>
                </div>
                <!-- <div class='horAds'><h3>PUBLICIDADE</h3><div class='ad'></div></div> -->
                <div class='iframeContainer' id='learn'>
                    <h2>Veja os vídeos curtos abaixo para aprender a usar e analisar os gráficos.</h2>
                    <p>
                        Esta é uma série de vídeos curtos que ensinam tudo o que você precisa
                        saber desde o básico de como utilizar a ferramenta até algumas técnicas
                        de análise gráfica para te ajudar a conseguir muito dinheiro comprando
                        e vendendo carros em leilão no Forza. Aproveite! 
                    </p>
                    <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/MIqr2rjETI4" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                    <div id='extraVids'>
                        <!-- <div class='horAdsSq'><h3>PUBLICIDADE</h3><div class='adSq'></div></div> -->
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/TXuFlMnFtB4" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/aqaOjShYRTw" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/8r7HCu0HWLI" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/yqEZir3LNq4" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                    </div>
                    <div class='centerSeeMore'><a href='javascript:void(0);' id='seeMore' onClick='showMore()'>Mostrar mais vídeos</a></div>
                </div>
                <div class='text2' id='use'>
                    <h2 id='missable'>Para acessar os gráficos de leilões do Forza, clique no botão.</h2>
                    <p id='missable'>
                        Pode clicar, vai com tudo! Se não assistiu aos vídeos, eu recomendo fortemente que assista.
                        Lá você encontra todos os tutoriais de como começar a usar a plataforma e também 
                        aspectos mais avançados, como análises das possíveis causas e efeitos das flutuações.
                    </p>
                    <div class='centerGoTo'><a href="chooseCar.php" class='goToCharts'>Quero gráficos!</a></div>
                </div>
                <div class='bottomAds'>
                    <!-- <div class='bottomAd1'><h3>PUBLICIDADE</h3><div class='adb1'></div></div> -->
                    <!-- <div class='bottomAd2'><h3>PUBLICIDADE</h3><div class='adb2'></div></div> -->
                </div>
            </div>

        </div>
            
        <!-- <div class='divider'></div> -->
        <!-- <div class='adSpace'></div> -->

    <!-- </div> -->

</div>

<!-- Footer or lower part of the site -->
<?php include ("footer.php"); ?>
<!-- </div> -->

<script>
    function showMore() {
        var vids = document.getElementById('extraVids');
        var button = document.getElementById('seeMore');

        if (vids.style.display === 'block'){
            vids.style.display = 'none';
            button.innerHTML = 'Mostrar mais vídeos';
        }
        else{
            vids.style.display = 'block';
            button.innerHTML = 'Mostrar menos';
        }
    }
</script>

</body>
</html>