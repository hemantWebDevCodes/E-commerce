$("#Massage_btn").on("click", function () {
  // e.preventDefault();
  let contect_name = $("#name").val();
  let contect_email = $("#email").val();
  let contect_mobile = $("#mobile").val();
  let contect_massage = $("#comment").val();

  $.ajax({
      url: "contect.php",
      type: "POST",
      data: { name: contect_name, email: contect_email, mobile: contect_mobile, comment: contect_massage },
      success: function (data) {
          $("#validate_register").trigger("reset");
      },
  });
});

// Quantity Plus Minus
var qnty;

$("#plus").click(function () {
  qnty = parseInt($(".value").val());
  qnty = qnty + 1;
  $(".value").val(qnty);
});

$("#minus").click(function () {
  qnty = parseInt($(".value").val());
  qnty = qnty - 1;

  if (qnty == -1) {
      qnty = 0;
  }
  $(".value").val(qnty);
});

// CheckOut Acordian Process
$(".acordian-title").click(function () {
  if ($(this).next(".Acordian .card-body").hasClass(".active-acordian")) {
      $(this).next(".Acordian .card-body").removeClass(".active-acordian").slideUp();
      $(this).children("i").removeClass("fa-minus").addClass("fa-plus");
  } else {
      $(".Acordian .card-body").removeClass(".active-acordian").slideUp();
      $(".Acordian .acordian-title i").removeClass("fa-minus").addClass("fa-plus");
      $(this).next(".Acordian .card-body").addClass(".active-acordian").slideDown();
      $(this).children("i").removeClass("fa-plus").addClass("fa-minus");
  }
});

// img Coursol
$('.slider').slick({
    arrows: true,
    dots: true,
    autoplay: false,
    autoplaySpeed: 2000,
    fade: true,
    speed: 1000
  });

// Jquery Acordian
$(".filter-title").click(function () {
  if ($(this).next(".filter-acordian .acordian-body").hasClass(".active-filter")) {
      $(this).next(".filter-acordian .acordian-body").removeClass(".active-filter").slideUp();
      $(this).children("i").removeClass("fa-angle-down").addClass("fa-angle-up");
  } else {
      $(".filter-acordian .acordian-body").removeClass(".active-filter").slideUp();
      $(".filter-acordian .filter-title i").removeClass("fa-angle-down").addClass("fa-angle-up");
      $(this).next(".filter-acordian .acordian-body").addClass(".active-filter").slideDown();
      $(this).children("i").removeClass("fa-angle-up").addClass("fa-angle-down");
  }
});

// FILTER PRODUCT BY PRICE

function filterProduct() {
  let min_price = $("#min_price").val();
  let max_price = $("#max_price").val();

  $.ajax({
      url: "product_filter.php",
      type: "post",
      data: { min_price: min_price, max_price: max_price },
      success: function (data) {
          $("#result_filter").html(data);
      },
  });
}

$("#min_price, #max_price").on("keyup", function () {
  filterProduct();
});

$("#slider-range").slider({
  range: true,
  min: 100,
  max: 10000,
  values: [100, 10000],
  slide: function (event, ui) {
      if (ui.values[0] == ui.values[1]) {
          return false;
      }
      $("#min_price").val(ui.values[0]);
      $("#max_price").val(ui.values[1]);

      filterProduct();
  },
});
$("#min_price").val($("#slider-range").slider("values", 0));
$("#max_price").val($("#slider-range").slider("values", 1));

// SEARCH PRODUCT
$(document).ready(function () {
  $("#search_box").keyup(function(){
      let search = $(this).val();

      if(search != "") {
         $.ajax({
           url:"search.php",
           type:"POST",
           data:{search_list: search },
           success: function (search_data) {
            console.log(search_data);
            $("#search_suggetion").fadeIn().html(search_data);
           }
        });
      }else{
        $("#search_suggetion").fadeOut();
      }
});
});

  $(document).on('click','#search_suggetion li',function(){
    $("#search_box").val($(this).text());
    $("#search_suggetion").fadeOut();
  });

// DESCRIPTION REVIEW ACORDIAN 
  $( function() {
    $( "#accordion" ).accordion();
  } );

 $("#rating_form_show").click(function(){
    $("#rating_form_hide").toggle();
 })

