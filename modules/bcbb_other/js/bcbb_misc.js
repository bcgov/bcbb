/**
 * @file
 * Miscellaneous JS that can safely be on every page.
 */

/*jslint browser indent2 long*/

(function (document) {

  /**
   * Event listener for DOMContentLoaded.
   */
  document.addEventListener("DOMContentLoaded", function () {
    var width;

    // On wide windows, open `details` elements with class `bcbb-desktop-open`.
    const open_details = function () {
      if (window.matchMedia("(min-width: 992px)").matches) {
        document.querySelectorAll("details.bcbb-desktop-open").forEach(function (details) {
          details.open = true;
        });
      }
    };
    // Run above on page load.
    open_details();
    // Run the above when the window width changes.
    width = window.innerWidth;
    window.addEventListener("resize", function () {
      if (window.innerWidth !== width) {
        width = window.innerWidth;
        open_details();
      }
    });
  });

}(document));
