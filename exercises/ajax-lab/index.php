<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAKE_COURSES Management</title>
</head>
<body>
    <h1>TAKE_COURSES</h1>
    <form>
        <label for="studentId">Student id:</label>
        <input type="text" id="studentId" name="studentId">
        &nbsp;&nbsp;
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" readonly>
        &nbsp;&nbsp;
        <label>photo:</label>
        <img id="studentPhoto" src="" alt="" style="height:50px; vertical-align:middle; display:none;">
        <br><br>

        <label for="courseId">Course id:</label>
        <input type="text" id="courseId" name="courseId">
        &nbsp;&nbsp;
        <label for="courseDesc">Course description:</label>
        <input type="text" id="courseDesc" name="courseDesc" size="30" readonly>
        <br>

        <label for="startDate">Start date:</label>
        <input type="date" id="startDate" name="startDate">
        <br><br>

        <button type="button" onclick="submitAction('add')">Add</button>
        &nbsp;
        <button type="button" onclick="submitAction('update')">Update</button>
        &nbsp;
        <button type="button" onclick="submitAction('delete')">Delete</button>
    </form>

    <script>
        let studentTimeout, courseTimeout;

        document.getElementById('studentId').addEventListener('input', function() {
            clearTimeout(studentTimeout);
            const id = this.value.trim();
            if (id) {
                studentTimeout = setTimeout(function() {
                    fetchStudent(id);
                }, 500);
            } else {
                document.getElementById('lastName').value = '';
                const photo = document.getElementById('studentPhoto');
                photo.src = '';
                photo.style.display = 'none';
            }
        });

        document.getElementById('courseId').addEventListener('input', function() {
            clearTimeout(courseTimeout);
            const id = this.value.trim();
            if (id) {
                courseTimeout = setTimeout(function() {
                    fetchCourse(id);
                }, 500);
            } else {
                document.getElementById('courseDesc').value = '';
            }
        });

        function fetchStudent(id) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'findStudent.php?id=' + encodeURIComponent(id), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data.error) {
                        alert(data.error);
                        document.getElementById('lastName').value = '';
                        const photo = document.getElementById('studentPhoto');
                        photo.src = '';
                        photo.style.display = 'none';
                    } else {
                        document.getElementById('lastName').value = data.last_name;
                        const photo = document.getElementById('studentPhoto');
                        if (data.photo) {
                            photo.src = data.photo;
                            photo.style.display = 'inline';
                        }
                    }
                }
            };
            xhr.send();
        }

        function fetchCourse(id) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'findCourse.php?id=' + encodeURIComponent(id), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText === 'Course not found') {
                        alert('Course not found');
                        document.getElementById('courseDesc').value = '';
                    } else {
                        document.getElementById('courseDesc').value = xhr.responseText;
                    }
                }
            };
            xhr.send();
        }

        function submitAction(action) {
            const studentId = document.getElementById('studentId').value.trim();
            const courseId  = document.getElementById('courseId').value.trim();
            const startDate = document.getElementById('startDate').value;

            if (!studentId || !courseId) {
                alert('Please enter a student ID and a course ID');
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'action.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send(
                'action='     + encodeURIComponent(action)    +
                '&student_id='+ encodeURIComponent(studentId) +
                '&course_id=' + encodeURIComponent(courseId)  +
                '&start_date='+ encodeURIComponent(startDate)
            );
        }
    </script>
</body>
</html>
