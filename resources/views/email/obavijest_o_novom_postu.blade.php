

<!DOCTYPE html>
<html>
<head>
    <title>Obavijest o novom postu</title>
</head>
<body>
    <h1>Novi post je objavljen!</h1>
    <p><strong>Grupa:</strong>{{ $post->group->ime }}</p>
    <p><strong>Tema: </strong>{{ $post['tema'] }}</p>
    <p><strong>Sadrzaj: </strong>{{ $post['sadrzaj'] }}</p>
</body>
</html>
