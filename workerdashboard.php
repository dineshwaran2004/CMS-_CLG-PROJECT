<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Catering Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
        }

        .replay-btn {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .replay-btn:hover {
            background-color: #27ae60;
            transform: scale(1.1);
        }

        .sidebar {
            width: 200px;
            background-color: #2c3e50;
            color: white;
            padding-top: 20px;
            position: fixed;
            height: 100%;
        }

        .sidebar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        .worker-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 30px;
        }

        .worker-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .worker-card:hover {
            transform: translateY(-10px);
        }

        .worker-card h3 {
            margin-top: 0;
        }

        .worker-card p {
            margin: 5px 0;
        }

        .logo {
            position: fixed;
            bottom: 10px;
            right: 10px;
            z-index: 1000;
        }

        .logo img {
            width: 100px;
            height: auto;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal button {
            margin-top: 15px;
        }

        .manage-btn, .add-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .manage-btn:hover, .add-btn:hover {
            background-color: #2980b9;
        }

        /* Add Worker Form Styling */
        .add-worker-modal .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 450px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .add-worker-modal h2 {
            text-align: center;
            color: #3498db;
            margin-bottom: 20px;
        }

        .add-worker-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .add-worker-form label {
            font-weight: bold;
            color: #2c3e50;
        }

        .add-worker-form input {
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .add-worker-form input:focus {
            border-color: #3498db;
        }

        .add-worker-form button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .add-worker-form button:hover {
            background-color: #2980b9;
        }

        .add-worker-form .cancel-btn {
            background-color: #e74c3c;
            margin-top: 10px;
        }

        .add-worker-form .cancel-btn:hover {
            background-color: #c0392b;
        }

    </style>
</head>
<body>
    <div class="logo">
        <a href="index.html"><img src="LOGO.png" alt="DinesH Catering Logo"></a>
    </div>

    <div class="sidebar">
        <h2><a href="index.html">Home</a></h2>
        <h2><a href="javascript:void(0);" id="add-worker-link">Add Worker</a></h2>
        <h2><a href="http://localhost/final/workerlogin.php">Logout</a></h2>
    </div>

    <div class="main-content">
        <h1>Welcome to the Catering Management Dashboard</h1>
        <p>Hello, <?php echo $_SESSION['username']; ?>!</p>

        <div class="worker-cards" id="worker-cards-container">
            <!-- Worker cards will appear here -->
        </div>
    </div>

    <!-- Modal for managing worker details -->
    <div class="modal" id="manage-modal">
        <div class="modal-content">
            <h2>Edit Worker Details</h2>
            <form id="manage-form">
                <label for="worker-name">Name:</label><br>
                <input type="text" id="worker-name" name="name"><br><br>

                <label for="worker-age">Age:</label><br>
                <input type="number" id="worker-age" name="age"><br><br>

                <label for="worker-gender">Gender:</label><br>
                <input type="text" id="worker-gender" name="gender"><br><br>

                <label for="worker-experience">Experience:</label><br>
                <input type="number" id="worker-experience" name="experience"><br><br>

                <label for="worker-role">Role:</label><br>
                <input type="text" id="worker-role" name="role"><br><br>

                <label for="worker-availability">Availability:</label><br>
                <input type="text" id="worker-availability" name="availability"><br><br>

                <label for="worker-contact">Contact:</label><br>
                <input type="text" id="worker-contact" name="contact"><br><br>

                <button type="submit">Save Changes</button>
                <button type="button" id="close-modal">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Modal for adding new worker details -->
    <div class="modal" id="add-worker-modal">
        <div class="modal-content">
            <h2>Add New Worker</h2>
            <form id="add-worker-form" class="add-worker-form">
                <label for="new-worker-name">Name:</label>
                <input type="text" id="new-worker-name" name="name" required>

                <label for="new-worker-age">Age:</label>
                <input type="number" id="new-worker-age" name="age" required>

                <label for="new-worker-gender">Gender:</label>
                <input type="text" id="new-worker-gender" name="gender" required>

                <label for="new-worker-experience">Experience:</label>
                <input type="number" id="new-worker-experience" name="experience" required>

                <label for="new-worker-role">Role:</label>
                <input type="text" id="new-worker-role" name="role" required>

                <label for="new-worker-availability">Availability:</label>
                <input type="text" id="new-worker-availability" name="availability" required>

                <label for="new-worker-contact">Contact:</label>
                <input type="text" id="new-worker-contact" name="contact" required>

                <button type="submit">Add Worker</button>
                <button type="button" id="close-add-modal" class="cancel-btn">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        // Function to display worker cards
        function displayWorkerCards() {
            var workers = JSON.parse(localStorage.getItem("workers")) || [];

            var container = document.getElementById("worker-cards-container");
            container.innerHTML = "";

            workers.forEach(function(worker, index) {
                var card = document.createElement("div");
                card.classList.add("worker-card");

                var cardContent = `
                    <h3>${worker.name}</h3>
                    <p><strong>Age:</strong> ${worker.age}</p>
                    <p><strong>Gender:</strong> ${worker.gender}</p>
                    <p><strong>Experience:</strong> ${worker.experience} years</p>
                    <p><strong>Role:</strong> ${worker.role}</p>
                    <p><strong>Availability:</strong> ${worker.availability}</p>
                    <p><strong>Contact:</strong> ${worker.contact}</p>
                    <button class="replay-btn" data-index="${index}">Reply</button>
                    <button class="manage-btn" data-index="${index}">Manage</button>
                `;

                card.innerHTML = cardContent;
                container.appendChild(card);

                card.querySelector(".replay-btn").onclick = function() {
                    var index = this.getAttribute("data-index");
                    replayWorker(index);
                };

                card.querySelector(".manage-btn").onclick = function() {
                    var index = this.getAttribute("data-index");
                    manageWorker(index);
                };
            });
        }

        // Replay worker (send a WhatsApp message with the worker details)
        function replayWorker(index) {
            var workers = JSON.parse(localStorage.getItem("workers")) || [];
            var worker = workers[index];
            var contact = worker.contact;
            var username = "<?php echo $_SESSION['username']; ?>";
            var message = encodeURIComponent(`
                Hello, this is ${username}. I would like to know if the following worker is available to work:
                
                Name: ${worker.name}
                Age: ${worker.age}
                Gender: ${worker.gender}
                Experience: ${worker.experience} years
                Role: ${worker.role}
                Availability: ${worker.availability}
                Contact: ${worker.contact}
                
                Kindly let me know if you are available to work now. Reply with "YES" or "no".
            `);
            var whatsappUrl = `https://wa.me/${contact}?text=${message}`;
            window.location.href = whatsappUrl;
        }

        // Manage worker (edit or remove worker)
        function manageWorker(index) {
            var workers = JSON.parse(localStorage.getItem("workers")) || [];
            var worker = workers[index];

            document.getElementById("worker-name").value = worker.name;
            document.getElementById("worker-age").value = worker.age;
            document.getElementById("worker-gender").value = worker.gender;
            document.getElementById("worker-experience").value = worker.experience;
            document.getElementById("worker-role").value = worker.role;
            document.getElementById("worker-availability").value = worker.availability;
            document.getElementById("worker-contact").value = worker.contact;

            document.getElementById("manage-modal").style.display = "flex";

            document.getElementById("manage-form").onsubmit = function(event) {
                event.preventDefault();
                worker.name = document.getElementById("worker-name").value;
                worker.age = document.getElementById("worker-age").value;
                worker.gender = document.getElementById("worker-gender").value;
                worker.experience = document.getElementById("worker-experience").value;
                worker.role = document.getElementById("worker-role").value;
                worker.availability = document.getElementById("worker-availability").value;
                worker.contact = document.getElementById("worker-contact").value;

                localStorage.setItem("workers", JSON.stringify(workers));

                document.getElementById("manage-modal").style.display = "none";
                displayWorkerCards();
            };
        }

        // Add worker functionality
        document.getElementById("add-worker-link").onclick = function() {
            document.getElementById("add-worker-modal").style.display = "flex";
        };

        document.getElementById("add-worker-form").onsubmit = function(event) {
            event.preventDefault();

            var newWorker = {
                name: document.getElementById("new-worker-name").value,
                age: document.getElementById("new-worker-age").value,
                gender: document.getElementById("new-worker-gender").value,
                experience: document.getElementById("new-worker-experience").value,
                role: document.getElementById("new-worker-role").value,
                availability: document.getElementById("new-worker-availability").value,
                contact: document.getElementById("new-worker-contact").value,
            };

            var workers = JSON.parse(localStorage.getItem("workers")) || [];
            workers.push(newWorker);
            localStorage.setItem("workers", JSON.stringify(workers));

            document.getElementById("add-worker-modal").style.display = "none";
            displayWorkerCards();
        };

        // Close modals
        document.getElementById("close-modal").onclick = function() {
            document.getElementById("manage-modal").style.display = "none";
        };

        document.getElementById("close-add-modal").onclick = function() {
            document.getElementById("add-worker-modal").style.display = "none";
        };

        // Initialize
        displayWorkerCards();
    </script>
</body>
</html>
