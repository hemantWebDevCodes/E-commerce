//REGISTRATION FORM
function Registration_send() {
  $(".error_field").html("");
  let name = $("#name").val();
  let email = $("#email").val();
  let mobile = $(".mobile").val();
  let password = $("#password").val();
  var is_error = "";

  if (name == "") {
      $("#name_error").html("Plese Enter Name");
      is_error = "yse";
  }
  if (email == "") {
      $("#email_error").html("Plese Enter Email");
      is_error = "yse";
  }
  if (mobile == "") {
      $("#mobile_error").html("Please Enter Your Mobile Number");
      is_error = "yes";
  }
  if (password == "") {
      $("#password_error").html("Plese Enter Password");
      is_error = "yse";
  }

  if (is_error == "") {
      $.ajax({
          url: "register.php",
          type: "post",
          data: { name: name, email: email, mobile: mobile, password: password },
          success: function (register) {
              register = register.trim();

              if (register == "success") {
                  swal("CONGRATULATIONS", "You have successfully Registered", "success");
                  $("#validate_register").trigger("reset");
              } else {
                  swal("Sorry", "Your Registration Not Successful.", "error");
              }
              if (register == "data_Already_exit") {
                  swal("Sorry", "Your Email AllReady Exists.", "error");
              }
          },
      });
  }
}

//LOGIN RECORD

$("#loginbtn").click(function () {
  $(".text-success").html("");
  let email_login = $("#login_email").val();
  let login_password = $("#login_password").val();

  var is_error = "";

  if (email_login == "") {
      $("#login_Eerror").html("Plese Enter Username");
      is_error = "yes";
  }

  if (login_password == "") {
      $("#login_perror").html("Plese Enter Password");
      is_error = "yes";
  }

  if (is_error == "") {
      $.ajax({
          url: "register.php",
          type: "post",
          data: { login_email: email_login, login_password: login_password },
          success: function (login) {
              login = login.trim();

              if (login == "login") {
                  window.location.href = "dashbord.php";
                  swal("CONGRATULATIO", "You have successfully logged in.", "success");
                  $("#login_form").trigger("reset");
              } else {
                  swal("Login Unsuccessfull", "Invalid Your Email And Password", "error");
              }
          },
      });
  }
});

// ADMIN REGISTRATION

function admin_rgister() {
  $(".error_field").html("");
  let adminname = $("#username").val();
  let admin_email = $("#email").val();
  let password = $("#password").val();
  let admin_mobile = $("#admin_mobile").val();
  let is_error = "";

  if (adminname == "") {
      $("#name_error").html("Please Enter Your Name");
      is_error = "yes";
  }
  if (admin_email == "") {
      $("#email_error").html("Please Enter Your Email");
      is_error = "yes";
  }
  if (password == "") {
      $("#password_error").html("Please Enter Your Password");
      is_error = "yes";
  }
  if (admin_mobile == "") {
      $("#mobile_error").html("Please Enter Your Mobile");
      is_error = "yes";
  }

  if (is_error == "") {
      $.ajax({
          url: "vendor_manage.php",
          type: "post",
          data: { username: adminname, email: admin_email, password: password, admin_mobile: admin_mobile },
          success: function (result) {
              $("#vendor-register").trigger("reset");
          },
      });
  }
}

// ADMIN LOGIN
// function adminlogin(){
$("#admin_registerbtn").click(function (e) {
  e.preventDefault();
  $(".error_field").html("");
  let admin_password = $("#admin_password").val();
  let admin_name = $("#admin_name").val();
  let is_error = "";

  if (admin_name == "") {
      $("#name_error").html("Plese Enter Your UserName");
      is_error = "yes";
  }
  if (admin_password == "") {
      $("#password_error").html("Plese Enter Your Password");
      is_error = "yes";
  }

  if (is_error == "") {
      $.ajax({
          url: "admin_login.php",
          type: "post",
          data: { admin_password: admin_password, admin_name: admin_name },
          success: function (result) {},
      });
  }
});

