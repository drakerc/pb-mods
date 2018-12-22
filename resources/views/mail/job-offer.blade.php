<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nowa oferta pracy!</title>
</head>
<body>
    <h3>Witaj, {{$studio->name}}!</h3>
    <p>Użytkownik {{$user->name}} ({{$user->email}}) właśnie zaaplikował w sprawie oferty {{$offer->title}}!</p>
    <br>
    <br>
    <p><em>Pozdrawiamy,</em></p>
    <p><em>Zespół aplikacji</em></p>
</body>
</html>