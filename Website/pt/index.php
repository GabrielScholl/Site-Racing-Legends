<html>

<!-- Tab and general settings -->
<head>
    <?php include ('head.php'); ?>
</head>

<!-- Page content -->
<body>

<!-- Container of header and main to position footer down -->
<div class='containerOfHeaderAndMain'>
    
    <!-- Upper part of the site -->
    <?php include ('header.php'); ?>

    <!-- Body or main part, between the header and the footer -->
    <h1>Bem vindos ao site do Lendas Automotivas!</h1>
    <!-- <div class='mainAndAds'> -->
    
        <!-- <div class='adSpace'></div> -->
        <!-- <div class='divider'></div> -->

        <div class='mainWrapper'>

            <div class='main'>
            <div class='iframeContainer'><div class='iframeRatio'><iframe id='vid1' frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></div>
            <div class='text2'>
            <h2>Porque alguém faria isso!?</h2>
            <p>
                Ficou curioso para saber por que um jogador de Forza e Youtuber
                faria uma plataforma como essa com as próprias mãos?
            </p>
            </div>
            <div class='goToAbout'>
                <h2>Descubra.</h2>
                <a href="about.php">Tem coragem?</a>
            </div>
            </div>

        </div>
            
        <!-- <div class='divider'></div> -->
        <!-- <div class='adSpace'></div> -->

    <!-- </div> -->

</div>

<!-- Footer or lower part of the site -->
<div class='bottomPack'>

<img class='signature' src='imgs/signature.png'>
<div class='footer'> <p>Copyright <a href='https://www.youtube.com/channel/UCeU32v7EnsSKpcGSrLrXcnQ/' target="_blank" rel="noopener noreferrer">Lendas Automotivas</a> 2021</p> <a class ='terms' href='terms.php'>Termos de uso</a> <a class ='terms' href='privacy.php'>Política de privacidade</a> </div>

</div>

<!-- Consent -->

<div id="consent-popup" class="hidden">
    <p>Ao usar este site, você concorda com os nossos <a href="terms.php" target='blank'>Termos e Condições</a> e nossa <a href="privacy.php" target='blank'>Política de Privacidade</a> e Cookies. Por favor, leia-as com cuidado antes de usar o site.</p>
    <a id="accept" href="#">Aceitar</a>
</div>

<script>
    const cookieStorage = {
        getItem: (item) => {
            const cookies = document.cookie
                .split(';')
                .map(cookie => cookie.split('='))
                .reduce((acc, [key, value]) => ({ ...acc, [key.trim()]: value }), {});
            return cookies[item];
        },
        setItem: (item, value) => {
            document.cookie = `${item}=${value};`
        }
    }

    const storageType = cookieStorage;
    const consentPropertyName = 'jdc_consent';
    const shouldShowPopup = () => !storageType.getItem(consentPropertyName);
    const saveToStorage = () => storageType.setItem(consentPropertyName, true);

    window.onload = () => {

        // YT player
        if (window.matchMedia("(min-width:768px)").matches) {
            document.getElementById("vid1").src = "https://www.youtube.com/embed/IaYURMAQmoo";
        } else {
            document.getElementById("vid1").src = "https://www.youtube.com/embed/rcNgpaXmlcU";
        }

        // Actual cookie stuff
        const acceptFn = event => {
            saveToStorage(storageType);
            consentPopup.classList.add('hidden');
        }
        const consentPopup = document.getElementById('consent-popup');
        const acceptBtn = document.getElementById('accept');
        acceptBtn.addEventListener('click', acceptFn);

        if (shouldShowPopup(storageType)) {
            setTimeout(() => {
                consentPopup.classList.remove('hidden');
            }, 500);
        }

    };
</script>

<style>
#consent-popup {
    display:flex;
    flex-direction:row;
    justify-content:space-evenly;

    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 2rem;
    background-color: #fff;
}
#consent-popup a{
    color:blue;
} 
.hidden{
    visibility: hidden;
}
#consent-popup p{
    font-size:18px;
    margin: auto;
}

#accept{
    margin: auto;

    background-color: #4CBF50; /* Green */
    border: none;
    color: white !important;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;

    border-radius: 5px;
    font-size:18px;
}
</style>

</body>
</html>