// MULTIPLE PRODUCT ATTRIBUTE ADD
let total_image = 1;
$("#Add_more_image").on("click", () => {
  total_image++;
  let html =
      '<div class="form-group col-10 add_image_' +
      total_image +
      '"><label for="image">image</label><input type="File" name="product_images[]" class="form-control" required></div></div>' +
      '<div class="form-group col-2 mt-3 add_image_' +
      total_image +
      '"><label for="image"></label><input type="button" onclick=MoreImgRemove("' +
      total_image +
      '") id="More_img_attr_remove" class="btn btn-primary shadow-none mt-2 px-3" value="REMOVE IMAGE"></div>';
  $("#more_img").append(html);
});

function MoreImgRemove(id) {
  $(".add_image_" + id).remove();
}

let attr_count = 1;
$("#Add_more_attr").on("click", () => {
  let size_html = $("#size_attr #size_id").html();
  // size_html = size_html.replace('selected','');
  let color_html = $("#color_attr #color_id").html();
  color_html = color_html.replace("selected", "");

  attr_count++;
  let html =
      '<div class="form-row  attr_' +
      attr_count +
      '">' +
      '<div class="form-group col-2"> <label for="Mrp">MRP</label>' +
      '<input type="text" name="mrp[]" class="form-control" placeholder="Enter MRP"></div>' +
      '<div class="form-group col-2"><label for="price">Price</label>' +
      '<input type="text" name="price[]" class="form-control" placeholder="Enter Price" required>' +
      "</div>" +
      '<div class="form-group col-2"><label for="qnt">quantity</label>' +
      '<input type="text" name="quantity[]" class="form-control" placeholder="Enter Quantity" required>' +
      "</div>" +
      '<div class="form-group col-2"><label for="Size">Size</label>' +
      '<select name="size_id[]" id="size_id" class="form-control shadow-none">' +
      size_html +
      "</select></div>" +
      '<div class="form-group col-2"><label for="qnt">Color</label>' +
      '<select name="color_id[]" id="color_id" class="form-control shadow-none">' +
      color_html +
      "</select></div>" +
      '<div class="form-group col-2 mt-4">' +
      '<input type="button" class="btn btn-primary ml-2 mt-2" onclick=remove_Attr("' +
      attr_count +
      '") value="Remove Attribute" id="More_img_attr_remove">' +
      "</div>" +
      '<input type="hidden" name="attr_id[]" value=""> </div>';

  $("#attr_result").append(html);
});
function remove_Attr(id) {
  $(".attr_" + id).remove();
}

// REMOVE ATTERIBUTE
function remove_Attr(attr_count, id) {
  $.ajax({
      url: "Remove_Atterbute.php",
      type: "post",
      data: { id: id },
      success: function (result) {
          $(".attr_" + attr_count).remove();
      },
  });
}

// LOAD ATTRIBUT
function load_Attribute(color_size_id, product_id, type) {
  $("#colorid").val(color_size_id);

  getAttributeDetail(product_id);

  if (is_size == 0) {
      $("#attr_result_mag").html("");
      $("#quantity_hide").show();
  } else {
      $("#attr_result_mag").html("");
      $.ajax({
          url: "load_attribute.php",
          type: "post",
          data: "color_size_id=" + color_size_id + "&product_id=" + product_id + "&type=" + type,
          success: function (result) {
              $("#size_attr").html(result);
          },
      });
  }
}

$("#quantity_hide").hide(); //HIDE QUANTITY BOX

// SIZE CHANGE ON CLCICK COLOR
$(document).on("click", ".showQuantity", function (event) {
  event.preventDefault();

  $("#attr_result_mag").html("");
  let colorid = $("#colorid").val();

  if (colorid == "" && is_color > 0) {
      $("#attr_result_mag").html("Please Select Color");
  } else {
      let sizeid = $(event.currentTarget).attr("href");

      $("#sizeid").val(sizeid);
      getAttributeDetail(product_id);
  }
});

// GET ATTRIBUTE DEATAIL

function getAttributeDetail(product_id) {
  $("#is_hide_cart_box").show();

  let color = $("#colorid").val();
  let size = $("#sizeid").val();

  $.ajax({
      url: "getAttribute_details.php",
      type: "post",
      data: "product_id=" + product_id + "&color=" + color + "&size=" + size,
      success: function (result) {
          result = $.parseJSON(result);
          $(".new_mrp").html(result.mrp);
          $(".new_price").html("&#8377;"+result.price);

          let quantity = result.quantity;

          if (quantity > 0) {
              $("#is_hide_cart_box").show();
              $("#attr_result_mag").html("");
              $("#quantity_hide").show();
          } else {
              swal("Out Of Stock", "", "error");
              $("#is_hide_cart_box").hide();
              $("#quantity_hide").hide();
          }
      },
  });
}

