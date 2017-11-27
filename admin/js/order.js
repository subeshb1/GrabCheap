$(document).ready(function () {
    $('#tablefilter').hide();
    //table row count
    var rowCount = 0;
    //table data
    var tableData;
    //total number of data
    var totalData;
    //maximum number of pages
    var maxPage;

    //record order
    var recordOrder = "DESC";

    //order on
    var orderBy = "order_time";

    //status filter ||COMPLETED ||PENDING || CANCELED
    var statusFilter = 3;


    //filter object
    var filterObject = {
        order_id: "",
        product_name: "",
        piece_code: "",
        piece_size: "",
        piece_color: "",
        piece_gender: "",
        order_price: "",
        customer_name: "",
        customer_number: "",
        customer_address: ""

    };


    //geting number of orders
    getCount('order');

    //Loading content from database
    loadTable(0);


    //making selection
    $("tbody").on('click', 'tr', function () {


        if ($(this).hasClass('select-tr')) {
            $(this).removeClass('select-tr');

            $("#action").hide();
        } else {
            $('tr').removeClass('select-tr');
            $(this).addClass('select-tr');
            if ($(this).find('button').text() === "PENDING")
                $("#action").show();
        }


    });

    //filter toggle
    $("#filter").on('click', function () {
        $('#tablefilter').toggle();
        clearFilter();
        getCount('order');
        loadTable(0);
        adjustSize();


      });



      //resize
      $(window).resize(function () {

        adjustSize();
      });


    //to adjust size
    function adjustSize() {
      if ($('#tablefilter').css("display") !== "none" && $('#tablefilter').css("display") !== "") {
        if (window.innerWidth <= 1100) {
          console.log("sds");
          $('#tablefilter').css("display", 'block');
        } else
        $('#tablefilter').css("display", 'table-row');
      }
    }


    //filter radio buttons
    $('.btn-filter').on('click', function () {
        var target = $(this).data('target');

        $("#action").hide();
        statusFilter = target;
        getCount('order');
        rowCount = 0;
        loadTable(0);
    });


    function fillTable() {
        tableData.forEach(function (data) {
            addTableContent();
            $("#row" + rowCount).find('td').each(function (i) {
                if (i == 12) {
                    var index = $(this).data("name");
                    var val = data[index];
                    $(this).children().text(data[index]);
                    if (val == "PENDING") {
                        $(this).children().addClass('btn-warning');
                    } else if (val == "COMPLETED") {
                        $(this).children().addClass('btn-success');
                    } else {
                        $(this).children().addClass('btn-danger');
                    }

                } else if (i == 11) {
                    var index = $(this).data("name");
                    //$(this).children().attr("href", "../img/" + data[index] + "");
                    $(this).children().children().attr("src", "../img/" + data[index] + "");
                } else if (i != 0) {
                    var index = $(this).data("name");
                    $(this).text(data[index]);
                }
            });
            rowCount++;
        });

    }

    function addTableContent() {

        $('tbody').append('<tr id="row' + rowCount + '" > <td data-title="S.N.">' + (rowCount + 1) + '</td><td data-title="Order Number" data-name="order_id"></td> <td data-title="Product Name" data-name="product_name"></td> <td data-title="Product Code" data-name="piece_code"></td> <td data-title="Product Size" data-name="piece_size"></td> <td data-title="Product Color" data-name="piece_color"></td> <td data-title="Product Gender" data-name="piece_gender"></td> <td data-title="Order Price" data-name="order_price"></td> <td data-title="Customer Name" data-name="customer_name"></td> <td data-title="Number" data-name="customer_number"></td> <td data-title="Address" data-name="customer_address"></td><td data-title="Image" data-name="piece_image"><a href="#"><img src=""  width="40px" class="img-thumbnail center-block" /></a></td><td data-title="Status" data-name="order_status"><button class="btn " >PENDING</button></td> </tr>');
    }


    //loading table
    function loadTable(page, extra = 1) {

        rowCount = page * 7;
        $('tbody').html("");
        $.ajax({
            url: 'BackendPhp/orderdata.php',

            method: "POST",
            data: {
                page: page,
                status: statusFilter,
                orderBy: orderBy,
                order: recordOrder,
                filterObject: JSON.stringify(filterObject)
            },
            dataType: "json",
            success: function (data) {
                tableData = data;
                if (data.length == 0) {
                    $('tbody').append('<tr><td colspan=12 class="text-center" > No Result Found <td/> <tr/>');


                    if (extra) {
                        $('table').hide();
                        $('table').fadeIn("fast");
                    } else
                        $('table').show();

                } else {
                    fillTable();
                    if (extra) {
                        $('table').hide();
                        $('table').fadeIn("fast");
                    } else
                        $('table').show();
                }

            },
            error: function (a, b, c) {
                console.log("Load Table : " + a + b + c);
            }
        });
    }


    //gets the total number of order and stores in totalData
    function getCount(type) {

        $.ajax({
            url: "BackendPhp/count.php",
            method: "POST",
            data: {
                type: type,
                status: statusFilter,
                orderBy: orderBy,
                order: recordOrder,
                filterObject: JSON.stringify(filterObject)
            },
            success: function (data) {

                totalData = data;
                maxPage = parseInt(totalData / 7) + (totalData % 7 == 0 ? 0 : 1);
                createPagination(1);
            }
        });

    }
    //pagination
    function createPagination(start) {

        $(".pagination").html("");
        $("#page").text("Page " + start + " of " + maxPage + " (" + totalData + " Records) ");
        if (totalData > 7) {

            $(".pagination").append('<li data-number="0"><a href="#"><i class="glyphicon glyphicon-backward"></i></a></li>');
            for (i = start - 3, j = 0; i <= start + ((maxPage - start) >= 4 ? 4 : (maxPage - start)) && j < 4; i++) {
                if (i >= 1) {
                    $(".pagination").append('<li data-number="' + i + ' "class="' + (i === start ? "active" : "") + '"><a href="#" >' + i + '</a></li>');
                    j++;
                }
            }
            $(".pagination").append('<li data-number="-1"><a href="#"><i class="glyphicon glyphicon-forward"></i></a></li>');

        }

    }

    //pagination control
    $(document).on('click', ".pagination li", function (e) {
        $("#action").hide();
        e.preventDefault();
        var text = $(this).text();

        var page;
        if (text == "") {
            var currentPage = parseInt((rowCount) / 7) - 1 + (rowCount % 7 == 0 ? 0 : 1);

            if ($(this).data("number") == 0) {
                if (currentPage <= 0) {
                    page = currentPage;
                    createPagination(currentPage + 1);
                } else {
                    page = currentPage - 1;
                    createPagination(currentPage);
                }
            } else {

                if (currentPage >= maxPage - 1) {
                    page = currentPage;
                    createPagination(currentPage + 1);
                } else {
                    page = currentPage + 1;
                    createPagination(currentPage + 2);
                }
            }
        } else {
            page = text - 1;
            createPagination(page + 1);
        }


        rowCount = page * 7;
        loadTable(page);
    });

    //modal handling

    //modal cancel order
    $("#cancel").on('click', function () {
        $('#myModal .modal-body').empty();
        $('#myModal .modal-footer').empty();
        $('#myModal .modal-header').find('h4').text("Cancel Order");
        $('#myModal .modal-body').append('<div id="no-more-tables1"><table class="table table-bordered table-striped table-responsive " id="tab_logic"><tbody><tr>' + $('.select-tr').html() + '</tr><tbody></table></div>');
        $('#myModal .modal-footer').append('<p class="pull-left">Press the button to Cancel the Order</p><button type="button" class="btn btn-danger" id="cancelOrder">Cancel this Order</button>')
        $('#myModal ').modal('show');
    });
    //modal complete order
    $("#complete").on('click', function () {
        $('#myModal .modal-body').empty();
        $('#myModal .modal-footer').empty();
        $('#myModal .modal-header').find('h4').text("Complete Order");
        $('#myModal .modal-body').append('<div id="no-more-tables1"><table class="table table-bordered table-striped table-responsive " id="tab_logic"><tbody><tr>' + $('.select-tr').html() + '</tr><tbody></table></div>');
        $('#myModal .modal-footer').append('<p class="pull-left">Press the button to Complete the Order</p><button type="button" class="btn btn-success" id="completeOrder">Complete this Order</button>')
        $('#myModal').modal('show');
    });
    //modal button handling (complete / cancel)
    //cancelOrder
    $("#myModal").on('click', '#cancelOrder', function () {
        handle(0);
        modalDismiss();
    });
    //completeOrder
    $("#myModal").on('click', '#completeOrder', function () {
        handle(1);
        modalDismiss();
    });

    $('#modalClose').on('click', function () {
        modalDismiss();
    });

    function modalDismiss() {
        $("#myModal").modal('hide');
        $('#myModal .modal-body').empty();
        $('#myModal .modal-footer').empty();
    }




    //handling order action
    function handle(action) {

        var order = parseInt($(".select-tr td[data-name='order_id']").text());

        $.ajax({
            url: "BackendPhp/ordersave.php",
            method: "POST",
            data: {
                update: order,
                action: parseInt(action)
            },
            success: function (data) {
                alert(data);
                loadTable(0);
            }
        });
    }


    //handling sorting

    $(".sortable").on('click', function () {
        //toggle active
        var currentPage = parseInt((rowCount) / 7) - 1 + (rowCount % 7 == 0 ? 0 : 1);
        if (!$(this).hasClass("active")) {
            $(".sortable.active").find("span").removeClass();
            $(".sortable.active").find("span").addClass("glyphicon glyphicon-sort");
            $(".sortable.active").removeClass("active");
            $(this).addClass("active");
            $(this).find("span").removeClass();
            $(this).find("span").addClass("glyphicon glyphicon-sort-by-attributes");
            $(this).data("order", "ASC");
            recordOrder = "ASC";



        } else {

            $(this).find("span").toggleClass("glyphicon glyphicon-sort-by-attributes").toggleClass("glyphicon glyphicon-sort-by-attributes-alt");
            recordOrder = $(this).data("order") == "ASC" ? "DESC" : "ASC";
            $(this).data("order", recordOrder);



        }
        orderBy = $(this).data("value");
        loadTable(currentPage);




    });


    //data filter set
    $(".dataFilter").on("keyup", function (e) {
        //console.log(e.which);
        if(e.keyCode === 9)
            return;
        var str = $(this).val();
        if(str.length>=1){
        var charLast = str[str.length-1].toLowerCase;
        if (charLast >= 'a' && charLast <= 'z'|| charLast >= '0' && charLast <= '9'||charLast == 8) {

            var currentPage = parseInt((rowCount) / 7) - 1 + (rowCount % 7 == 0 ? 0 : 1);
            filterObject[$(this).data("value")] = $(this).val();

            getCount('order');
            loadTable(0, 0);
        }
        }
    });

    $(".dataFilter").on("focusout",function() {
      if($(this).val() === ""){
        filterObject[$(this).data("value")] = "";
     getCount('order');
      loadTable(0, 0);
    }
    });

    //clearing the filter on toogle
    function clearFilter() {
      for(var property in filterObject) {
        filterObject[property] = "";
        $('.dataFilter[data-value="'+property+'"]').val("");
      }
    }



});
