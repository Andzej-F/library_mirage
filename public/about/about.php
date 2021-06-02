<?php
session_start();

require_once '../templates/header.php'; ?>

<h2>About the Project</h2>
<?php include_once '../templates/navigation.php'; ?>

<p class="about"><b>"Library Mirage"</b> is an ongoing portfolio web application project.
    It is being updated on a regular basis.</p>

<h2 class="about">Current project features:</h3>
    <ul class="about">
        <li><b>CRUD (create, read, update, delete)</b> model for managing "author", "book" and "reader account" data</li>
        <li><b>search</b> "book" option (available after login or registration)</li>
        <li><b>plain</b> PHP (no frameworks or libraries)</li>
        <li>main focus on the application's <b>back-end</b></li>
        <li><b>OOP</b> code style</li>
        <li>use <b>PDO</b> for database connection</li>
        <li><b>multi-user</b> ("librarian", "reader") login</li>
        <li><b>registration</b> option, available for "readers". Registered
            readers can:
            <ul class="about">
                <li><b>manage</b> their accounts(CRUD operations)</li>
                <li>see the <b>search field</b> on the main page</li>
            </ul>
    </ul>

    <h2 class="about">Upcoming updates:</h3>
        <ul class="about">
            <li>front page <b>automatic update</b> - 3 the most recent books added by "librarian" will automatically
                appear on the front page (now it's just a static content used to fill the space)</li>
            <li><b>"book cart"</b> option for the books taken by readers</li>
            <li>if I will come up with anything else, I will add it &#128521</li>
        </ul>

        <?php require_once '../templates/footer.php'; ?>