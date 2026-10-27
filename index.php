<?php

include "db.php";


/* ADD CONTACT */

if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $sql = "INSERT INTO contacts (name, phone, email)
            VALUES ('$name', '$phone', '$email')";

    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit();
}


/* DELETE CONTACT */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM contacts WHERE id=$id"
    );

    header("Location: index.php");
    exit();
}


/* EDIT CONTACT */

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $sql = "UPDATE contacts
            SET name='$name',
                phone='$phone',
                email='$email'
            WHERE id=$id";

    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit();
}


/* GET CONTACT FOR EDIT */

$editContact = null;

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM contacts WHERE id=$id"
    );

    $editContact = mysqli_fetch_assoc($result);
}


/* GET ALL CONTACTS */

$result = mysqli_query(
    $conn,
    "SELECT * FROM contacts ORDER BY id DESC"
);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Contact Management</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">

</head>


<body>

<div class="container">


    <!-- HEADING -->

    <h1>Contact Management</h1>

    <p class="subtitle">
        Add and manage your contacts easily.
    </p>


    <!-- FORM -->

    <div class="form-box">

        <?php if ($editContact) { ?>

            <h2>Edit Contact</h2>

        <?php } else { ?>

            <h2>Add Contact</h2>

        <?php } ?>


        <form method="POST" onsubmit="return validateForm()">


            <?php if ($editContact) { ?>

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $editContact['id']; ?>"
                >

            <?php } ?>


            <label>Name</label>

            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter name"
                value="<?php
                    echo $editContact
                    ? htmlspecialchars($editContact['name'])
                    : '';
                ?>"
            >


            <label>Phone</label>

            <input
                type="text"
                id="phone"
                name="phone"
                placeholder="Enter phone number"
                value="<?php
                    echo $editContact
                    ? htmlspecialchars($editContact['phone'])
                    : '';
                ?>"
            >


            <label>Email</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter email"
                value="<?php
                    echo $editContact
                    ? htmlspecialchars($editContact['email'])
                    : '';
                ?>"
            >


            <?php if ($editContact) { ?>

                <button type="submit" name="update">
                    Update Contact
                </button>

                <a href="index.php" class="cancel">
                    Cancel
                </a>

            <?php } else { ?>

                <button type="submit" name="add">
                    Add Contact
                </button>

            <?php } ?>


        </form>

    </div>


    <!-- SEARCH -->

    <div class="search">

        <input
            type="text"
            id="search"
            placeholder="Search contact..."
            onkeyup="searchContact()"
        >

    </div>


    <!-- CONTACT LIST -->

    <div class="contacts">

        <h2>My Contacts</h2>


        <?php

        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

        ?>


        <div class="contact-card">


            <div>

                <h3>
                    <?php echo htmlspecialchars($row['name']); ?>
                </h3>

                <p>
                    Phone:
                    <?php echo htmlspecialchars($row['phone']); ?>
                </p>

                <p>
                    Email:
                    <?php echo htmlspecialchars($row['email']); ?>
                </p>

            </div>


            <div class="buttons">

                <a
                    href="?edit=<?php echo $row['id']; ?>"
                    class="edit"
                >
                    Edit
                </a>


                <a
                    href="?delete=<?php echo $row['id']; ?>"
                    class="delete"
                    onclick="return deleteContact()"
                >
                    Delete
                </a>

            </div>


        </div>


        <?php

            }

        } else {

        ?>

            <p class="no-contact">
                No contacts available.
            </p>

        <?php } ?>


    </div>


    <footer>

        Contact Management System

    </footer>


</div>


<script src="script.js"></script>

</body>

</html>