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
            <li><a href="https://github.com/ontheroonkilled" class="icon brands fa-github"><span class="label">Berat Beşgül Github</span></a></li>
            <li><a href="https://github.com/shest00" class="icon brands fa-github"><span class="label">Emircan Doğanay Github</span></a></li>
            <li><a href="https://github.com/emircopur" class="icon brands fa-github"><span class="label">Emir Çöpür Github</span></a></li>
        </ul>
    </nav>
