let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function () {
  sidebar.classList.toggle("active");
  if (sidebar.classList.contains("active")) {
    sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-left");
  } else sidebarBtn.classList.replace("bx-menu-alt-left", "bx-menu");
};

function view() {
  document.getElementById("a").setAttribute("style", "display:block");
}

(function ($) {
  "use strict";

  $(".content").each(function () {
    $(this).click(function () {
      if (!$(this).hasClass("active")) {
        $(".content").each(function () {
          $(this).removeClass("active");
        });
        $(".dashboard").each(function () {
          $(this).removeClass("active");
        });
        $(this).addClass("active");

        if ($(this).hasClass("active")) {
          if ($(this).hasClass("dash")) {
            $(".box-content.main.dashboard").addClass("active");
          }
          if ($(this).hasClass("home")) {
            $(".box-content.home.dashboard").addClass("active");
          }
          if ($(this).hasClass("patient")) {
            $(".box-content.patient.dashboard").addClass("active");
          }
          if ($(this).hasClass("schedule")) {
            $(".schedule.dashboard").addClass("active");
          }
          if ($(this).hasClass("reports")) {
            $(".reports.dashboard").addClass("active");
          }
          if ($(this).hasClass("camera")) {
            $(".camera.dashboard").addClass("active");
          }
          if ($(this).hasClass("appointments")) {
            $(".appointments.dashboard").addClass("active");
          }
        }
      }
    });
  });
})(jQuery);
