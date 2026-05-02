
// temporary memory storage (not visible on UI)
let students = [];

function addStudent() {
    let name = document.getElementById("name").value;
    let usn = document.getElementById("usn").value;
    let dept = document.getElementById("dept").value;
    let year = document.getElementById("year").value;
    let room = document.getElementById("room").value;

    if (name === "" || usn === "") {
        alert("Name and USN required");
        return;
    }

    let student = {
        name,
        usn,
        dept,
        year,
        room
    };

    students.push(student);

    // ONLY SHOW IN INSPECT (Console)
    console.log("Student Added:", student);
    console.log("All Students:", students);

    // clear inputs
    document.getElementById("name").value = "";
    document.getElementById("usn").value = "";
    document.getElementById("dept").value = "";
    document.getElementById("year").value = "";
    document.getElementById("room").value = "";
}


function deleteStudent() {
    let delName = document.getElementById("delName").value;
    let delUsn = document.getElementById("delUsn").value;

    let index = students.findIndex(s =>
        s.name === delName && s.usn === delUsn
    );

    if (index !== -1) {
        let removed = students.splice(index, 1);
        console.log("Deleted Student:", removed[0]);
    } else {
        console.log("Student not found");
    }

    console.log("Updated List:", students);

    document.getElementById("delName").value = "";
    document.getElementById("delUsn").value = "";
}