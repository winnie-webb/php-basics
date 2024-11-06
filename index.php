<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation Example</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</head>
<body>

<form id="myForm">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Submit</button>
</form>

<script>
$(document).ready(function() {
    $('#myForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            name: {
                required: "Please enter your name.",
                minlength: "Your name must be at least 2 characters long."
            },
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address."
            },
            password: {
                required: "Please provide a password.",
                minlength: "Your password must be at least 6 characters long."
            }
        },
        submitHandler: function(form) {
            form.submit(); // Submit the form if validation passes
        }
    });
});
</script>

</body>
</html>
