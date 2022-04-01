<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Playfair Display|Staatliches|Roboto' rel='stylesheet'>
        <!-- Image in the tab -->
        <link type='image/x-icon' rel='shortcut icon' href='imgs/LAround.png'/>
        <!-- Charset -->
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <!-- Mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <title>¡Haz los cálculos!</title>
    </head>
    <body>
        <div class='verticalizer'>
            <div class='title'><h1>Ingrese los datos y presione ir<h1 id='pto'>!</h1></h1></div>
            <h2>¿Cuántos meses de GAME PASS hasta valer la pena comprar el(los) juego(s)?</h2>
            <form id="frm1" action="/action_page.php">
            <h3>Valor del(de los) juego(s)</h3><input type="text" name="val"><br>
            <h3></h3><input type="text" name="lname"><br><br>
            <input type="button" onclick="myFunction()" value="¡Vamos!">
            </form>
        </div>
    </body>

    <script>
        function myFunction() {
            document.getElementById("frm1").submit();
        }
    </script>

    <style>
        body{
            background-color: #19202a;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items:center;
            text-align: center;
            margin: auto;
        }
        .verticalizer{
            display: flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
        }
        .title{
            display: flex;
            justify-content: center;
            align-items: space-around;
        }
        .title h1{
            margin-right:0;
        }
        #pto{
            color: rgba(0,255,200,1);
            margin-left:0;
            margin-right:auto;
        }
        h1{
            font-family: 'Times New Roman';
            color: white;
            font-size: 42px;
            margin: 0 auto 10px;
        }
        h2{
            font-family: 'Times New Roman';
            font-style: italic;
            font-weight: lighter;
            color: white;
            font-size: 18px;
            width: 100%;
            letter-spacing: 1px;
            margin: 10px auto 8px;
        }
        h3{
            font-family: 'Times New Roman';
            font-weight: bold;
            color: rgba(100,255,210,1);
            font-size: 24px;
            width: 100%;
            letter-spacing: 1px;
            margin: 10px auto 8px;
        }
        input{
            background-color: #29303a;
            border: 2px solid rgba(0,255,200,1);
            border-radius: 8px;
            color:white;
            font-size: 24px;
        }
        a{
            text-decoration:none;
            color: #19202a;
            background-color: white;
            margin:10px 50px;

            font-family: Roboto;
            font-style: italic;
            font-size: 18px;
            width: 100%;
            margin: 30px 0 8px;

            padding: 12px;
            border: 2px solid white;
            border-radius: 8px;
        }
        a:hover{
            background-color:  rgba(0,255,200,1);
            border: 2px solid rgba(0,255,200,1);
        }
        select{
            width: 100%;
        }
        button{
            margin: 30px 30% 15px;
        }
        /* Mobile */
        @media only screen and (max-width:767px){
            
        }
        /* Desktop */
        @media only screen and (min-width:768px){
            
        }
    </style>
</html>