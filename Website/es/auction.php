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
    <h1>Haz tu elección</h1>
    <!-- <div class='mainAndAds'> -->
    
        <!-- <div class='adSpace'></div> -->
        <!-- <div class='divider'></div> -->

        <div class='mainWrapper'>
        
            <div class='main'>
                <div class='pills'>
                    <div class='red'><h2>Aprenda a analizar los gráficos</h2><a href="#learn">TOMAR</a></div>
                    <div class='blue'><h2>Solo quiero ir a los gráficos</h2><a href="#use">TOMAR</a></div>
                </div>
                <!-- <div class='horAds'><h3>ANUNCIO</h3><div class='ad'></div></div> -->
                <div class='iframeContainer' id='learn'>
                    <h2>Vea los videos cortos a continuación para aprender a usar y analizar los gráficos.</h2>
                    <p>
                        Esta es una serie de videos cortos que te enseñan todo lo que necesitas
                        saber desde los conceptos básicos de cómo utilizar la herramienta hasta algunas técnicas de
                        análisis gráfico para ayudarte a ganar mucho dinero comprando
                        y vendiendo autos en la subasta de Forza. ¡Disfrutar!
                    </p>
                    <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/pw-hDrPyXBg" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                    <div id='extraVids'>
                        <!-- <div class='horAdsSq'><h3>ANUNCIO</h3><div class='adSq'></div></div> -->
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/91TDIahDZX8" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/QDhJXRx3flw" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/TBRoxPtWfqc" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/Of4zlUDS7hg" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                    </div>
                    <div class='centerSeeMore'><a href='javascript:void(0);' id='seeMore' onClick='showMore()'>Muestra más videos</a></div>
                </div>
                <div class='text2' id='use'>
                    <h2 id='missable'>Para acceder a las listas de subastas de Forza, haga clic en el botón.</h2>
                    <p id='missable'>
                        Puede hacer clic, ¡vaya con todo! Si no ha visto los videos, le recomiendo que los vea.
                        Allí encontrarás todos los tutoriales sobre cómo empezar a utilizar la plataforma y también
                        aspectos más avanzados, como el análisis de posibles causas y efectos de las fluctuaciones.
                    </p>
                    <div class='centerGoTo'><a href="chooseCar.php" class='goToCharts'>¡Quiero gráficos!</a></div>
                </div>
                <div class='bottomAds'>
                    <!-- <div class='bottomAd1'><h3>ANUNCIO</h3><div class='adb1'></div></div> -->
                    <!-- <div class='bottomAd2'><h3>ANUNCIO</h3><div class='adb2'></div></div> -->
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
            button.innerHTML = 'Muestra más videos';
        }
        else{
            vids.style.display = 'block';
            button.innerHTML = 'Muestra menos';
        }
    }
</script>

</body>
</html>