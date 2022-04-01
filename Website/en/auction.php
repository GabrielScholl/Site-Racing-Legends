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
    <h1>Take your choice</h1>
    <!-- <div class='mainAndAds'> -->
    
        <!-- <div class='adSpace'></div> -->
        <!-- <div class='divider'></div> -->

        <div class='mainWrapper'>
        
            <div class='main'>
                <div class='pills'>
                    <div class='red'><h2>Learn to analyse charts</h2><a href="#learn">TAKE</a></div>
                    <div class='blue'><h2>Just take me to the charts</h2><a href="#use">TAKE</a></div>
                </div>
                <!-- <div class='horAds'><h3>ADVERTISEMENT</h3><div class='ad'></div></div> -->
                <div class='iframeContainer' id='learn'>
                    <h2>Watch the short videos below to learn how to use and analyze the charts.</h2>
                    <p>
                        This is a series of short videos that teach you everything you need
                        know from the basics of how to use the tool to some techniques for
                        graphical analysis to help you make a lot of money buying
                        and selling cars at auction in Forza. Enjoy! 
                    </p>
                    <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/02WlVsVwzVw" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                    <div id='extraVids'>
                        <!-- <div class='horAdsSq'><h3>ADVERTISEMENT</h3><div class='adSq'></div></div> -->
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/g2W18O_UEGQ" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/5rNzDUML9gQ" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/T_4186DBLrM" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                        <div class='iframeRatio'><iframe src="https://www.youtube.com/embed/aaX80tOPUZQ" frameborder="0" allow="accelerometer; autoplay; modestbranding; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                    </div>
                    <div class='centerSeeMore'><a href='javascript:void(0);' id='seeMore' onClick='showMore()'>Mostrar mais vídeos</a></div>
                </div>
                <div class='text2' id='use'>
                    <h2 id='missable'>To access Forza auction price charts, click the button.</h2>
                    <p id='missable'>
                        Click it, go ahead! If you haven't watched the videos, I strongly recommend you do so.
                        There you will find all tutorials on how to start using the platform and also
                        more advanced subjects, such as analysing possible causes and effects of fluctuations.
                    </p>
                    <div class='centerGoTo'><a href="chooseCar.php" class='goToCharts'>I want charts!</a></div>
                </div>
                <div class='bottomAds'>
                    <!-- <div class='bottomAd1'><h3>ADVERTISEMENT</h3><div class='adb1'></div></div> -->
                    <!-- <div class='bottomAd2'><h3>ADVERTISEMENT</h3><div class='adb2'></div></div> -->
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
            button.innerHTML = 'Show more videos';
        }
        else{
            vids.style.display = 'block';
            button.innerHTML = 'Show less';
        }
    }
</script>

</body>
</html>