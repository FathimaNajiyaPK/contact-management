function validateForm() {

    let name = document.getElementById("name").value;
    let phone = document.getElementById("phone").value;

    if (name.trim() === "") {

        alert("Please enter the name.");

        return false;
    }

    if (phone.trim() === "") {

        alert("Please enter the phone number.");

        return false;
    }

    return true;
}


function deleteContact() {

    let answer = confirm(
        "Are you sure you want to delete this contact?"
    );

    return answer;
}


function searchContact() {

    let search = document
        .getElementById("search")
        .value
        .toLowerCase();

    let contacts = document.getElementsByClassName(
        "contact-card"
    );

    for (let i = 0; i < contacts.length; i++) {

        let text = contacts[i]
            .innerText
            .toLowerCase();

        if (text.includes(search)) {

            contacts[i].style.display = "flex";

        } else {

            contacts[i].style.display = "none";
        }
    }
}