<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <link type="text/css" rel="stylesheet" href="css/adm.css">
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>

    <link rel="shortcut icon" type="image/x-icon" href="img/web/count1.png">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="level">
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/datatables.min.js"></script>
    <script src="js/highcharts.js"></script>
    <script src="js/modules/exporting.js"></script>

    <style type="text/css">
        ${demo.css}
    </style>

    <? //=$this->getJsHTML()?>
</head>
<script type="text/javascript">
    <?php // include __DIR__ . "/../base/jquery_exec.php"; ?>
</script>

<script type="text/javascript">
    $( function () {
        var options = {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'dddd'
            },
            xAxis: {
                categories: [ 0, 5, 10, 15 ]

            },
            yAxis: {
                title: {
                    text: 'Расход электричества по ячейкам'
                }
            },
            legend: {
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            series: []
        };
        options.series = [ {
            name: 'ssds',
            data: [ 1, 2, 3, 4 ]
        }, {
            name: 'ertt',
            data: [ 1, 2, 3, 4 ]
        }, {
            name: '3353',
            data: [ 1, 2, 3, 4 ]
        } ];
        var chart = new Highcharts.Chart('container', options );
        console.log( options );
        var options = {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'dddd'
            },
            xAxis: {
                categories: [ 0, 5, 10, 15 ]

            },
            yAxis: {
                title: {
                    text: 'Расход электричества по ячейкам'
                }
            },
            legend: {
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            series: []
        };
        options.series = [ {
            name: 'ssds',
            data: [ 1, 2, 3, 4 ]
        }, {
            name: 'ertt',
            data: [ 1, 2, 3, 4 ]
        }, {
            name: '3353',
            data: [ 1, 2, 3, 4 ]
        },{
            name: '3333353',
            data: [ 1, 2, 3, 4 ]
        }  ];

        var chart = new Highcharts.Chart('container', options );
        //        charts.series[ 2 ].setData(<?//=$xpos23?>//);
//        $( "#container" ).html( chart );
    } )
    ;
</script>
</head>
<body>
<div id="container"></div>
</body>
</html>
