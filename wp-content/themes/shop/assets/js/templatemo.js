/*

TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

*/

"use strict";
$(document).ready(function () {
  // Accordion
  var all_panels = $(".templatemo-accordion > li > ul").hide();

  $(".templatemo-accordion > li > a").click(function () {
    console.log("Hello world!");
    var target = $(this).next();
    if (!target.hasClass("active")) {
      all_panels.removeClass("active").slideUp();
      target.addClass("active").slideDown();
    }
    return false;
  });
  // End accordion

  // Product detail
  $(".product-links-wap a").click(function () {
    var this_src = $(this).children("img").attr("src");
    $("#product-detail").attr("src", this_src);
    return false;
  });
  $(document).on("click", ".btn-minus", function () {
    var parent = $(this)?.parents(".col-auto");
    var val = parent?.find("#var-value").html();
    val = val == "1" ? val : val - 1;
    parent?.find("#var-value").html(val);
    $(this)?.parent()?.parent()?.find("input")?.val(val);
    parent.find(".woo-input-quantity").val(val);
    parent.find(".woo-input-quantity").trigger("change");
    return false;
  });
  $(document).on("click", ".btn-plus", function () {
    var parent = $(this)?.parents(".col-auto");
    var val = parent?.find("#var-value").html();
    val++;
    parent?.find("#var-value").html(val);
    $(this)?.parent()?.parent()?.find("input")?.val(val);
    parent.find(".woo-input-quantity").val(val);
    parent.find(".woo-input-quantity").trigger("change");
    // $("#product-quanity").val(val);
    return false;
  });
  $(".btn-size").click(function () {
    var this_val = $(this).html();
    $("#product-size").val(this_val);
    $(".btn-size").removeClass("btn-secondary");
    $(".btn-size").addClass("btn-success");
    $(this).removeClass("btn-success");
    $(this).addClass("btn-secondary");
    return false;
  });
  // End roduct detail
});
