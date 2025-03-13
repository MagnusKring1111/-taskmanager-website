<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager | Pro-Print</title>
    <link rel="stylesheet" href="/assets/css/base.css">
<link rel="stylesheet" href="/assets/css/layout.css">
<link rel="stylesheet" href="/assets/css/components.css">
<link rel="stylesheet" href="/assets/css/taskboard.css">
<link rel="stylesheet" href="/assets/css/search.css">
<link rel="stylesheet" href="/assets/css/usermenu.css">

    <script src="/assets/js/main.js" defer></script>
    <script src="/assets/js/search.js" defer></script>
</head>
<body>
<header class="header-bar">
    <div class="header-left">
        <a href="/pages/dashboard.php">
            <img src="/assets/logo-white.svg" alt="Pro-Print Logo" class="logo">
        </a>
    </div>

    <div class="header-center">
        <form action="/pages/search.php" method="get" class="header-search-form" autocomplete="off">
            <div class="search-wrapper">
                <input type="text" name="q" id="liveSearchInput" placeholder="Søg opgave, kunde, dato...">
                <div id="liveSearchResults" class="live-search-dropdown"></div>
            </div>
        </form>
    </div>

    <div class="header-right">
        <div class="user-menu-wrapper">
            <button class="user-button" id="userDropdownToggle">
                Bruger <span class="chevron-icon"></span>
            </button>
            <div class="user-dropdown" id="userDropdownMenu">
                <a href="#">Mine opgaver</a>
                <a href="#">Log ud</a>
            </div>
        </div>
    </div>
</header>

<div class="subheader-nav">
    <nav>
        <a href="/pages/dashboard.php">Opgaver</a>
        <a href="/pages/new-task.php">Ny opgave</a>
        <a href="/pages/clients.php">Kunder</a>
        <a href="/pages/completed-tasks.php">Færdige opgaver</a>
    </nav>
</div>

<main>
