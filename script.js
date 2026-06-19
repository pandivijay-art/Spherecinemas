function validateLogin() {
  let email = document.getElementById("email").value;
  let password = document.getElementById("password").value;

  if (email === "" || password === "") {
    alert("Please fill all fields");
    return false;
  }

  alert("Login success");
  return true;
}