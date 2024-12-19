<!DOCTYPE HTML>
<html>
<head>
    <title>Çin Mitolojisi</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <base href="<?= base_url() ?>">
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>
<body class="is-preload">

<div id="wrapper" class="fade-in">

    <!-- Intro Section -->
    <div id="intro">
        <h1>Çin Mitolojisi</h1>
        <p>Çin Mitolojileri İçin Tek Site</p>
        <ul class="actions">
            <li><a href="#header" class="button icon solid solo fa-arrow-down scrolly">Continue</a></li>
        </ul>
    </div>

    <!-- Header Section -->
    <header id="header">
        <a href="<?= base_url() ?>" class="logo">Çin Mitolojisi</a>
    </header>

    <!-- Navigation -->
    <nav id="nav">
        <ul class="links">
            <li <?= ($active_menu ?? '') == 'home' ? 'class="active"' : '' ?>><a href="<?= base_url() ?>">Ana Sayfa</a></li>
            <li <?= ($active_menu ?? '') == 'hakkimizda' ? 'class="active"' : '' ?>><a href="<?= base_url('hakkimizda') ?>">Hakkımızda</a></li>
            <li <?= ($active_menu ?? '') == 'login' ? 'class="active"' : '' ?>><a href="<?= base_url('admin/login') ?>">Admin Girişi</a></li>
        </ul>
        <ul class="icons">
            <li><a href="https://steamcommunity.com/profiles/76561198312714440" class="icon brands fa-steam"><span class="label">Steam</span></a></li>
            <li><a href="https://www.odyofilizm.com" class="icon brands fa-wordpress"><span class="label">WordPress</span></a></li>
            <li><a href="https://www.instagram.com/shuichi_tatsuo/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
        </ul>
    </nav>
