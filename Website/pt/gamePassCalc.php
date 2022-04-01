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
        <title>Faça as contas!</title>
    </head>
    <body>
        <div class='verticalizer'>
            <div class='title'><h1>Qual a sua pergunta</h1><h1 id='pto'>?</h1></div>
            <a href="months.php">Quantos meses de GAME PASS até valer a pena comprar o(s) jogo(s)?</a>
            <a href="games.php">Quantos jogos devo querer até o GAME PASS valer a pena?</a>
        </div>
    </body>

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
            font-family: Roboto;
            font-style: italic;
            font-weight: lighter;
            color: white;
            font-size: 18px;
            width: 100%;
            letter-spacing: 1px;
            margin: 30px auto 8px;
        }
        a{
            text-decoration:none;
            color: #19202a;
            background-color: white;
            margin:10px 50px;

            font-family: Roboto;
            /* font-style: italic; */
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