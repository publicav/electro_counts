﻿$(function () {
    $('#group').change(function () {
        var tableConst = '<table id="groupconter_t" class="display" width="90%" cellspacing="0"><thead></thead><tbody></tbody></table>';

        console.log('change')
        var group = $(this).val();
        $.ajax({dataType: 'json', type: 'get', url: 'models/json/accounting_group.php', data: {'group': group}})
            .success(function (result) {
                var data = result;
                var nameGroup = data.nameGroup;
                var titleGroup = '<div style="font-size: 18pt; padding: 10px; text-align: center">' + nameGroup +  '</div>'

                // table.destroy();
                $("#table_div").html('');
                $("#table_div").append(titleGroup + tableConst);
                //Таблица
                var default_options = {
                    "pageLength": 50,
                    // "scrollX": true,
                    "aaData": data.calcData,
                    "aoColumns": data.title,
                    // "destroy": true

                };
                $("#groupconter_t").dataTable(default_options);
                // console.log('test', data);
            })
            .error(function (result) {
                    alert('Error')
                }
            );

    })
    // var default_options = {
    //     bProcessing: true,
    //     aoColumns: head
    //     // aaData: body,
    //     // aoColumns: head
    // };
    var tableConst = '<table id="groupconter_t" class="display" width="90%" cellspacing="0"><thead></thead><tbody></tbody></table>';
    $.ajax({dataType: 'json', type: 'get', url: 'models/json/accounting_group.php', data: {'group': 1}})
        .success(function (result) {
            var data = result;
            var nameGroup = data.nameGroup;
            var titleGroup = '<div style="font-size: 18pt; padding: 10px; text-align: center">' + nameGroup +  '</div>'
            $("#table_div").html('');
            $("#table_div").append(titleGroup + tableConst);
            //Таблица
            var default_options = {
                "pageLength": 50,
                // "scrollX": true,
                "aaData": data.calcData,
                "aoColumns": data.title
            };
            $("#groupconter_t").dataTable(default_options);
            // console.log('test', data);
        })
        .error(function (result) {
                alert('Error')
            }
        );

});

