window.onload = fetchStudents;

async function deleteStudent() {
  const usn = document.getElementById("delUsn").value.trim();

  if (!usn) {
    alert("USN is required");
    return;
  }

  try {
    const res = await fetch("delete_student.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ usn }),
    });

    const data = await res.json();
    alert(data.message);

    if (data.success) {
      document.getElementById("delUsn").value = "";
      fetchStudents();
    }
  } catch (err) {
    alert("Request failed: " + err.message);
  }
}
async function addStudent() {
  const name = document.getElementById("name").value.trim();
  const usn = document.getElementById("usn").value.trim();
  const year = document.getElementById("year").value.trim();
  const dept = document.getElementById("dept").value.trim();

  if (!name || !usn || !year || !dept) {
    alert("All fields are required");
    return;
  }

  try {
    const res = await fetch("add_student.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ name, usn, year, dept }),
    });

    const data = await res.json();
    alert(data.message);

    if (data.success) {
      document.getElementById("name").value = "";
      document.getElementById("usn").value = "";
      document.getElementById("year").value = "";
      document.getElementById("dept").value = "";

      fetchStudents(); // refresh table (if you are using it)
    }
  } catch (err) {
    alert("Error: " + err.message);
  }
}
async function fetchStudents() {
  try {
    const res = await fetch("get_students.php");
    const data = await res.json();

    if (!data.success) {
      alert("Failed to load students: " + data.message);
      return;
    }

    const students = data.students;
    const wrapper = document.getElementById("studentTableWrapper");

    if (students.length === 0) {
      wrapper.innerHTML = "<p>No students found.</p>";
      return;
    }

    let html = `<table border="1" cellpadding="6" cellspacing="0" style="width:auto;border-collapse:collapse;font-size:13px;white-space:nowrap;">
      <thead style="background:#007bff;color:white;">
        <tr>
          <th>sl_No</th>
          <th>Name</th>
          <th>USN</th>
          <th>Year</th>
          <th>Dept</th>
          <th>Opening Balance</th>
          <th>Mess Rate</th>
          <th>Service Charge</th>
          <th>GST (18%)</th>
          <th>Total Service</th>
          <th>Rate + Service</th>
          <th>Reduced Days</th>
          <th>Total Days</th>
          <th>Mess Bill</th>
          <th>Closing Amount</th>
          <th>Water Bill</th>
        
        </tr>
      </thead>
      <tbody>`;

    students.forEach((s) => {
      html += `<tr>
        <td>${s.Sl_no}</td>
        <td>${s.Student_Name}</td>
        <td>${s.student_usn}</td>
        <td>${s.Student_Year}</td>
        <td>${s.Student_Dept}</td>
        <td>${s.Opening_balance}</td>
        <td>${s.Total_mess_Rate}</td>
        <td>${s.Mess_service_charge}</td>
        <td>${s.GST_18}</td>
        <td>${s.Total_service_charge}</td>
        <td>${s.Total_mess_Rate_Service}</td>
        <td>${s.reduced_no_of_days}</td>
        <td>${s.total_days ?? "-"}</td>
        <td>${s.total_mess_bill}</td>
        <td>${s.closing_mess_amount}</td>
        <td>${s.water_bill}</td>
      </tr>`;
    });

    html += `</tbody></table>`;
    wrapper.innerHTML = html;
  } catch (err) {
    alert("Request failed: " + err.message);
  }
}
function showAddForm() {
    document.getElementById("addForm").style.display = "block";
    document.getElementById("deleteForm").style.display = "none";
}

function showDeleteForm() {
    document.getElementById("deleteForm").style.display = "block";
    document.getElementById("addForm").style.display = "none";
}

