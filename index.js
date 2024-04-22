// Function to clear error messages
function clearError() { 
  const errors = document.getElementsByClassName("formError");
  // Loop through each error element and clear its content
  for (let err of errors){
      err.textContent = "";
  }
}

// Function to set error message for a specific form element
function setError(id, error) {
  const element = document.getElementById(id);
  const errorElement = element.querySelector(".formError");
  // If error element exists, set its content to the error message
  if (errorElement) {
      errorElement.textContent = error;
  }
}

// Function to validate the form
function validateForm() {
  // Clear any existing error messages
  clearError();

  // Get form input values
  const firstName = document.forms["userInfo"]["fname"].value.trim();
  const lastName = document.forms["userInfo"]["lname"].value.trim();
  const username = document.forms["userInfo"]["username"].value.trim();
  const email = document.forms["userInfo"]["femail"].value.trim();
  const mobile = document.forms["userInfo"]["mobile"].value.trim();
  const password = document.forms["userInfo"]["password"].value.trim();
  const confirmPassword = document.forms["userInfo"]["cpassword"].value.trim();
  const nameRegex = /^[a-zA-Z]+$/;
  const emailRegex =  /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  const mobileRegex = /^\d{10}$/;
  const usernameRegex = /^(?=.*\d)[0-9a-zA-Z]*$/;

  // Validate first name
  if (firstName.length < 5 || firstName.length > 25 || !nameRegex.test(firstName)) {
      setError("firstname", "First Name is invalid.");
      return false;
  }

  // Validate last name
  if (lastName.length > 25 || !nameRegex.test(lastName)) {
      setError("lastname", "Last Name is invalid.");
      return false;
  }

  // Validate username
  if (!usernameRegex.test(username)) {
      setError("uname", "Username must contain at least one number.");
      return false;
  }

  // Validate email
  if (!emailRegex.test(email)) {
      setError("email", "Email address is invalid.");
      return false;
  }

  // Validate mobile number
  if (!mobileRegex.test(mobile) || mobile.length !== 10) {
      setError("mobile", "Mobile Number is invalid.");
      return false;
  }

  // Validate password
  if (password.length === 0 || confirmPassword.length === 0) {
      setError("cpass", "Password must be filled out.");
      return false;
  }

  // Validate password match
  if (password !== confirmPassword) {
      setError("cpass", "Passwords do not match.");
      return false;
  }

  // Other validations...

  // Validation passed
  return true;
}
