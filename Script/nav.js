document.addEventListener("DOMContentLoaded", () => {
  checkLoginState();
});

function checkLoginState() {
  fetch("check_session.php")
    .then((response) => response.json())
    .then((data) => {
      const container = document.getElementById("loginStateContainer");

      if (data.isLoggedIn) {
        container.innerHTML = `
                    <div class="dropdown me-3">
                        <div class="d-flex align-items-center">
                            <span class="navbar-text me-3">
                                Hello, ${data.username}
                            </span>
                            <a href="../login/logout.php" class="btn btn-light">Logout</a>
                        </div>
                    </div>
                `;
      } else {
        container.innerHTML = `
                    <a href="../login" class="btn btn-outline-success me-2">Masuk</a>
                    <a href="../login/register.php" class="btn btn-success">Daftar</a>
                `;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      const container = document.getElementById("loginStateContainer");
      container.innerHTML = `
                <a href="../login" class="btn btn-outline-success me-2">Masuk</a>
                <a href="../login/register.php" class="btn btn-success">Daftar</a>
            `;
    });
}

//style hero section

new Typed('#typed-text', {
  strings: ['The Aborigin', '3Didaw', 'Binary Bites'],
  typeSpeed: 50,
  backSpeed: 30,
  loop: true
});
