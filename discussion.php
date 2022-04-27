<?php
    //establish connection info
    $db_server = "localhost";
    $db_userid = "uodr29vfa5cqu";
    $db_pw = "ctqg6z29q4dx";
    $db= "dbk8umkuid2yne";

    // Create connection
    $conn = new mysqli($db_server, $db_userid, $db_pw );
    
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $conn->select_db($db);
    
    // If form is submitted...
    if(isset($_POST['submit'])) {
        // Post comment
        $sql = "INSERT INTO comments (song_name, content)
                VALUES ('$_GET[title]', '$_POST[comment]')";

        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel='stylesheet' href='lyrics.css' type='text/css'/> 
        <title>MUSE</title>
        <style>
            body {
                background-image: linear-gradient(to bottom, rgb(157, 59, 255, 0.5), rgb(62, 39, 85, 1)), url('marcela-laskoski-YrtFlrLo2DQ-unsplash.jpg');
            }
            #comments-container {
                padding: 30px;
            }
            #song-container, #comments-container {
                font-weight: bold;
                border-radius: 5px;
                background-color: #9D3BFF;
                margin-left: 20px;
                margin-right: 20px;
                margin-bottom: 20px;
                box-shadow: 0px 10px 50px #121212;
            }
            table, tr {
                width: 100%;
            }
            table {
                border-spacing: 0px 10px;
            }
            td, input[type=text] {
                width: 100%;
                padding: 12px;
                border-radius: 4px;
                box-sizing: border-box;
                margin-top: 0px;
                margin-bottom: 16px;
                resize: vertical;
                font-family: 'Inter', Helvetica, Arial, san-serif;
            }
            td {
                background-color: #461478;
                border: 1px solid #461478;
            }
            input[type=text] {
                background-color: white;
                border: 1px solid white;
            }
            /*form submit button*/
            input[type=submit] {
                position: fixed;
                right: 50px;
                height: 42px;
                background-color: #461478;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-family: 'Inter', Helvetica, Arial, san-serif;
                transition: background-color 300ms;
            }
            /*form submit button*/
            input[type=submit]:hover {
                color: rgb(64, 93, 122);
            }


        </style>
        <script>
            function toggleMobileMenu(menu) {
                menu.classList.toggle('open');
            }

            async function showSong() {
                const url = window.location.search;
                const urlParams = new URLSearchParams(url);
                const title = urlParams.get('title');
                const artist = urlParams.get('artist');
                const album = urlParams.get('album');
                const cover = urlParams.get('cover');

                songCover = document.getElementById("album-cover");
                songTitle = document.getElementById("title");
                songArtist = document.getElementById("artist");
                songAlbum = document.getElementById("album");

                songCover.innerHTML = `<img src=birme-200x200/${cover}>`;
                songTitle.innerHTML = title;
                songArtist.innerHTML = artist;
                songAlbum.innerHTML = album;
            }
        </script>
    </head>
    <body onload='showSong()'>
        <header>
            <h2><a href="index.html">MUSE</a></h2>
            <nav>
                <ul class=main-nav>
                    <li><a href="songsotd.html">SONGS OTD</a></li>
                    <li><a href="contact.html">CONTACT US</a></li>
                </ul>
            </nav>
            <div id="hamburger-icon" onclick="toggleMobileMenu(this)">
               <div class="bar1"></div>
               <div class="bar2"></div>
               <div class="bar3"></div>
               <ul class="mobile-menu">
                    <li id="home" ><a href="index.html">HOME</a></li>
                    <li id="the-experience" ><a href="songsotd.html">SONGS OTD</a></li>
                    <li id="contact-us" ><a href="contact.html">CONTACT US</a></li>
                </ul>
            </div>
        </header>

        <main>
            <h1>DISCUSSION</h1>
            <h5>DISCUSSION</h5>

            <div id="song-container">
                <div id="album-cover"></div>
                <div id="song-info">
                    <div id="title"></div>
                    <div id="artist"></div>
                    <div id="album"></div>
                </div>
            </div>

            <div id="comments-container">
                <?php
                    // Display comments
                    $sql = "SELECT * FROM comments WHERE 
                                        song_name = '" . $_GET['title'] . "'";
                    $result = $conn->query($sql);

                    echo '<table>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr><td>' . $row['content'] . '</td></tr>';
                    }
                    echo '</table>';

                    // close the database connection	
                    $conn->close();
                ?>

                <form action="<?php echo $_SERVER['PHP_SELF'] . 
                                        '?artist=' . $_GET['artist'] .
                                        '&title=' . $_GET['title'] . 
                                        '&album=' . $_GET['album'] .
                                        '&cover=' . $_GET['cover']; ?>" 
                    method="post">
                    <input type="text" name="comment" placeholder="Post a comment...">
                    <input type="submit" name="submit" value="POST">
                </form>
            </div>
        </main>

        <footer>
            Copyright &copy; 2022 MUSE
        </footer>
    </body>
</html>
