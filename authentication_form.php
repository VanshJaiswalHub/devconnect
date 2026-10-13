<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DevConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body class ="auth-page">

    <div class="auth-box">

        <!-- Brand -->

        <div class="brand">
            <div class="brand-title">
                <img src="assets/images/logo.png" alt="DevConnect logo">
                <h1>DevConnect</h1>
            </div>
            <p>Connect. Build. Grow.</p>
        </div>

        <!-- ================= REGISTER ================= -->

        <div id="registerbox">

            <h2>Register your account</h2>

            <form action="register_process.php" method="POST" id="registerForm">


                <!-- Username -->

                <div class="form-group">

                    <label for="username"> Username </label>


                    <input type="text" name="username" id="username" placeholder="Enter username" required>

                </div>


                <!-- Email -->

                <div class="form-group">

                    <label for="register-email"> Email Address </label>

                    <input type="email" name="email" id="register-email" placeholder="Enter email" required>

                </div>


                <!-- Password -->

                <div class="form-group">

                    <label for="register-password"> Password </label>

                    <div class="password-wrapper">

                        <input type="password" name="password" id="register-password" placeholder="Create a password"  minlength="7" maxlength="20" required>

                        <button type="button" class="show-password" id="show-register-password"> Show </button>

                    </div>

                    <div id="password-message"></div>

                </div>


                <!-- Developer Role -->

                <div class="form-group">

                    <label for="developer_role">
                        Developer Role
                    </label>

                    <select name="developer_role" id="developer_role" required>

                        <option value="">
                            Select your role
                        </option>

                        <option value="PHP Developer">
                            PHP Developer
                        </option>

                        <option value="Web Developer">
                            Web Developer
                        </option>

                        <option value="Frontend Developer">
                            Frontend Developer
                        </option>

                        <option value="Backend Developer">
                            Backend Developer
                        </option>

                        <option value="Full Stack Developer">
                            Full Stack Developer
                        </option>

                        <option value="Game Developer">
                            Game Developer
                        </option>

                    </select>

                </div>


                <!-- Experience -->

                <div class="form-group">

                    <label> Do you have professional development experience? </label>


                    <div class="experience-options">

                        <label class="experience-option">

                            <input type="radio" name="has_experience" value="yes" required> Yes

                        </label>


                        <label class="experience-option">

                            <input type="radio" name="has_experience" value="no"> No

                        </label>

                    </div>

                </div>


                <!-- Experience Years -->

                <div class="form-group" id="experience-years-group">

                    <label for="experience_years">
                        Years of experience
                    </label>

                    <select name="experience_years" id="experience_years">

                        <option value="">
                            Select experience
                        </option>

                        <option value="1">
                            1 year
                        </option>

                        <option value="2">
                            2 years
                        </option>

                        <option value="3">
                            3 years
                        </option>

                        <option value="4">
                            4 years
                        </option>

                        <option value="5">
                            5+ years
                        </option>

                    </select>

                </div>


                <button type="submit" id="btnRegister">
                    Create Account
                </button>


                <div class="switcher">

                    Already registered?

                    <a href="#" id="switch-to-login" class="switch-link">
                        Login
                    </a>

                </div>

            </form>

        </div>


        <!-- ================= LOGIN ================= -->

        <div id="loginbox">

            <h2>Welcome back</h2>

            <form action="login_process.php" method="POST">

                <div class="form-group">
                    <label for="login-email">Email Address</label>
                    <input type="email" name="email" id="login-email" placeholder="Enter email" required>
                </div>

                <div class="form-group">

                    <label for="login-password"> Password </label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="login-password" placeholder="Enter password"
                            required>
                        <button type="button" class="show-password" id="show-login-password">Show</button>
                    </div>

                </div>


                <button type="submit">Login </button>


                <div class="switcher">

                    Don't have an account?

                    <a href="#" id="switch-to-register" class="switch-link"> Register </a>

                </div>

            </form>

        </div>

    </div>

    <div
        class="modal fade"
        id="confirmRegistrationModal"
        tabindex="-1"
        aria-labelledby="confirmRegistrationModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="confirmRegistrationModalLabel">
                        <strong>Confirm Your Details</strong>
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">

                    <p>
                        Please review your details before creating your DevConnect account.
                    </p>

                    <div class="mb-3">
                        <strong>Username:</strong>
                        <span id="confirmUsername"></span>
                    </div>

                    <div class="mb-3">
                        <strong>Email:</strong>
                        <span id="confirmEmail"></span>
                    </div>

                    <div class="mb-3">
                        <strong>Developer Role:</strong>
                        <span id="confirmDeveloperRole"></span>
                    </div>

                    <div class="mb-3">
                        <strong>Experience:</strong>
                        <span id="confirmExperience"></span>
                    </div>

                    <div class="alert alert-warning mb-0">
                        Please make sure your email and password are correct.
                        You will need these credentials for future logins.
                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-primary"
                        data-bs-dismiss="modal"
                    >
                        No, Edit Details
                    </button>

                    <button
                        type="button"
                        class="btn btn-primary"
                        id="confirmRegistrationBtn"
                    >
                        Confirm & Create Account
                    </button>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        // ==========================
        // LOGIN / REGISTER SWITCH
        // ==========================

        const switchToLogin =
            document.getElementById("switch-to-login");

        const switchToRegister =
            document.getElementById("switch-to-register");

        const registerBox =
            document.getElementById("registerbox");

        const loginBox =
            document.getElementById("loginbox");


        switchToLogin.addEventListener("click", function (event) {

            event.preventDefault();

            registerBox.style.display = "none";
            loginBox.style.display = "block";

        });


        switchToRegister.addEventListener("click", function (event) {

            event.preventDefault();

            registerBox.style.display = "block";
            loginBox.style.display = "none";

        });

        if (window.location.hash === "#loginbox") {
            registerBox.style.display = "none";
            loginBox.style.display = "block";
        }


        // ==========================
        // EXPERIENCE
        // ==========================

        const experienceOptions =
            document.querySelectorAll(
                'input[name="has_experience"]'
            );

        const experienceYearsGroup =
            document.getElementById(
                "experience-years-group"
            );

        const experienceYears =
            document.getElementById(
                "experience_years"
            );


        experienceOptions.forEach(function (option) {

            option.addEventListener("change", function () {

                if (this.value === "yes") {

                    experienceYearsGroup.style.display = "block";

                    experienceYears.required = true;

                } else {

                    experienceYearsGroup.style.display = "none";

                    experienceYears.required = false;

                    experienceYears.value = "";

                }

            });

        });


        // ==========================
        // SHOW / HIDE PASSWORD
        // ==========================

        function setupPasswordToggle(buttonId, inputId) {

            const button = document.getElementById(buttonId);

            const input = document.getElementById(inputId);


            button.addEventListener("click", function () {

                if (input.type === "password") {

                    input.type = "text";

                    button.textContent = "Hide";

                } else {

                    input.type = "password";

                    button.textContent = "Show";

                }

            });

        }


        setupPasswordToggle(
            "show-register-password",
            "register-password"
        );


        setupPasswordToggle(
            "show-login-password",
            "login-password"
        );

        // Password Length Validation

        const passwordInput =
        document.getElementById("register-password");

        const passwordMessage =
        document.getElementById("password-message");


        passwordInput.addEventListener("input", function() {

        const passwordLength = passwordInput.value.length;

        if (passwordLength === 0) {

            passwordMessage.textContent = "";

        } else if (passwordLength < 7

        ) {

            passwordMessage.textContent =
                "Password is too short. Use at least 7 characters.";

        } else if (passwordLength > 20) {

            passwordMessage.textContent =
                "Password is too long. Maximum 20 characters allowed.";

        } else {

            passwordMessage.textContent =
                "Password length is valid.";

        }

        });

        //Confirmation Modal for Registration


        const registerForm = document.getElementById("registerForm");

        const confirmRegistrationModal =
            new bootstrap.Modal(
                document.getElementById("confirmRegistrationModal")
            );

        const confirmRegistrationBtn =
            document.getElementById("confirmRegistrationBtn");


        registerForm.addEventListener("submit", function(event) {

            event.preventDefault();

            const username =
                document.getElementById("username").value.trim();

            const email =
                document.getElementById("register-email").value.trim();

            const developerRole =
                document.getElementById("developer_role").value;

            const experienceYears =
                document.getElementById("experience_years").value;


            document.getElementById("confirmUsername").textContent =
                username;

            document.getElementById("confirmEmail").textContent =
                email;

            document.getElementById("confirmDeveloperRole").textContent =
                developerRole;

            document.getElementById("confirmExperience").textContent =
                experienceYears == 0
                    ? "No experience"
                    : experienceYears + " year(s)";


            confirmRegistrationModal.show();

        });

        confirmRegistrationBtn.addEventListener("click", function() {

        registerForm.submit();

        });

    </script>

</body>

</html>