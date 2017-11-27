$(document).ready(function() {
  $('#tablefilter').css("display", 'none');
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
  var orderBy = "piece_date";




  //filter object
  var filterObject = {
    brand_name: "",
    subbrand_name: "",
    product_name: "",
    product_category: "",
    piece_code: "",
    piece_original_price: "",
    piece_marked_price: "",
    piece_gender: "",
    piece_color: "",
    piece_size: ""


  };


  //geting number of piece

  getCount('piece');



  //Loading content from database
  loadTable(0);



  //making selection
  $("tbody").on('click', 'tr', function() {


    if ($(this).hasClass('select-tr')) {

      $(this).removeClass('select-tr');
      $("#action").addClass('collapse');
    } else {
      $('tr').removeClass('select-tr');
      $(this).addClass('select-tr');
      $("#action").removeClass('collapse');
    }


  });




  //filter toggle
  $("#filter").on('click', function() {
    $("#tablefilter").toggle();

    clearFilter();
    getCount('piece');
    loadTable(0);
    adjustSize();


  });



  //resize
  $(window).resize(function() {

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

  function fillTable() {
    tableData.forEach(function(data) {
      addTableContent();
      $("#row" + rowCount).find('td').each(function(i) {
        var index = $(this).attr("name");
        if (i == 11) {


          $(this).children().children().attr("src", "../img/" + data[index] + "");
        } else if (i != 0) {

          $(this).text(data[index]);
        }
      });
      rowCount++;
    });



  }

  function addTableContent() {

    $('tbody').append('<tr id="row' + rowCount + '"> <td data-title="S.N.">' + (rowCount + 1) + '</td> <td name="brand_name" data-title="Brand Name" ></td> <td data-title="Sub-Brand "name="subbrand_name"></td> <td data-title="Product "name="product_name" ></td> <td data-title="Product Category"name="product_category"></td> <td data-title="Piece Code" name="piece_code" ></td> <td data-title="Original Price" name="piece_original_price"></td> <td data-title="Marked Price" name="piece_marked_price"></td> <td data-title="Gender" name="piece_gender"></td> <td data-title="Piece Color" name="piece_color"></td> <td data-title="Piece Size" name="piece_size"></td> <td data-title="Image" name="piece_image"><a href="#"><img src=""  width="40px" class="img-thumbnail center-block" /></a></td> </tr>');
  }

  function getCount(type) {

    $.ajax({
      url: "BackendPhp/count.php",
      method: "POST",
      data: {
        type: type,
        orderBy: orderBy,
        order: recordOrder,
        filterObject: JSON.stringify(filterObject)
      },
      success: function(data) {
        totalData = data;
        maxPage = parseInt(totalData / 7) + (totalData % 7 == 0 ? 0 : 1);
        createPagination(1);
      },
      error: function(a, b, c) {
        console.log(a + " " + b + " " + " ");
      }
    });

  }

  $(document).on('click', ".pagination li", function(e) {

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

    $('tbody').html("");
    rowCount = page * 7;
    loadTable(page);
  });


  //loading table
  function loadTable(page, extra = 1) {
    rowCount = page * 7;
    $('tbody').html("");
    $.ajax({
      url: 'BackendPhp/productData.php',
      method: "POST",
      data: {
        page: page,
        orderBy: orderBy,
        order: recordOrder,
        filterObject: JSON.stringify(filterObject)
      },
      dataType: "json",
      success: function(data) {
        tableData = data;
        $('#action').addClass('collapse');
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
      error: function(a, b, c) {
        console.log("Load Table : " + a + b + c);
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


  // sorting
  //handling sorting

  $(".sortable").on('click', function() {
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
    //alert(orderBy + " " + recordOrder);
    loadTable(currentPage);




  });


  //data filter set
  $(".dataFilter").on("keyup", function(e) {

    // if(e.keyCode === 9)
    // return;
    var str = $(this).val();
    if (str.length >= 1) {
      var charLast = str[str.length - 1].toLowerCase;
      if (charLast >= 'a' && charLast <= 'z' || charLast >= '0' && charLast <= '9' || charLast == 8) {

        var currentPage = parseInt((rowCount) / 7) - 1 + (rowCount % 7 == 0 ? 0 : 1);
        filterObject[$(this).data("value")] = $(this).val();

        getCount('piece');
        loadTable(0, 0);
        //alert(JSON.stringify(filterObject));
      }
    }

  });

  $(".dataFilter").on("focusout", function() {
    if ($(this).val() === "")
      filterObject[$(this).data("value")] = "";
    getCount('piece');
    loadTable(0, 0);
  });



  //clearing the filter on toogle
  function clearFilter() {
    for (var property in filterObject) {
      filterObject[property] = "";
      $('.dataFilter[data-value="' + property + '"]').val("");
    }
  }



  //Handling action

  //Edit action
  $('#editAction').on('click', function(e) {
    $('#actionModal .modal-content').html('<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title">Edit</h4> </div> <div class="modal-body"> <form> <div class="form-group"> <label for="brand_name ">Brand</label> <input type="text" placeholder="Brand" class="form-control" id="brand_name" /> </div> <div class="form-group"> <label for="subbrand_name ">Sub Brand</label> <input type="text" placeholder="Sub Brand" class="form-control" id="subbrand_name" /> </div> <div class="form-group"> <label for="product_name ">Product</label> <input type="text" placeholder="Product Name" class="form-control" id="product_name" /> </div> <div class="form-group"> <label for="product_category ">Category</label> <input type="text" placeholder="Category" class="form-control" id="product_category" /> </div> <div class="form-group"> <label for="piece_code">Piece Code</label> <input type="text" placeholder="Piece Code" class="form-control" id="piece_code" /> </div> <div class="form-group"> <label for="piece_original_price">Original Price</label> <input type="text" placeholder="Original Price" class="form-control" id="piece_original_price" /> </div> <div class="form-group"> <label for="piece_marked_price">Marked Price</label> <input type="text" placeholder="Marked Price" class="form-control" id="piece_marked_price" /> </div> <div class="form-group"> <label for="Gender">Gender</label> <select class="form-control"> <option value = "Male">Male</option> <option value = "Female">Female</option> </select> </div> <div class="form-group"> <label for="piece_color">Piece Color</label> <input type="text" placeholder="Color" class="form-control" id="piece_color" /> </div> <div class="form-group"> <label for="piece_size">Piece Size</label> <input type="text" placeholder="Size" class="form-control" id="piece_size" /> </div> <div class="form-group"> <label for="piece_image">Image</label> <input type="file" placeholder="Size" class="form-control" id="piece_image" /> </div> </form> </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <button type="button" class="btn btn-primary" id="editModalBut">Save changes</button> </div> ');
    let i = 1;
    $('#actionModal').find('input,select').each(function(item) {
      try {

      $(this).val($('tbody').find('.select-tr td').eq(i++).html());

    }catch(e) {
      //Handling the file input
      console.log(($('tbody').find('.select-tr img').attr('src')));
    }
    });

    $('#actionModal').modal('show');

  });

  $('#deleteAction').on('click', function(e) {

    $('#actionModal').modal('show');
  });

});
