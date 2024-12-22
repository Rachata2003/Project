<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Typing Speed Tracker</title>
    <script>
        let lastKeyTime = null;
        let timings = [];

        function trackKeyTime(event) {
            const currentTime = new Date().getTime();
            if (lastKeyTime !== null) {
                const timeDiff = (currentTime - lastKeyTime) / 1000; // แปลงเป็นวินาที
                timings.push({
                    key: event.key,
                    time: timeDiff,
                });
            }
            lastKeyTime = currentTime;
        }

        function submitTimings() {
            // ส่งข้อมูล timings ไปยัง PHP
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "save_timings.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert("Timings saved successfully!");
                    timings = []; // รีเซ็ตข้อมูล
                }
            };
            xhr.send(JSON.stringify(timings));
        }
    </script>
</head>
<body>
    <h1>Typing Speed Tracker</h1>
    <form onsubmit="event.preventDefault(); submitTimings();">
        <label for="inputText">Type here:</label><br>
        <textarea id="inputText" rows="5" cols="30" onkeydown="trackKeyTime(event)"></textarea><br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
