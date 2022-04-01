<html>

<!-- Tab and general settings -->
<head>
    <link href='https://fonts.googleapis.com/css?family=Playfair Display|Staatliches|Roboto' rel='stylesheet'>
    <!-- Image in the tab -->
    <link type='image/x-icon' rel='shortcut icon' href='imgs/LAroundGreen.png'/>
    <!-- Charset -->
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Leyendas Motorizadas - Elige un auto</title>

    <!-- Includes jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Includes Underscore js -->
    <script src="https://cdn.jsdelivr.net/npm/underscore@1.12.0/underscore-min.js"></script>
    <!-- Includes Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>

<!-- Page content -->
<body>
    <!-- <div class='horAds'><h3>ADVERTISEMENT</h3><div class='ad'></div></div> -->
    <div class='tutiquanti'>
    <div class='title'><h1>Elige un auto</h1><h1 id='pto'>.</h1></div>
    <h2>MARCA</h2>
    <!-- Start of get values from php -->
    <div id="invis" style='display:none;'>
    </div>
    <!-- End of get values from php -->
    <select class="dropdn" id="makes" name="makes" multiple="multiple">
        <script>
            // makes dropdn
            $(document).ready(function() {
                $('#makes').select2({
                    placeholder: 'Seleccione una opción'
                });
                // alert("Step 1 starting");
                makesList = $.get("getMakes.php", function(data){
                    // asks for all car makes
                    // alert("Step 1.1 inside get");
                    var makesList = data;
                    // console.log(makesList);
                    makesList = makesList.trim();
                    makesList = makesList.split(",");
                    makesList = _.uniq(makesList, false);
                    // console.log(makesList);
                    // alert("Step 1.2 got the following makes");

                    // puts all car makes in list
                    var x = document.getElementById("makes");
                    for (const make of makesList){
                        var option = document.createElement("option");
                        option.text = make;
                        x.add(option);
                    }
                    // alert("Step 1.3 completed list of makes");
                });
                
            });

            
        </script>
    </select>
    <button onclick="modelsFinder()">ENCONTRAR MODELOS</button>
    
    <h2>MODEL</h2>
    <div id="invis2" style='display:none;'>    
    </div>
    <select class="dropdn" id="models" name="models" multiple="multiple">
        <script>
            $(document).ready(function() {
                $('#models').select2({
                    placeholder: 'Elija una marca primero'
                });
            });

            // func to get selected make
            function retriever() {
                // alert("Was able to get in retriever");
                return $('#makes').select2('data');
            }
            
            function modelsFinder() {
                // gets the selected make
                // alert("Step 2 will get the following make from first select");
                var selectedMake = $("#makes").val();
                // alert(selectedMake);
                if (selectedMake == '') {
                    alert('¡Seleccione una marca!');
                }
                else {
                    // gets all models for that make
                    modelsList = $.post("getModels.php", {
                        // data to be used by post
                        make: selectedMake
                    }, 
                        // functoin to get data
                        function(data){
                            // asks for all car makes
                            var modelsList = data;
                            modelsList = modelsList.trim();
                            modelsList = modelsList.split(",");
                            // alert("Step 2.1 sent post with make and retrieved following models");
                            // alert(modelsList);

                            // puts all car makes in list
                            var y = document.getElementById("models");
                            for (const model of modelsList){
                                var option = document.createElement("option");
                                option.text = model;
                                y.add(option);
                            // alert("Step 2.2 just put the models in second select");
                        }
                    });
                }
            }

            // func to call chart
            function goToChart() {
                var selectedMake = $("#makes").val();
                var selectedModel = $("#models").val();
                localStorage.setItem("make",selectedMake);
                localStorage.setItem("model",selectedModel);
                
                location.href='chart.php';
            }
            function backToWebsite() {
                window.location.href = "index.php";
            }
        </script>
    </select>
    <button onclick="goToChart()">BUSCAR PRECIOS</button>
    <button class='goBack' onclick="backToWebsite()">VOLVER AL SITIO</button>
    </div>

    <style>
        body{
            background-color: #19202a;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items:center;
            text-align: center;
            margin: auto;
        }
        .title{
            display: flex;
            justify-content: center;
            align-items: space-around;
        }
        #pto{
            color: rgba(0,255,200,1);
            margin-left:0;
            margin-right:auto;
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
        select{
            width: 100%;
        }
        li{
          font-family: Roboto;  
        }
        /* Mobile */
        @media only screen and (max-width:767px){
            
            .tutiquanti{
                width: 300px;
                padding: 15px 0 0 0;
            }
            .horAds{
                padding: 15px 0 25px;
                background-color: rgba(255, 255, 255, 0);
                border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            }

            .horAds h3{
                color: rgba(255, 255, 255, 0.66);
                text-align: center;
                font-size: 14px;
                font-weight: lighter;
                font-family: Roboto;
                margin: 0 0 0 0;
            }

            .horAds .ad{
                width: 320px;
                height: 50px;
                background-color: white;
                margin: auto;
            }
            h1{
                font-family: 'Times New Roman';
                color: white;
                font-size: 36px;
                margin: 0 auto 10px;
                margin-right:0;
            }
            button{
                margin: 30px 15% 15px;
                background-color: rgba(0,0,0,0);
                font-size: 16px;
                font-family: Roboto;
                text-decoration: none;
                padding: 15px 15px;
                border: 2.3px solid rgba(0,255,200,0.75);
                cursor: pointer;
                border-radius: 5px;
                text-align: center;
                line-height: 10px;
                cursor: pointer;
                color: white;
            }
            button:hover{
                background-color: rgba(0,255,200,1);
                color: black;
                font-weight: bold;
            }
            .goBack:hover{
                background-color: rgba(255,226,98,1);
                color: black;
                font-weight: bold;
            }
            .goBack{
                font-size: 12px;
                border: 2.3px solid rgba(255,226,98,0.75);
                color: rgba(255,255,255,0.9);
                padding: 10px 10px;
            }
        }
        /* Desktop */
        @media only screen and (min-width:768px){
            .horAds{
                padding: 20px 0 35px;
                background-color: rgba(255, 255, 255, 0);
                border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            }

            .horAds h3{
                color: rgba(255,255,255, 0.66);
                text-align: center;
                font-size: 14px;
                font-weight: lighter;
                font-family: Roboto;
                margin: 0 0 0 0;
            }

            .horAds .ad{
                width: 728px;
                height: 90px;
                background-color: white;
                margin: auto;
            }
            .tutiquanti{
                width: 400px;
                padding: 20px 0 0 0;
                margin: auto;
            }
            h1{
                font-family: 'Times New Roman';
                color: white;
                font-size: 42px;
                margin: 0 auto 10px;
                margin-right:0;
            }
            button{
                margin: 30px 20% 15px;
                background-color: rgba(0,0,0,0);
                font-size: 16px;
                font-family: Roboto;
                text-decoration: none;
                padding: 15px 15px;
                border: 2.3px solid rgba(0,255,200,0.75);
                cursor: pointer;
                border-radius: 5px;
                text-align: center;
                line-height: 10px;
                cursor: pointer;
                color: white;
            }
            button:hover{
                background-color: rgba(0,255,200,1);
                color: black;
                font-weight: bold;
            }
            .goBack:hover{
                background-color: rgba(255,226,98,1);
                color: black;
                font-weight: bold;
            }
            .goBack{
                font-size: 12px;
                border: 2.3px solid rgba(255,226,98,0.75);
                color: rgba(255,255,255,0.9);
                padding: 10px 10px;
            }
        }

        /* From web to make select2 height */
        .select2-selection__choice__remove {
            line-height: 10px !important;
            margin: 5px;
        }
        .select2-selection__choice {
            line-height: 1px !important;
            padding-right: 3px !important;
        }
        .select2-selection__rendered {
            line-height: 1px !important;
        }
        .select2-container .select2-selection--single {
            height: 1px !important;
        }
        .select2-selection__arrow {
            height: 1px !important;
        }
    </style>
</body>
</html>