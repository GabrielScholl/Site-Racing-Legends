<html>

<!-- Tab and general settings -->
<head>
    <!-- Image in the tab -->
    <link href='https://fonts.googleapis.com/css?family=Playfair Display|Staatliches|Roboto' rel='stylesheet'>

    <link type='image/x-icon' rel='shortcut icon' href='imgs/LAroundGreen.png'/>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Lendas Automotivas - Gráficos de preços</title>

    <!-- Includes jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Includes Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Includes Numeral.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
</head>

<!-- Page content -->
<body>
    <!-- Mobile Leader -->
    <div class="adsbygoogle" id='mobilePippersonAD'><a href="https://apoia.se/lendas_automotivas" target='blank'><img src="imgs/AdMobileLeader2.png" alt="Ajdue a manter o site no APOIA.se" width='320px' height='50px'></a></div>
    
    <!-- Draw graphic elements -->
    <div class='chartContainer' id='chartCont'>
        <canvas id='line-chart'></canvas>
        <a class="btn" href='chooseCar.php'><b><---</b> Escolher carro</a>
        <button class="btn" id='vvv' onclick="vvv()">vvv</button>
        <!-- <button class="btn" id='sz' onclick="sz()">Z</button> -->
        <button class="btn" id='max' onclick="timeChooser('max')">Max</button>
        <button class="btn" id='week' onclick="timeChooser('7d')">2s</button>
        <button class="btn" id='month' onclick="timeChooser('1m')">1m</button>
        <button class="btn" id='quarter' onclick="timeChooser('3m')">3m</button>
        <button class="btn" id='year' onclick="timeChooser('1y')">1a</button>
        <button class="btn" id='mbT' onclick="tezao()">T</button>
    </div>

    <!-- Tower Right -->
    <div class="adsbygoogle" id='poripippersonAD'><a href="https://apoia.se/lendas_automotivas" target='blank'><img src="imgs/AdVerticalBanner.png" alt="Ajdue a manter o site no APOIA.se"></a></div>
    <!-- Mobile Tower Right -->
    <div class="adsbygoogle" id='mobileVerticalAD'><a href="https://apoia.se/lendas_automotivas" target='blank'><img src="imgs/AdVerticalBanner.png" alt="Ajdue a manter o site no APOIA.se" width='85px' height='320px'></a></div>

    <!-- Include chart.js -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js'></script>

    <script>
        function sz() {
            var tension;
            char = document.getElementById("sz").innerHTML;
                if (char == "S") {
                    document.getElementById("sz").innerHTML = "Z";
                    chartGraph.options.elements.line.tension = 0.4;
                }
                else {
                    document.getElementById("sz").innerHTML = "S";
                    chartGraph.options.elements.line.tension = 0;
                }
            chartGraph.update();
        }
        // setTimeout(sz(), 0);

        function timeChooser(time) {
            document.cookie = "timeLength" + "=" + time;

            // Creates new dataset
            var pricesList = lengthChooser(window.pricesListPRE);
            var stpricesList = pricesList[0];
            var bopricesList = pricesList[1];
            var dates = pricesList[2];
            
            // Changes dataset
            window.chartGraph.data.labels = dates;
            window.chartGraph.data.datasets = [
                {
                label: 'Lance inicial',
                data: stpricesList,
                borderWidth: 2,
                borderColor: 'rgba(0,255,200,0.66)',
                backgroundColor: gradientAreaST
                },
                {
                label: 'Preço de compra',
                data: bopricesList,
                borderWidth: 2,
                borderColor: 'rgba(255,226,98,0.66)',
                backgroundColor: gradientAreaBO
                }
            ];       
            window.chartGraph.update();
        }

        function lengthChooser(pricesList){
            // get timeLength from cookie
            var timeLength = getCookie("timeLength");
            if (timeLength == "7d") {
                var target = 14;
            } else if (timeLength == "1m") {
                var target = 30;
            } else if (timeLength == "3m") {
                var target = 90;
            } else if (timeLength == "1y") {
                var target = 365;
            } else { // Max amount of days
                var target = 0;
            }
            // truncate price list to the right number of days
            if (target == 0) {
                return pricesList;
            } else {
                if (target < pricesList[2].length) {
                    var stBoDates2 = [[],[],[]];
                    for (i=0; i<3; i++) {
                        stBoDates2[i] = pricesList[i].slice(Math.max(pricesList[i].length - target, 0));
                    }
                    return stBoDates2; 
                } else{
                    return pricesList;
                }
            }
        }

        function pricesFinder(make, model) {
            // gets all models for that make
            pricesList = $.post("getPrices.php", {
                // data to be used by post
                make: make,
                model: model
            }, 
                // functoin to get data
                function(data){
                    // asks for all car data
                    window.pricesListPRE = data;
                    // alert("1");
                    // alert(pricesList);
                    pricesListPRE = pricesListPRE.trim();
                    pricesListPRE = pricesListPRE.split(",");
                    pricesListPRE.pop();
                    pricesListPRE = separatePrices(pricesListPRE);
                    // console.log(pricesListPRE);
                    var pricesList = lengthChooser(pricesListPRE);
                    // alert("2");
                    // console.log(pricesList);
                    // return pricesList;

                    // alert("Sem 3 - 4 Topper");
                    // alert(pricesList);
                    
                    // var tension = 0.4;
                    var tension = 0;

                    const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
                    if (vw < 768) {
                        // Mobile
                        var fontSize1 = 16;
                        var fontSize2 = 14;
                    } else {
                        // Desktop
                        var fontSize1 = 20;
                        var fontSize2 = 17;
                    }
                    
                    var ctx = document.getElementById('line-chart');
                    ctx.style.backgroundColor = '#19202a';

                    // Price related
                    var stpricesList = pricesList[0];
                    var bopricesList = pricesList[1];
                    // Doesn't work from here...
                    var arrayLength = stpricesList.length;
                    for (var i = 0; i < arrayLength; i++) {
                        // console.log(stpricesList[i]);
                        if (stpricesList[i] == undefined) {
                            stpricesList[i] = Number.NaN;
                        }
                    }
                    arrayLength = bopricesList.length;
                    for (var i = 0; i < arrayLength; i++) {
                        // console.log(bopricesList[i]);
                        if (bopricesList[i] == undefined) {
                            bopricesList[i] = Number.NaN;
                        }
                    }
                    // Until here

                    var dates = pricesList[2];
                    // var bopricesList = [2500000,10000000,9900000,20000000,12000000,9900000,17000000];
                    // var dates = ['2020-10-1','2020-10-2','2020-10-3','2020-10-4','2020-10-5','2020-10-6','2020-10-7'];
                    var maxstPrice = Math.max.apply(null, stpricesList);
                    var maxboPrice = Math.max.apply(null, bopricesList);
                    var maxx = [maxstPrice,maxboPrice];
                    var maxPrice = Math.max.apply(null, maxx);

                    // Creates the area gradient
                    window.height = $(document).height();
                    window.ctx2 = document.getElementById('line-chart').getContext("2d");
                    window.gradientAreaST = ctx2.createLinearGradient(0, 0, 0, height-50);
                    gradientAreaST.addColorStop(0, "rgba(0,255,200,0.5)");
                    gradientAreaST.addColorStop(1, "rgba(0,0,0,0)");
                    window.gradientAreaBO = ctx2.createLinearGradient(0, 0, 0, height-50);
                    gradientAreaBO.addColorStop(0, "rgba(255,226,98,0.5)");
                    gradientAreaBO.addColorStop(1, "rgba(0,0,0,0)");

                    Chart.defaults.global.defaultFontFamily = 'Roboto';

                    // Car name concatenation for title
                    var make_model = make.concat(" - ", model);

                    // Type, data e options
                    window.chartGraph = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: dates,
                            datasets: [
                                {
                                label: 'Lance inicial',
                                data: stpricesList,
                                borderWidth: 2,
                                borderColor: 'rgba(0,255,200,0.66)',
                                backgroundColor: gradientAreaST
                                },
                                {
                                label: 'Preço de compra',
                                data: bopricesList,
                                borderWidth: 2,
                                borderColor: 'rgba(255,226,98,0.66)',
                                backgroundColor: gradientAreaBO
                                }

                            ]
                        },
                        options: {
                            spanGaps: true,
                            elements: {
                                line: {
                                    tension: tension,
                                },
                            },
                            title: {
                                display: true,
                                text: make_model,
                                fontSize: fontSize1,
                                fontColor: 'rgba(255,255,255,0.66)',
                                fontFamily: "Helvetica",
                                fontStyle: "italic",
                            },
                            legend: {
                                display: true,
                                labels: {
                                    // boxWidth: 12,
                                    fontSize: fontSize1,
                                    fontColor: 'rgba(255,255,255,0.5)',
                                    position: 'top', 
                                    // padding: 20,
                                }
                            },
                            maintainAspectRatio: false,
                            tooltips: {
                                backgroundColor: 'rgba(0,0,0,0.66)',
                                titleFontSize: fontSize1,
                                titleMarginBottom: 5,
                                titleAlign: 'left',
                                bodyFontFamily: 'Helvetica',
                                bodyFontStyle: 'italic', 
                                bodyFontSize: fontSize1,
                                multiKeyBackground: 'rgba(0,0,0,0)',
                                displayColors: false,
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        value =  tooltipItem.yLabel;
                                        cr = 'CR ';
                                        return cr.concat(numeral(value).format('0,0'));
                                    }
                                }
                            },
                            scales: {
                                xAxes: [{
                                    // type: 'time', // commented --> equal x-spacing, not --> variable x-spacing
                                    time: {
                                        displayFormats: {
                                            week: 'MMM DD',
                                        },
                                    },
                                    display: true,
                                    gridLines: {
                                        display: false,
                                        color: 'rgba(255,255,255,0.5)',
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Dia',
                                        fontSize: fontSize1,
                                        fontColor: 'rgba(255,255,255,0.66)'
                                    },
                                    ticks: {
                                        fontSize: fontSize2,
                                        fontColor: 'rgba(255,255,255,0.5)',
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: true,
                                        color: 'rgba(255,255,255,0.1)',
                                        drawTicks: true,
                                        drawBorder: false,
                                        zeroLineColor: 'rgba(0,0,0,0)', 
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Preço',
                                        fontSize: fontSize1,
                                        fontColor: 'rgba(255,255,255,0.66)',
                                    },
                                    ticks: {
                                        fontSize: fontSize1,
                                        beginAtZero: true,
                                        fontColor: 'rgba(255,255,255,0.5)',
                                        stepSize: maxPrice*1.2/5,
                                        max: maxPrice*1.2,
                                        callback: function (value) {
                                            if (value == 0){
                                                return numeral(value).format('0')
                                            }
                                            else{
                                                if ((value >= 1000 && value < 10000 && value % 1000 != 0) || (value >= 1000000 && value < 10000000 && value % 1000000 != 0)){
                                                    return numeral(value).format('0.0 a')
                                                }
                                                else{
                                                    return numeral(value).format('0 a')
                                                }
                                            }
                                        },
                                    }
                                }]
                            },
                        }
                    });
                }
            );
        }

        function separatePrices(pricesList) {

            // alert("1.1");
            // alert(pricesList);
            // alert(typeof pricesList);
            // alert(pricesList.length);
            var stBoDates = [[],[],[]];
            // alert("1.2");
            // alert(stBoDates);
            for (var i = 0; i < pricesList.length; i++) {
                // if (pricesList[i] !== undefined) {
                //     if (i % 3 == 0) {
                //         stBoDates[0].push(pricesList[i]);
                //     } else if (i % 3 == 1) {
                //         stBoDates[1].push(pricesList[i]);
                //     } else {
                //         stBoDates[2].push(pricesList[i]);
                //     }
                // }
                if (i % 3 == 0) {
                    stBoDates[0].push(pricesList[i]);
                } else if (i % 3 == 1) {
                    stBoDates[1].push(pricesList[i]);
                } else {
                    stBoDates[2].push(pricesList[i]);
                }
                // else {
                //     if (i % 3 == 0) {
                //         stBoDates[0].push(undefined);
                //     } else if (i % 3 == 1) {
                //         stBoDates[1].push(undefined);
                //     } else {
                //         stBoDates[2].push(undefined);
                //     }
                // }
            }
            // alert("1.3");
            // alert(stBoDates[0]);
            // alert(stBoDates[1]);
            // alert(stBoDates[2]);
            return stBoDates;
        }

        $(document).ready( function(){
            var make = localStorage.getItem("make");
            var model = localStorage.getItem("model");
            var pricesList = pricesFinder(make, model);
        });
    </script>

    <style>
        /* Mobile */
        @media only screen and (max-width:767px){
            body{
                background-color: #19202a;
                margin: 0;
                display: flex;
                flex-direction: column;
            }
            .chartContainer{
                position: relative;
                top: 60px;
                padding: 10px 10px 10px 10px;
            }
            #mobilePippersonAD{
                position: fixed;
                top: 0px;
                left: 0px;
            }
            #mobileVerticalAD{
                position: fixed;
                right: 0px;
            }
            #poripippersonAD{
                display: none;
                z-index: -1;
            }
            #max {
                right: 220px;
                bottom: -50px;
                display: none;
            }

            #week {
                right: 170px;
                bottom: -50px;
                display: none;
            }

            #month {
                right: 115px;
                bottom: -50px;
                display: none;
            }

            #quarter{
                right: 60px;
                bottom: -50px;
                display: none;
            }

            #year{
                right: 10px;
                bottom: -50px;
                display: none;
            }
            
            #mbT{
                right: 70px;
            }
        }
        /* Desktop */
        @media only screen and (min-width:768px){
            body{
                background-color: #19202a;
                margin: 0;
                display: flex;
                flex-direction: row;
            }
            .chartContainer{
                position: fixed;
                height: 94%;
                width: auto;
                padding: 15px 10px 10px 10px;
                left: 0px;
            }
            .adsbygoogle{
                position: fixed;
                right: 0px;
            }
            #mobilePippersonAD{
                display: none;
                z-index: -1;
            }
            #mobileVerticalAD{
                display: none;
                z-index: -1;
            }
            #vvv{
                display: none;
            }
            #max {
                right: 220px;
            }

            #week {
                right: 170px;
            }

            #month {
                right: 115px;
            }

            #quarter{
                right: 60px;
            }

            #year{
                right: 10px;
            }

            #mbT{
                display:none;
            }
        }
        .btn {
            position: absolute;
            bottom: -8px;
            background-color: rgba(0,0,0,0);
            font-size: 18px;
            font-family: Roboto;
            text-decoration: none;
            padding: 10px 8px;
            border: 2.3px solid rgba(0,255,200,0.75);
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
            line-height: 10px;
            cursor: pointer;
            color: rgba(0,255,200,0.75);
            text-shadow: 0 0 3px rgba(0,255,200,0.5);
            box-shadow: 0 0 3px rgba(0,255,200,0.5);
        }

        #car {
            left: 10px;
        }

        #vvv{
            right: 10px;
        }

        #sz {
            left: 100px;
        }

        .btn:hover {
            /* background-color: rgba(0,255,200,0.15); */
            color: rgba(0,255,200,1);
            text-shadow: 0 0 10px rgba(0,255,200,0);
            box-shadow: 0 0 10px rgba(0,255,200,0.5);
        }
    </style>
    <script>
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                    var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function tezao() {
            if (document.getElementById("max").style.display == 'initial') {
                document.getElementById("max").style.display = 'none';
                document.getElementById("week").style.display = 'none';
                document.getElementById("month").style.display = 'none';
                document.getElementById("quarter").style.display = 'none';
                document.getElementById("year").style.display = 'none';
            } else {
                document.getElementById("max").style.display = 'initial';
                document.getElementById("week").style.display = 'initial';
                document.getElementById("month").style.display = 'initial';
                document.getElementById("quarter").style.display = 'initial';
                document.getElementById("year").style.display = 'initial';
            }
        }

        function vvv() {
            // get offset from cookie
            var cookie = getCookie("offset");
            if (cookie == "square") {
                offset = -50;
                document.cookie = "offset" + "=" + "tall";
                document.getElementById("chartCont").style.height = (vh - 60 - 10 - 10 + offset); // iOS -> -250px, Android -> -50px
                document.getElementById("vvv").innerHTML = "^^^";
            } else { // cookie == "tall"
                offset = -250;
                document.cookie = "offset" + "=" + "square";
                document.getElementById("chartCont").style.height = (vh - 60 - 10 - 10 + offset); // iOS -> -250px, Android -> -50px
                document.getElementById("vvv").innerHTML = "vvv";
            }
        }

        // Gets offset from cookie
        var cookie = getCookie("offset");
        // console.log(cookie);
        if (cookie != "") {
            // Sets offset value from cookie
            if (cookie == "square") {
                var offset = -250;
                var vvvContent = "vvv";
            } else{ // cookie == "tall"
                var offset = -50;
                var vvvContent = "^^^";
            }
        } else { // cookie == ""
            // Std value for offset if no cookie
            var offset = -250;
            var vvvContent = "vvv";
            document.cookie = "offset" + "=" + "square";
        }

        const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
        const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);
        // Desktop
        if (vw > 767) {
            document.getElementById("line-chart").style.width = (vw - 160 - 10 - 10);
            document.getElementById("line-chart").style.height = (vh - 15 - 10);
            document.getElementById("poripippersonAD").style.top = (vh - 600)/2;
        } else {
            // Mobile
            // Portrait
            if (vw < vh) {
                document.getElementById("line-chart").style.width = (vw - 10 - 10 -10);
                document.getElementById("line-chart").style.height = (vh - 60 - 10 - 10 + offset); // iOS -> -250px, Android -> -50px
                document.getElementById("vvv").innerHTML = vvvContent;
                document.getElementById("mobilePippersonAD").style.left = (vw - 320)/2;
                document.getElementById("mobileVerticalAD").style.display = 'none';
            } else { // Landscape
                // document.getElementById("line-chart").style.width = (vw - 10 - 10 -105);
                document.getElementById("line-chart").style.height = (vh - 10 - 10 -10);
                document.getElementById("chartCont").style.width = (vw - 10 - 10 -85);
                document.getElementById("chartCont").style.top = -10;
                document.getElementById("vvv").style.display = 'none';
                document.getElementById("mobilePippersonAD").style.display = 'none';
                document.getElementById("mobileVerticalAD").style.top = (vh - 320)/2;
            }
        }
        window.onorientationchange = function(event) {
            location.reload();
        };
    </script>

</body>
</html>