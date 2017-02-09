$(function () {
    $('#group').change(function () {
        console.log('change')
        var group = $(this).val();
        $.ajax({dataType: 'json', type: 'get', url: 'models/json/accounting_group.php', data: {'group': group}})
            .success(function (result) {
                var data = result;
                // table.destroy();
                $("#groupconter_t").html('');
                //Таблица
                var default_options = {
                    "pageLength": 50,
                    "scrollX": true,
                    "aaData": data.calcData,
                    "aoColumns": data.title,
                    "destroy": true

                };
                table = $("#groupconter_t").dataTable(default_options);
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
            $("#groupconter_t").html('');
            //Таблица
            var default_options = {
                "pageLength": 50,
                "scrollX": true,
                "aaData": data.calcData,
                "aoColumns": data.title,
                "destroy": true

            };
            table = $("#groupconter_t").dataTable(default_options);
            // console.log('test', data);
        })
        .error(function (result) {
                alert('Error')
            }
        );

});

