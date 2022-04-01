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
    <h1>Welcome to the Racing Legends website!</h1>
    <!-- <div class='mainAndAds'> -->
    
        <!-- <div class='adSpace'></div> -->
        <!-- <div class='divider'></div> -->

        <div class='mainWrapper'>

            <div class='main'>
            <div class='iframeContainer'><div class='iframeRatio'><iframe id='vid1' frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></div>
            <div class='text2'>
            <h2>Why would anyone make this!?</h2>
            <p>
                Got curious to know why a Forza player and Youtuber
                would make a platform like this with his own hands?
            </p>
            </div>
            <div class='goToAbout'>
                <h2>Find out.</h2>
                <a href="about.php">Afraid?</a>
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
<div class='footer'> <p>Copyright <a href='https://www.youtube.com/channel/UCacRuG098TWXAXjkJLOTFKw/' target="_blank" rel="noopener noreferrer">Racing Legends</a> 2021</p> <a class ='terms' href='terms.php'>Terms of Use</a> <a class ='terms' href='privacy.php'>Privacy Policy</a> </div>

</div>

<!-- Consent -->

<div id="consent-popup" class="hidden">
    <p>By using this site you agree to our <a href="terms.php" target='blank'>Terms and Conditions</a> and our <a href="privacy.php" target='blank'>Privacy and Cookie Policies</a>. Please read them carefully before using the website.</p>
    <a id="accept" href="#">Accept</a>
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
            document.getElementById("vid1").src = "https://www.youtube.com/embed/OXPAkTBj-n4";
        } else {
            document.getElementById("vid1").src = "https://www.youtube.com/embed/JkQWH_047Co";
        }

        // Actual cookie thing
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