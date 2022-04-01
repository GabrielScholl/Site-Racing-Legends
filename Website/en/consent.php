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