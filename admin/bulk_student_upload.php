<?php
if ($_FILES['bulk_file']['name']) {
    $fileType = pathinfo($_FILES['bulk_file']['name'], PATHINFO_EXTENSION);

    if ($fileType === 'csv') {
        $file = fopen($_FILES['bulk_file']['tmp_name'], 'r');
        fgetcsv($file); // Skip the header row if it exists

        $conn = new mysqli('localhost', 'root', '', 'capstone');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO student (class_id, student_id, firstname, lastname) VALUES (?, ?, ?, ?)");

        while (($data = fgetcsv($file)) !== FALSE) {
            $class_id = $data[0]; // adjust based on CSV structure
            $student_id = $data[1];
            $first_name = $data[2];
            $last_name = $data[3];

            $stmt->bind_param("isss", $class_id, $student_id, $first_name, $last_name);
            $stmt->execute();
        }

        fclose($file);
        $stmt->close();
        $conn->close();

        echo "Bulk upload successful!";
    } else {
        echo "Please upload a valid CSV file.";
    }
} else {
    echo "No file uploaded.";
}
?>


