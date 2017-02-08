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
    $(function () {
//        var charts = Highcharts.chart('container', {
//            chart: {
//                type: 'bar'
//            },
//            title: {
//                text: '<?//=$type['nameGroup']?>//'
//            },
//            xAxis: {
//                categories: <?//=$dateJson?>
//
//            },
//            yAxis: {
//                title: {
//                    text: 'Расход электричества по ячейкам'
//                }
//            },
//            legend: {
//                reversed: true
//            },
//            plotOptions: {
//                series: {
//                    stacking: 'normal'
//                }
//            },
//            series: [{
//                name: '<?//=$type['legend'][22]['name']?>//',
//                data: <?//=$xpo?>
//            }, {
//                name: '<?//=$type['legend'][23]['name']?>//',
//                data: <?//=$xpo[23]?>
//            }, {
//                name: '<?//=$type['legend'][24]['name']?>//',
//                data: <?//=$xpo[24]?>
//            }]
//        });
//        charts.series[2].setData(<?//=$xpos23?>//);
        $("#groupconter_t").dataTable();
    });
</script>
</head>
<body>

<!--<div id="container" style="min-width: 310px; max-width: 800px; height: 800px; margin: 0 auto"></div>-->

<table id="groupconter_t" class="display" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th><?//=$type['legend'][22]['name']?></th>
        <th><?//=$type['legend'][23]['name']?></th>
        <th><?//=$type['legend'][24]['name']?></th>
    </tr>
    <tr>
        <td>1</td>
        <td>2</td>
        <td>3</td>
    </tr>
    </tbody>
</table>

<?php // include $tplName; ?>


</body>
</html>
