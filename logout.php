<?php

session_start();
session_unset();

session_destroy();

?>

<script>
    alert("Thanks for visiting DevConnect");
    window.location.href = "authentication_form.php";
</script>