function shoping_cart_update(product_id, type, size_id, color_id) {
  $("#sizeid").val(size_id);
  $("#colorid").val(color_id);

  shoping_cart(product_id, type);
}

// ADD TO CART
function shoping_cart(product_id, type, is_checkout_buy) {
  if (type == "update") {
      var quantity = $("#" + product_id + "quantity").val();
  } else {
      var quantity = $("#quantity").val();
  }
  let is_error = "";

  size_id = $("#sizeid").val();
  color_id = $("#colorid").val();

  if (type == "add") {
      is_error = "";

      if (is_color != 0 && color_id == "") {
          $("#attr_result_mag").html("Please Select Color");
          is_error = "yes";
      }

      if (is_size != 0 && size_id == "" && is_error == "") {
          $("#attr_result_mag").html("Please Select Size");
          is_error = "yes";
      }
  }

  if (is_error == "") {
      $.ajax({
          url: "shoping_cart.php",
          type: "post",
          data: { product_id: product_id, quantity: quantity, type: type, size_id: size_id, color_id: color_id },
          success: function (data) {
              data = data.trim();

              if (type == "update" || type == "remove") {
                  //  window.location.href=window.location.href;
              }
              if (is_checkout_buy == "buy_now_yes") {
                  window.location.href = "checkout.php";
              }

              if (data == "not_availble_product") {
                  let Availableqty = $("#Availqty").html();
                  swal("This quantity is not Available", "Available quantity" + Availableqty, "error");
              } else {
                  $(".cart_count").html(data);
              }
          },
      });
  }
}

// MANAGE WISHLIST
function manage_wishlist(pid,type) {
  $.ajax({
      url: "wishlist.php",
      type: "post",
      data: 'product_id='+pid+'&type='+type,
      success: function (wishlist) {
          wishlist = wishlist.trim();

        //   if (wishlist == "not_login") {
        //       window.location.href = "login-registration.php";
        //   }
      },
  });
}

// SEARCH BY SORT SELECT PRODUCT
function sort_product_select(cate_id, site_path) {
  var sort_product_id = $("#sort_product_id").val();
  window.location.href = site_path + "/category-product.php?cate_id=" + cate_id + "&sort=" + sort_product_id;
}

//  CHANGE PASSWORD
$(document).ready(function () {
  $("#show_profile_input").click(function () {
      $("#profile-body").fadeToggle();
  });
});
function change_password() {
  $(".error_field").html("");
  var current_pass = $("#current_password").val();
  var new_password = $("#new_password").val();
  var confirm_pass = $("#confirm_password").val();

  var is_error = "";

  if (current_pass == "") {
      $("#current_pass").html("Please Enter Your Current Password");
      is_error = "yes";
  }
  if (new_password == "") {
      $("#new_pass").html("Please Enter Your New Password");
      is_error = "yes";
  }
  if (confirm_pass == "") {
      $("#confirm_pass").html("Please Enter Your Confirm Password");
      is_error = "yes";
  }
  if (new_password != "" && confirm_pass != "" && new_password != confirm_pass) {
      $("#confirm_pass").html("plese Enter Same Password");
      is_error = "yes";
  }
  if (is_error == "") {
      $("#change_password_btn").html("Please Wait..");
      $("#change_password_btn").html("disabled", true);
      $.ajax({
          url: "user_account.php",
          type: "POST",
          data: { current_password: current_pass, new_password: new_password },
          success: function (result) {
              result = result.trim();
              $("#password_form").trigger("reset");
              $("#change_password_btn").html("Please Wait..");
              $("#change_password_btn").html("disabled", false);
          },
      });
  }
}

// SUB CATEGORY
function change_main_category(sub_cate_id) {
  var category = $("#category_name").val();

  $.ajax({
      url: "sub_category.php",
      type: "post",
      data: { category_name: category, sub_cate_id: sub_cate_id },
      success: function (result) {
          result = result.trim();
          $("#sub_category").html(result);
      },
  });
}

