$(document).ready(function () {

    //table count
    var rowCount = 1;
    //for the typehead
    var currentInput;
    createTypehead();
    //creating typehead for first counter
    function createTypehead() {
        $('input').typeahead({
            source: function (query, process) {
                var type = currentInput.attr("name");

                $.ajax({
                    url: "BackendPhp/productfetch.php",
                    method: "POST",
                    data: {
                        query: query,
                        type: type
                    },
                    dataType: "json",
                    success: function (data) {
                        process($.map(data, function (item) {
                            return item;
                        }));
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

        $("tbody").append(' <tr id="row' + rowCount + '"> <td data-title="S.N.">' + (rowCount + 1) + '</td> <td data-title="Brand Name" class="table-success"> <input name="brand" type="text" class="form-control" placeholder="Brand" autocomplete="off" required/></td> <td data-title="Sub-Brand "> <input name="subbrand" type="text" class="form-control " placeholder="Sub-Brand" autocomplete="off" required/></td> <td data-title="Product "> <input name="product_name" type="text" class=" form-control " placeholder="Product Name" autocomplete="off" required/></td> <td data-title="Product Category"> <input name="product_category" type="text" class=" form-control " placeholder="Category" autocomplete="off" required/></td> <td data-title="Piece Code"> <input name="piece_code" type="text" class=" form-control " placeholder="Code" autocomplete="off" required /> </td> <td data-title="Original Price"> <div class="input-group"> <span class="input-group-addon">Rs.</span> <input name="piece_original_price" type="text" class=" form-control " placeholder="Rs." autocomplete="off" required /> </div> </td> <td data-title="Marked Price"> <div class="input-group"> <span class="input-group-addon">Rs.</span> <input name="piece_marked_price" type="text" class=" form-control " placeholder="Rs." autocomplete="off" required/> </div> </td> <td data-title="Gender"> <select name="piece_gender" class="btn btn-default"> <option value="Male">Male</option> <option value="Female">Female</option> </select> </td> <td data-title="Piece Color"> <input name="piece_color" type="text" class=" form-control " placeholder="Color" autocomplete="off" required /> </td> <td data-title="Piece Size"> <input name="piece_size" type="text" class=" form-control " placeholder="Size" autocomplete="off" required/> </td> <td data-title="Image" class="condensed"> <input name="piece_image" type="file" id="file' + rowCount + '"  class="form-control file" style><span id="uploaded_image"></span></td> </tr> ');

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
                    "brand": "",
                    "subbrand": "",
                    "product_name": "",
                    "product_category": "",
                    "piece_code": "",
                    "piece_original_price": "",
                    "piece_marked_price": "",
                    "piece_gender": "",
                    "piece_color": "",
                    "piece_size": "",
                    "piece_image": ""
                };
                $(this).find("input,select").each(function (col) {
                    if (row != 0) {
                        var index = $(this).attr("name");

                        if (col == 5 || col == 6 || col == 9)
                            data[index] = parseFloat($(this).val());
                        else if (col == 10)
                            data[index] = $(this).data("img");
                        else
                            data[index] = $(this).val();
                    }
                });
                if (row != 0)
                    dataArray.push(data);

            });

            var jsonString = JSON.stringify(dataArray);
            // $("#result").text(jsonString);
            //  alert(jsonString);
            $.ajax({
                url: "BackendPhp/tableSave.php",
                method: "POST",
                data: {
                    json: jsonString
                },
                success: function (data) {
                    // alert(data);
                    rowCount = 0;
                    $("tbody").html("");

                    $(".table-alert2").html('<a href="#" class="close" aria-label="close" >&times</a> <b>SUCCESS! </b><br /> ' + data);
                    $(".table-alert2").show(500).delay(5000).hide(1000);
                    $("#add_row").trigger('click');

                }
            });
        }


    });



    $(document).on('click', '.table-alert a.close', function () {
        $(".table-alert").hide(1000);
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

                    } else if (col == 5 || col == 6 || col == 9) {
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

    $(document).on('change', '.file', function () {

        var id = $(this).attr("id");
        var this1 = $(this);
        var file_name = (this1.parent().parent().find("[name='piece_code']").val());
        if (file_name != "") {


            var name = document.getElementById(id).files[0].name;

            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                alert("Invalid Image File");
            }
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById(id).files[0]);
            var f = document.getElementById(id).files[0];
            var fsize = f.size || f.fileSize;
            if (fsize > 2000000) {
                alert("Image File Size is very big");
            } else {

                form_data.append("file", document.getElementById(id).files[0]);
                form_data.append("text", file_name);
                $.ajax({
                    url: "BackendPhp/upload.php",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        this1.next().html("<label class='text-success'>Image Uploading...</label>");
                    },
                    success: function (data) {

                        this1.next().html('<img src="../img/' + data + '" height="150" width="150" class="img-thumbnail" />');
                        this1.data("img", data);
                        this1.hide();
                    }
                });
            }
        } else {
            alert("You must insert piece code before uploading file");
        }
    });



});
