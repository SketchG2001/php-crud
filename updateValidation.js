function clearError() { 
    const errors = document.getElementsByClassName("formError");
    for (let err of errors){
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
    const nameRegex = /^[a-zA-Z]+$/;
    const emailRegex =  /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    


    const mobileRegex = /^\d{10}$/;
    const usernameRegex = /^[0-9a-zA-Z]+$/;

    if (firstName.length < 5 || firstName.length > 25 || !nameRegex.test(firstName)) {
        setError("firstname", "First Name is invalid.");
        return false;
    }

    if (lastName.length > 25 || !nameRegex.test(lastName)) {
        setError("lastname", "Last Name is invalid.");
        return false;
    }

    if (!usernameRegex.test(username)) {
        setError("uname", "Username is invalid.");
        return false;
    }

    if (!emailRegex.test(email)) {
        setError("email", "Email address is invalid.");
        return false;
    }

    if (!mobileRegex.test(mobile) || mobile.length !== 10) {
        setError("mobile", "Mobile Number is invalid.");
        return false;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const currentDate = new Date().toISOString().slice(0, 10);
        const dateInput = document.getElementById("datefield");
        dateInput.value = currentDate;
      });

    const maleRadio = document.getElementById('maleradio');
    const femaleRadio = document.getElementById('femaleradio');
    const genderError = document.getElementById('genderError');

    if (!maleRadio.checked && !femaleRadio.checked) {
        genderError.textContent = 'Please select your gender';
        return false;
    }

    const ageInput = document.getElementById('age');
    const ageValue = document.getElementById("ageValue");
    const ageError = document.getElementById("ageError")

    ageInput.addEventListener('input', function(){
        ageValue.textContent = ageInput.value;
    });
    const age = parseInt(ageInput.value);
    if (age < 18){
        ageError.textContent = "age must be greater than 18.";
        return false
    }
    if (age > 100){
        ageError.textContent = "age must be between 18 to 100";
        return false;
    }
    const adminSwitch = document.getElementById("adminSwitch");
    const userSwitch = document.getElementById("userSwitch");
    const userAdminError = document.getElementById('useradminError');

    if (!adminSwitch.checked && !userSwitch.checked) {
        userAdminError.textContent = "Please select your account type";
        return false;
    }

   
    const dropdown = document.getElementById("skills");
    const selectedValue = dropdown.options[dropdown.selectedIndex].value;
    const skillError = document.getElementById('skillError');
    if (selectedValue === 'non') {
        skillError.textContent = "Please select your skill";
        return false;
    }
    

    // Validation passed
    return true;
}
