  <?php
 //host,user,password,database
$mysqli = new mysqli("localhost", "user", "password", "database");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* prepare statement */
if ($stmt = $mysqli->prepare("SELECT Code, Name FROM country WHERE Code LIKE ? LIMIT 15")) {

    $stmt->bind_param("s", $code);
    $code = "C%";

    $stmt->execute();

    /* bind variables to prepared statement */
    $stmt->bind_result($col1, $col2);

    /* fetch values */
    while ($stmt->fetch()) {
        printf("%s %s<br />\n", $col1, $col2);
    }

    /* close statement */
    $stmt->close();
}
/* close connection */
$mysqli->close();

?> 