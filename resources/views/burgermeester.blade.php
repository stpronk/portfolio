<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="author" content="Steve Pronk">
    <meta name="google-site-verification" content="xfuyR1cAs5xv7EvMWANbPC7PMb7G1xlk8G5pMl2tnlI"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="msapplication-TileColor" content="#000">
    <meta name="theme-color" content="#000">

    <title>Burgermeester</title>

    <style>
        html, body {
            padding: 0;
            margin:  0;
            font-family: "Nunito", sans-serif;
        }

        .container {
            padding: 4px;
        }

        .header {
            display: block;
            text-align: center;
            margin: 20px 10px;
            font-size: 20px;
        }

        .input {
            margin-right: 10px;
        }

        .stem-item {
            display: block;
            padding: 10px;
            margin: 4px;
            height: 20px;
            background-color: forestgreen;
            color: white;
        }

        .stem-item:hover {
            cursor: pointer;
            background-color: green;
        }

        .submit-button-container {
            margin: 4px;
            height: 20px;
            text-align: center;
        }

        .submit-button {
            font-size: 18px;
            background-color: darkblue;
            border: none;
            color: white;
            padding: 10px 30px;
        }

        .hide {
            display: none;
        }

        .stem-result {
            text-align: center;
        }
    </style>

</head>
<body>

<div class="container">
    <h3 class="header">
        Kies je burgermeester!
    </h3>

    <div class="stem-container">
        <form class="form">
            <label class="stem-item">
                <input type="radio" name="kandidaat" value="Lisa" class="input"/>Ramon
            </label>
            <label class="stem-item">
                <input type="radio" name="kandidaat" value="Steve" class="input"/>Steve
            </label>
            <label class="stem-item">
                <input type="radio" name="kandidaat" value="Daniëlle" class="input"/>Daniëlle
            </label>
            <label class="stem-item">
                <input type="radio" name="kandidaat" value="Frank" class="input"/>Frank
            </label>
            <label class="stem-item">
                <input type="radio" name="kandidaat" value="Ricardo" class="input"/>Ricardo
            </label>
            <label class="stem-item">
                <input type="radio" name="kandidaat" value="Angela" class="input"/>Angela
            </label>
            <label class="stem-item">
                <input type="radio" name="kandidaat" value="Neville" class="input"/>Neville
            </label>
            <label class="stem-item">
                <input type="radio" name="kandidaat" value="Jelmar" class="input"/>Jelmar
            </label>
            <label class="stem-item">
                <input type="radio" name="kandidaat" value="Lisa" class="input"/>Lisa
            </label>

            <div class="submit-button-container">
                <button type="submit" class="submit-button">
                    Stem
                </button>
            </div>
        </form>
    </div>

    <div class="stem-result hide">
        <p>Bedankt voor het stemmen! U hebt gestemt op <b>Steve</b>! Er is geen mogelijkheid om uw stem op dit moment aan te passen en uw stem is gelijk op geteld bij de rest van de stemmen.</p>
        <br />
        <h3>Tussenstand</h3>
        <p>Momenteel staat <b>Steve</b> aankop met <b>8</b> Stemmen!</p>
    </div>
</div>

</body>
<script>

    if(sessionStorage.voted) {
        document.querySelector('.stem-container').classList.add('hide');
        document.querySelector('.stem-result').classList.remove('hide');
    }


    document.querySelector('.form').addEventListener('submit', function (e) {
        e.preventDefault();

        document.querySelector('.stem-container').classList.add('hide');
        document.querySelector('.stem-result').classList.remove('hide');

        sessionStorage.voted = true;
    })
</script>
</html>
