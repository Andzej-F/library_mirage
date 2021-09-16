<?php
session_start();

require_once '../templates/header.php'; ?>

<h2>About the Project</h2>
<?php include_once '../templates/navigation.php'; ?>

<p class="about"><b>"Library Mirage"</b> is a portfolio web application project.
</p>

<h2 class="about">Current project features:</h3>
    <ul class="about">
        <li><b>CRUD (create, read, update, delete)</b> model for managing "author", "book" and "reader account" data</li>
        <li><b>search</b> "book" option (available after login or registration)</li>
        <li><b>plain</b> PHP (no frameworks or libraries used)</li>
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
    <?php require_once '../templates/footer.php'; ?>