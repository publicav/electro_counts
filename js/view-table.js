$(function () {
    $('#group').change(function () {
        var tableConst = '<table id="groupconter_t" class="display" width="90%" cellspacing="0"><thead></thead><tbody></tbody></table>';

        console.log('change')
        var group = $(this).val();
        $.ajax({dataType: 'json', type: 'get', url: 'models/json/accounting_group.php', data: {'group': group}})
            .success(function (result) {
                var data = result;
                // table.destroy();
                $("#table_div").html('');
                $("#table_div").append(tableConst);
                //Таблица
                var default_options = {
                    "pageLength": 50,
                    "scrollX": true,
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

    $.ajax({dataType: 'json', type: 'get', url: 'models/json/accounting_group.php', data: {'group': 2}})
        .success(function (result) {
            var data = result;
            // $("#table_div").html('');
            //Таблица
            var default_options = {
                "pageLength": 50,
                "scrollX": true,
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