// UPDATE USER ACCOUNT
function update_account() {
  var name = $("#name").val();
  var email = $("#email").val();
  var mobile = $("#mobile").val();
  var is_error = "";

  if (name == "") {
      $("#update_name").html("Please Enter Your Name");
      is_error = "yes";
  }
  if (email == "") {
      $("#update_email").html("Please Enter Your Email");
      is_error = "yes";
  }
  if (mobile == "") {
      $("#update_mobile").html("Please Enter Your Mobile");
      is_error = "yes";
  }
  $.ajax({
      url: "user_account.php",
      type: "POST",
      data: { name: name, email: email, mobile: mobile },
      success: function (result) {},
  });
}

//  COUPON APPLY
function apply_coupon() {
  $("#coupon_result").html("");
  var coupon_str = $("#coupon_str").val();

  if (coupon_str != "") {
      $.ajax({
          url: "coupon_apply.php",
          type: "post",
          data: { coupon_str: coupon_str },
          success: function (result) {
              result = result.trim();
              var data = $.parseJSON(result);
              if (data.is_error == "yes") {
                  $("#coupon_box_tr").hide();
                  $("#coupon_result").html(data.discount);
                  $("#order_total_price").html(data.result);
              }
              if (data.is_error == "no") {
                  $("#coupon_box_tr").show();
                  $("#coupon_price").html(data.discount);
                  $("#order_total_price").html(data.result);
              }
          },
      });
  }
}

// SEND EMAIL OTP
function email_send_otp() {
  $("#email_error").html("");
  var email = $("#email").val();

  alert(email);
  if (email == "") {
      $("#email_error").html("Plese Enter Your Email");
  } else {
      $("#send_otp").html("Plese wait..");
      $("#send_otp").attr("disabled", true);
      $.ajax({
          url: "send_otp.php",
          type: "post",
          data: "email=" + email + "&type=email",
          success: function (result) {
              result = result.trim();
              if (result == "done") {
                  $("#email").attr("disabled", true);
                  $(".email_ver_show").show();
                  $("#send_otp").hide();
              } else {
                  $("#send_otp").html("SEND OTP");
                  $("#send_otp").attr("disabled", false);
                  $("#email_error").html("Plese Try After Sometime");
              }
          },
      });
  }
}

function email_verify_otp() {
  $("#otp_unvalid").html("");
  $("#get_email_otp").html("");
  let email_otp = $("#email_verify").val();
  if (email_otp == "") {
      $("#get_email_otp").html("Plese Enter OTP");
  } else {
      $.ajax({
          url: "check_otp.php",
          type: "post",
          data: "otp=" + email_otp + "&type=email",
          success: function (Verified) {
              Verified = Verified.trim();
              if (Verified == "done") {
                  $(".email_ver_show").hide();
                  $("#verify_otp_result").html("<i class='fa-solid fa-circle-check text-success mt-2 px-1'></i> <span> Verified </span>");
                  $("#check_verify_otp").val("1");

                  if ($("#check_verify_otp").val() == 1) {
                      $("#registerbtn").attr("disabled", false);
                  }
              } else {
                  $("#otp_unvalid").html("Plese Enter Valid OTP");
              }
          },
      });
  }
}

// SMALL IMAGE SHOW IN PRODUCT DEATAIL PAGE
function showSmallImg(img) {
  $("#bigimg").html('<img src="' + img + '" class="img-fluid w-100" data-origin="' + img + '">');
  $("#bigimg").imgZoom();
}
$("#bigimg").imgZoom();

// PRODUCT RATING REVIEW

$("#rating_btn").on("click", () => {
  let rating = $("#rating").val();
  let review = $("#review").val();
  let is_error = "";

  if (rating == "") {
      $("#rating_error").html("Please Select A Rating");
      is_error = "yes";
  }

  if (review == "") {
      $("#review_error").html("Please Select A Rating");
      is_error = "yes";
  }

  $.ajax({
      url: "product-deatail.php",
      type: "post",
      data: { rating: rating, review: review },
      success: function () {},
  });
});
