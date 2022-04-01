<div id="consent-popup" class="hidden">
    <p>Al utilizar este sitio, acepta nuestros <a href="terms.php" target='blank'>Términos y Condiciones</a> y nuestra <a href="privacy.php" target='blank'>Política de Privacidad</a> y Cookies. Léalos detenidamente antes de utilizar el sitio web.</p>
    <a id="accept" href="#">Aceptar</a>
</div>

<script src="app.js"></script>

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