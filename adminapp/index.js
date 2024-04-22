function clearError() {
  const errors = document.getElementsByClassName("formError");
  for (let err of errors) {
      err.textContent = "";
  }
}

function setError(id, error) {
  const element = document.getElementById(id);
  const errorElement = element.querySelector(".formError");
  if (errorElement) {
      errorElement.textContent = error;
  }
}

function validateForm() {
  clearError();

  const firstName = document.forms["userInfo"]["fname"].value.trim();
  const lastName = document.forms["userInfo"]["lname"].value.trim();
  const username = document.forms["userInfo"]["username"].value.trim();
  const email = document.forms["userInfo"]["femail"].value.trim();
  const mobile = document.forms["userInfo"]["mobile"].value.trim();
  const password = document.forms["userInfo"]["password"].value.trim();
  const confirmPassword = document.forms["userInfo"]["cpassword"].value.trim();

  const nameRegex = /^[a-zA-Z]+$/;
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const mobileRegex = /^\d{10}$/;
  const usernameRegex = /^(?=.*\d)[0-9a-zA-Z]+$/;

  if (firstName.length < 5 || firstName.length > 25 || !nameRegex.test(firstName)) {
      setError("firstname", "First Name is invalid.");
      return false;
  }

  if (lastName.length > 25 || !nameRegex.test(lastName)) {
      setError("lastname", "Last Name is invalid.");
      return false;
  }

  if (!usernameRegex.test(username)) {
      setError("uname", "Username must contain at least one number.");
      return false;
  }

  if (!emailRegex.test(email)) {
      setError("email", "Email address is invalid.");
      return false;
  }

  // Check if mobile number passes the regular expression test
  if (!mobileRegex.test(mobile)) {
      setError("mobile", "Mobile Number is invalid.");
      return false;
  }

  // Check if mobile number has exactly 10 digits
  if (mobile.length !== 10) {
      setError("mobile", "Mobile Number must contain exactly 10 digits.");
      return false;
  }

  if (password.length === 0 || confirmPassword.length === 0) {
      setError("cpass", "Password must be filled out.");
      return false;
  }

  if (password !== confirmPassword) {
      setError("cpass", "Passwords do not match.");
      return false;
  }

  // Other validations...

  // Validation passed
  return true;
}
