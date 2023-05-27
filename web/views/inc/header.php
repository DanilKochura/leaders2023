<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?=PATH?>views/assets/main.css">

</head>
<body>
<div id="loader" class="hidden">
    <img  src="<?=PATH?>views/assets/Spinner-2.gif"  >
</div>
<div class="wrapper">

    <menu class="menu">
        <img src="https://imdibil.ru/hackathon/web/views/assets/logo.svg" alt="Logo" class="logo">
        <a class="menu-element <?=$route[0]== 'dynamic' ? 'active' : ''?>" href="/hackathon/dynamic">Динамика</a>
        <a class="menu-element <?=$route[0]== 'seasons' ? 'active' : ''?>" href="/hackathon/seasons">Сезонность</a>
        <a class="menu-element <?=$route[0]== 'profiles' ? 'active' : ''?>" href="/hackathon/profiles">Профиль</a>
        <a class="menu-element <?=$route[0]== 'predicts' ? 'active' : ''?>" href="/hackathon/predicts">Прогноз</a>
    </menu>