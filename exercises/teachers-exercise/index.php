<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Lookup</title>
</head>
<body>
    <h1>Teacher Information</h1>
    <form>
        <label for="teacherId">Teacher ID:</label>
        <input type="text" id="teacherId" name="teacherId"><br><br>
        
        <label for="teacherName">Teacher Name:</label>
        <input type="text" id="teacherName" name="teacherName" readonly><br><br>
    </form>

    <script>
        let timeoutId;

        document.getElementById('teacherId').addEventListener('input', function() {
            clearTimeout(timeoutId);
            const id = this.value.trim();
            if (id) {
                timeoutId = setTimeout(function() {
                    fetchTeacherName(id);
                }, 500); // 500ms delay
            } else {
                document.getElementById('teacherName').value = '';
            }
        });

        function fetchTeacherName(id) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'findTeacher.php?id=' + encodeURIComponent(id), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('teacherName').value = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>