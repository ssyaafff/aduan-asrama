<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Semak Aduan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-color: rgba(255, 255, 255, 0.85);
            --text-color: #333;
            --input-bg: #fff;
            --button-bg: #007bff;
            --button-text: #fff;
        }

        body.dark {
            --bg-color: rgba(0, 0, 0, 0.85);
            --text-color: #f1f1f1;
            --input-bg: #222;
            --button-bg: #0069d9;
            --button-text: #fff;
        }

        * {
            box-sizing: border-box;
            transition: background-color 0.4s, color 0.4s;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: url('view asrama.jpg') no-repeat center center/cover;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            color: var(--text-color);
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: -1;
        }

        .container {
            background-color: var(--bg-color);
            border-radius: 15px;
            padding: 30px 25px;
            margin-top: 60px;
            max-width: 600px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            color: var(--text-color);
        }

        .text-center h2 {
            margin-bottom: 10px;
        }

        #logo {
            max-width: 100px;
            margin-bottom: 20px;
        }

        input.form-control {
            background: var(--input-bg);
            color: var(--text-color);
            border: 1px solid #ccc;
        }

        #searchresult {
            margin-top: 20px;
        }

        #backButton {
            background-color: var(--button-bg);
            color: var(--button-text);
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        #backButton:hover {
            background-color: #0056b3;
        }

        @media (max-width: 576px) {
            .container {
                margin: 30px 15px;
            }
        }
    </style>
</head>
<body>

    <div class="container text-center">
        <img id="logo" src="logokvsepang.jpg" alt="Logo">
        <h2>Semak Aduan</h2>
        <p>Note: Gambar tidak akan dipaparkan disini, hanya pihak warden/penyelia asrama sahaja yang boleh melihat gambar tersebut.</p>
        <input type="text" class="form-control mt-3" id="aduan_asrama" autocomplete="off" placeholder="Semak Aduan ... (Contoh: BA/BB/BC/GA/GBXXX ATAU NAMA ANDA)">
    </div>

    <div id="searchresult" class="container"></div>

    <div class="text-center mt-3 mb-4">
        <button class="btn" id="backButton">Kembali</button>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#aduan_asrama").keyup(function(){
                var input = $(this).val();
                if(input != "") {
                    $.ajax({
                        url: "livesearch.php",
                        method: "POST",
                        data: {input: input},
                        success: function(data) {
                            $("#searchresult").html(data).show();
                        }
                    });
                } else {
                    $("#searchresult").hide();
                }
            });

            $("#backButton").click(function(){
                window.history.back();
            });
        });
    </script>
</body>
</html>
