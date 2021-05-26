<?php require '../templates/header.php'; ?>

<h2>About the Project</h2>
<?php include '../templates/navigation.php'; ?>

<p class="about"><b>"Library Mirage"</b> is an ongoing portfolio web application project.
    It is being updated on a regular basis.</p>

<h2 class="about">Current project features:</h3>
    <ul class="about">
        <li><b>CRUD</b> model for managing authors and books data</li>
        <li><b>search</b> book option(available after login or registration)</li>
        <li><b>plain</b> PHP (no frameworks or libraries)</li>
        <li>main focus on the application's <b>back-end</b></li>
        <li><b>OOP</b> code style</li>
        <li>use <b>PDO</b> for database connection</li>
        <li><b>multi-user</b> (librarian, reader) login</li>
    </ul>

    <h2 class="about">Upcoming updates:</h3>
        <ul class="about">
            <li>front page <b>automatic update</b> - 3 the most recent books added by librarian will automatically
                appear on the front page (now it's just a static content used to fill the space)</li>
            <li><b>"book cart"</b> option for the books taken by readers</li>
            <li>if I will come up with anything else, I will add it &#128521</li>
        </ul>

        <?php require '../templates/footer.php'; ?>