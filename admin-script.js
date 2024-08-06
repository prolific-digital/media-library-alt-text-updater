jQuery(document).ready(function ($) {
  $("#atu-scan-button").on("click", function () {
    $.ajax({
      url: ajaxurl,
      method: "POST",
      data: {
        action: "atu_scan_images",
      },
      success: function (response) {
        if (response.success) {
          var results = response.data;
          var resultHtml = "<h2>Scan Results:</h2>";
          resultHtml +=
            "<p>Total Pages with Missing Alt Text: " +
            results.total_pages_with_missing_alt +
            "</p>";
          resultHtml +=
            "<p>Total Images with Missing Alt Text: " +
            results.total_images_with_missing_alt +
            "</p>";
          resultHtml +=
            "<p>Images with Alt Text in Media Library: " +
            results.images_with_alt_in_media_library +
            "</p>";
          resultHtml += "<h3>Details:</h3>";
          if (results.details.length === 0) {
            resultHtml += "<p>No images with missing alt text found.</p>";
          } else {
            resultHtml += "<ul>";
            results.details.forEach(function (result) {
              resultHtml +=
                "<li>Image ID: " +
                result.image_id +
                ' - Page: <a href="' +
                result.page_permalink +
                '" target="_blank">' +
                result.page_title +
                "</a></li>";
            });

            console.log(results);
            resultHtml += "</ul>";
          }
          $("#atu-scan-results").html(resultHtml);
        } else {
          alert("Scan failed: " + response.data);
        }
      },
    });
  });

  $("#atu-update-button").on("click", function () {
    $.ajax({
      url: ajaxurl,
      method: "POST",
      data: {
        action: "atu_update_pages_with_image_alt_text",
      },
      success: function (response) {
        if (response.success) {
          var updatedCount = response.data.updated_count;
          var resultHtml = "<h2>Update Results:</h2>";
          resultHtml +=
            "<p>Alt text updated for " +
            response.data.updated_pages.length +
            " pages.</p>";
          $("#atu-update-results").html(resultHtml);
        } else {
          alert("Update failed: " + response.data);
        }
      },
    });
  });
});
