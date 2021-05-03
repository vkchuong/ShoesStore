function sendEmail() {
  document.getElementById("contactform").action = "mailto:info@sportsstore.com";
}

var quantity = 1;
var price = $(".subtotal .price").html().substring(1);
var total = quantity * price;

// form validation
$(document).ready(function () {
  $("#orderform").submit(function (event) {
    event.preventDefault();
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var adr = $("#adr").val();
    var city = $("#city").val();
    var state = $("#state").val();
    var zip = $("#zip").val();
    var method = $("#method").val();
    var pid = $("#pid").val();
    var quantity = $("#quantity").val();
    var cardname = $("#cname").val();
    var cardnumber = $("#ccnum").val();
    var expmonth = $("#expmonth").val();
    var expyear = $("#expyear").val();
    var cvv = $("#cvv").val();
    var submit = $("#order-submit").val();
    $(".form-message").load("./php/insert.php", {
      firstname: fname,
      lastname: lname,
      email: email,
      phone: phone,
      address: adr,
      city: city,
      state: state,
      zip: zip,
      method: method,
      productid: pid,
      submit: submit,
      quantity: quantity,
      cardname: cardname,
      cardnumber: cardnumber,
      expmonth: expmonth,
      expyear: expyear,
      cvv: cvv,
    });
  });
});

// using jQuery and Ajax for form autocomplete
$(document).ready(function () {
  var taxRate = 0;
  var shipping = 9.5;

  $("#state").keyup(function () {
    var query = $(this).val();
    if (query != "") {
      $.ajax({
        url: "./php/searchState.php",
        method: "POST",
        data: {
          query: query,
        },
        success: function (data) {
          $("#stateList").fadeIn();
          $("#stateList").html(data);
        },
      });
    }
  });
  $(document).on("click", "li", function () {
    $("#state").val($(this).text());
    $("#stateList").fadeOut();
  });

  $("#zip").keyup(function () {
    var query = $(this).val();
    if (query != "") {
      $.ajax({
        url: "./php/searchTaxRate.php",
        method: "POST",
        data: {
          query: query,
        },
        success: function (data) {
          $("#tax-rate").fadeIn();
          $("#tax-rate").html(data);
          taxRate = parseFloat(data).toFixed(3);
          $("#tax-amount").html((total * taxRate).toFixed(2));
        },
      });
    }
  });

  $("#method").change(function () {
    var choice = $(this).val();
    if (choice == "Overnight ($11.00)") {
      shipping = 11.0;
    }
    if (choice == "2-day expedited ($9.50)") {
      shipping = 9.5;
    }
    if (choice == "7-day ground ($6.25)") {
      shipping = 6.25;
    }
  });

  $(document).mouseover(function () {
    $("#total-price").html(total.toFixed(2));
    $("#tax-amount").html((total * taxRate).toFixed(2));

    let final = total + total * taxRate + shipping;
    $("#shipping").html(shipping.toFixed(2));
    $("#final-price").html(final.toFixed(2));
    $("input[id=totalPrice]").val(final.toFixed(2));
  });

  // billing address
  $("#billing-address").hide();

  $("#same-address").change(function () {
    $("#billing-address").slideToggle();
  });
});
