$(document).ready(function () {
  // 🌙 Theme Toggle with Icon Animation
  $("#themeToggle").change(function () {
    const icon = $("#modeIcon");
    icon.addClass("fade-out");

    setTimeout(() => {
      $("body").toggleClass("light-mode");
      const isLight = $("body").hasClass("light-mode");
      icon.text(isLight ? "☀️" : "🌙");
      icon.removeClass("fade-out").addClass("fade-in");

      setTimeout(() => {
        icon.removeClass("fade-in");
      }, 400);
    }, 200);
  });

  // ✏️ Open Edit Modal
  $(".edit-icon").click(function () {
    $("#edit_id").val($(this).data("id"));
    $("#edit_name").val($(this).data("name"));
    $("#edit_priority").val($(this).data("priority"));
    $("#editModal").fadeIn();
  });

  // ❌ Close Modal
  $("#editModal").click(function (e) {
    if (e.target.id === "editModal") $(this).fadeOut();
  });

  $("#closeModalBtn").click(function () {
    $("#editModal").fadeOut();
  });

  // 🎧 Sound Effects
  const addSound = document.getElementById("addSound");
  const doneSound = document.getElementById("doneSound");
  const updateSound = document.getElementById("updateSound");
  const deleteSound = document.getElementById("deleteSound");

  // ➕ Add Item with Sound
  $("form").on("submit", function (e) {
    if ($(this).attr("id") !== "editForm") {
      e.preventDefault();
      const form = this;
      addSound.currentTime = 0;
      addSound.play();
      setTimeout(() => {
        form.submit();
      }, 800); // Adjust based on your sound length
    }
  });

  // ✅ Done Sound then Redirect
  $("a[href*='action=done']").on("click", function (e) {
    e.preventDefault();
    const url = $(this).attr("href");
    doneSound.currentTime = 0;
    doneSound.play();
    doneSound.addEventListener("ended", () => {
      window.location.href = url;
    }, { once: true });
  });

  // 🗑️ Delete Sound then Redirect
  $("a[href*='action=delete']").on("click", function (e) {
    e.preventDefault();
    const url = $(this).attr("href");
    deleteSound.currentTime = 0;
    deleteSound.play();
    deleteSound.addEventListener("ended", () => {
      window.location.href = url;
    }, { once: true });
  });

  // ✏️ Update Task with Sound
  $("#editForm").on("submit", function (e) {
    e.preventDefault();
    const form = this;
    updateSound.currentTime = 0;
    updateSound.play();
    setTimeout(() => {
      form.submit();
    }, 800); // Adjust based on update sound duration
  });

  // 🔔 Fade out alerts
  setTimeout(() => {
    $(".alert").fadeOut(500);
  }, 3000);
});
