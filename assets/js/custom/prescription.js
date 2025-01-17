$(document).ready(function () {
  "use strict";
  $(document).on("change", "#user_id", function () {
    let patientId = $("#user_id").val();
    let url = window.location.href.split(/[?#]/)[0];
    window.location.href = url + "?user_id=" + patientId;

  });

  let medicine = $("#medicine").html();
  $(document).on("click", ".m-add", function () {
    $("#medicine").append(medicine);
  });

  $(document).on("click", ".m-remove", function () {
    $(this).parent().parent().remove();
  });

  let diagnosis = $("#diagnosis").html();
  $(document).on("click", ".d-add", function () {
    $("#diagnosis").append(diagnosis);
  });

  $(document).on("click", ".d-remove", function () {
    $(this).parent().parent().remove();
  });

  // Get the base URL from the meta tag
  var baseUrl = $('meta[name="base-url"]').attr("content");

  // When the medicine type dropdown changes
  $("body").on("change", 'select[name="medicine_type[]"]', function () {
    var medicineTypeId = $(this).val();
    var $medicineNameDropdown = $(this)
      .closest("tr")
      .find('select[name="medicine_name[]"]');

    // Clear the medicine name dropdown
    $medicineNameDropdown.empty();

    // Make an AJAX request to fetch medicines by type
    $.ajax({
      url: baseUrl + "/getmedicinestype/" + medicineTypeId,
      type: "GET",
      success: function (data) {
        // Populate the medicine name dropdown with the received data
        $.each(data, function (key, value) {
          $medicineNameDropdown.append(
            '<option value="' + value.id + '">' + value.name + "</option>"
          );
        });
        if (data.length > 0) {
            $medicineNameDropdown.val(data[0].id).trigger('change');
        }
      },
    });
  });


  $("body").on("change", 'select[name="medicine_name[]"]', function () {
    console.log('dd');
    var medicineId = $(this).val();
    var $descriptionField = $(this)
        .closest("tr")
        .find('input[name="medicine_description[]"]');

    // Clear the description field
    $descriptionField.val("");

    // Make an AJAX request to fetch the medicine description by medicine ID
    $.ajax({
        url: baseUrl + "/getmedicinedescription/" + medicineId,
        type: "GET",
        success: function (data) {
            // Populate the description field with the received data
            if (data && data.description) {
                $descriptionField.val(data.description);
            }
        },
    });
});
});
