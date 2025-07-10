$(document).ready(function () {

  // Check localStorage for theme
    if (localStorage.getItem('theme') === 'light') {
        $('body').addClass('light-mode');
        $('#themeToggle').prop('checked', true);
        $('#modeIcon').text('☀️');
    }

    // Toggle theme
    $('#themeToggle').change(function () {
        $('body').toggleClass('light-mode');
        const isLight = $('body').hasClass('light-mode');
        $('#modeIcon')
            .removeClass('fade-in fade-out')
            .addClass('fade-out');
        
        setTimeout(() => {
            $('#modeIcon')
                .text(isLight ? '☀️' : '🌙')
                .removeClass('fade-out')
                .addClass('fade-in');
        }, 250);

        // Save preference
        localStorage.setItem('theme', isLight ? 'light' : 'dark');
    });


  // ✏️ Edit modal
  $(".edit-icon").click(function () {
    $("#edit_id").val($(this).data("id"));
    $("#edit_name").val($(this).data("name"));
    $("#edit_priority").val($(this).data("priority"));
    $("#editModal").fadeIn();
  });

  $("#editModal").click(function (e) {
    if (e.target.id === "editModal") $(this).fadeOut();
  });

  $("#closeModalBtn").click(function () {
    $("#editModal").fadeOut();
  });

  // 🔉 Sound Effects
  const addSound = document.getElementById("addSound");
  const doneSound = document.getElementById("doneSound");
  const updateSound = document.getElementById("updateSound");
  const deleteSound = document.getElementById("deleteSound");

  $("form").on("submit", function (e) {
    if ($(this).attr("id") !== "editForm") {
      e.preventDefault();
      const form = this;
      addSound.currentTime = 0;
      addSound.play();
      setTimeout(() => {
        form.submit();
      }, 800);
    }
  });

  $("a[href*='action=done']").on("click", function (e) {
    e.preventDefault();
    const url = $(this).attr("href");
    doneSound.currentTime = 0;
    doneSound.play();
    doneSound.addEventListener("ended", () => {
      window.location.href = url;
    }, { once: true });
  });

  $("a[href*='action=delete']").on("click", function (e) {
    e.preventDefault();
    const url = $(this).attr("href");
    deleteSound.currentTime = 0;
    deleteSound.play();
    deleteSound.addEventListener("ended", () => {
      window.location.href = url;
    }, { once: true });
  });

  $("#editForm").on("submit", function (e) {
    e.preventDefault();
    const form = this;
    updateSound.currentTime = 0;
    updateSound.play();
    setTimeout(() => {
      form.submit();
    }, 800);
  });

  // ⏳ Auto-hide alert
  setTimeout(() => {
    $(".alert").fadeOut(500);
  }, 3000);
});
