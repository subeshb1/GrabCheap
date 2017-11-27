$(document).ready(function () {

    //table count
    var rowCount = 1;
    //for the typehead
    var currentInput;
    createTypehead();
    //creating typehead for first counter
    function createTypehead() {
        $('.typeahead').typeahead({
            source: function (query, process) {

                var type = currentInput.attr("name");

                $.ajax({
                    url: "BackendPhp/orderfetch.php",
                    method: "POST",
                    data: {
                        query: query,
                        type: type
                    },
                    dataType:"JSON",
                    success: function (data) {
                      //  alert(data);
                        process($.map(data, function (item) {
                            return item;
                        }));
                    },error:function(a,b,c) {
                        //alert(a+b+c);
                    }
                });
            }
        });
    }

    //to know the current input
    $('table').on('focusin', 'input', function () {

        currentInput = $(this);

    });


    //adding new row
    $("#add_row").click(function () {

        $("tbody").append(' <tr id="row' + rowCount + '"> <td data-title="S.N.">' + (rowCount + 1) + '</td>  <td data-title="Ordered Piece Code" > <input name="piece_code" type="text" class="form-control typeahead" placeholder="Code" autocomplete="off" required/></td> <td data-title="Product Name"> <input name="product_name" type="text" class="form-control " placeholder="Product Name" autocomplete="off" required disabled/></td> <td data-title="Settled Price"> <div class="input-group"> <span class="input-group-addon">Rs.</span> <input name="order_price" type="text" class=" form-control " placeholder="Rs." autocomplete="off" required/> </div> </td> <td data-title="Customer Number"> <input name="customer_number" type="text" class=" form-control typeahead" placeholder="Number" autocomplete="off" required/></td> <td data-title="Customer Name"> <input name="customer_name" type="text" class=" form-control " placeholder="Name" autocomplete="off" required/></td> <td data-title="Customer Address"> <input name="customer_address" type="text" class=" form-control " placeholder="Address" autocomplete="off" required /> </td> <td data-title="Gender"> <select name="customer_gender" class="btn btn-default"> <option value="Male">Male</option> <option value="Female">Female</option> </select> </td>');

        rowCount++;
        createTypehead();




    });

    //seleting row
    $("#delete_row").click(function () {
        if (rowCount > 1) {
            $("#row" + (rowCount - 1)).remove();
            rowCount--;
        }
    });


    $("#save_button").click(function () {
        if (validate()) {
            var dataArray = [];

            $("table").find("tr").each(function (row) {
                var data = {
                    "piece_code" :"",
                    "order_price":"",
                    "customer_number": "",
                    "customer_name":"",
                    "customer_address":"",
                    "customer_gender":""
                };
                $(this).find("input,select").each(function (col) {
                    if (row != 0 &&col!=1) {
                        var index = $(this).attr("name");
                        if (col == 2)
                            data[index] = parseFloat($(this).val());
                        else
                            data[index] = $(this).val();
                    }
                });
                if (row != 0)
                    dataArray.push(data);

            });

            var jsonString = JSON.stringify(dataArray);
//            alert(jsonString);
            // $("#result").text(jsonString);
            $.ajax({
                url: "BackendPhp/ordersave.php",
                method: "POST",
                data: {
                    json: jsonString
                },
                beforesend: function() {
                  
                },
                success: function (data) {
                    // alert(data);
                    rowCount = 0;
                    $("tbody").html("");

                    $(".table-alert2").html('<a href="#" class="close" aria-label="close" >&times</a> <b>Summary </b><br /> ' + data);
                    $(".table-alert2").show(500);
                    $("#add_row").trigger('click');

                },error: function(a,b,c) {
                  alert(a+b+c);
                }
            });
        }


    });



    $(document).on('click', '.table-alert a.close', function () {
        $(".table-alert").hide(1000);
    });

    $(document).on('click', '.table-alert2 a.close', function () {
      alert("sdsd");
        $(".table-alert2").hide(1000);
    });

    //validating table
    function validate() {

        var error = "";
        $("table").find("tr").each(function (row) {
            var rowError = "";
            $(this).find("input,select").each(function (col) {

                if (col != 10) {
                    if ($(this).val() == "") {
                        rowError += " Column " + (col + 1) + " fields can't be empty<br />";

                    } else if (col == 2) {
                        var reg = new RegExp(/^(?![0.]+$)\d+(\.\d{1,2})?$/gm);
                        var value = $(this).val().toString();

                        if (!reg.test(value)) {

                            rowError += " Column " + (col + 1) + " numeric value required. Example: 1000 , 1400.40 <br />";
                        }
                    }

                }
            });
            if (rowError != "") {
                rowError = "ERROR IN ROW " + row + ": <br /><br />" + rowError;
                error += rowError + " <br /><br />"
            }

        });
        if (error != "") {
            $(".table-alert").html('<a href="#" class="close" aria-label="close" >&times</a>' + error);
            $(".table-alert").show(500);
            return false;
        } else {
            $(".table-alert").hide();
            return true;
        }

    }

    $('tbody').on('focusout', 'input[name="piece_code"]', function () {
        var val = $(this).val();
        var this1 = $(this);
        // $(this).css("background", "red");
        if (val != "") {
            $.ajax({
                url: "BackendPhp/orderfetch.php",
                method: "POST",
                data: {
                    dat: val,
                    item: "piece"
                },
                dataType: "json",
                success: function (data) {


                    this1.parent().next().children().val(data.product_name);
                },
                error: function (one, two, three) {

                    $(".table-alert").html('<a href="#" class="close" aria-label="close" >&times</a>' +'No Piece found or is not available of code : '+this1.val());
            $(".table-alert").show(500).delay(3000).hide(1000);
                    this1.parent().next().children().val("");

                }
            });
        }
        else{
            this1.parent().next().children().val("");
        }
    });

    $('tbody').on('focusout', 'input[name="customer_number"]', function () {
        var val = $(this).val();
        var this1 = $(this);
        if (val != "") {
            // $(this).css("background", "red");
            $.ajax({
                url: "BackendPhp/orderfetch.php",
                method: "POST",
                data: {
                    dat: val,
                    item: "customer"
                },
                dataType: 'json',
                success: function (data) {

                    this1.parent().nextAll().each(function () {

                        var item = $(this).children();

                        item.val(data[item.attr("name")]);

                    });

                },
                error: function () {
                    this1.parent().nextAll().each(function () {

                        var item = $(this).children();

                        item.val("");

                    });

                }
            });
        }

    });


});
