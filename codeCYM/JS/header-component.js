class headerComponent extends HTMLElement {
    constructor() {
        super()
        this.innerHTML = `
        <link rel="stylesheet" href="/CheckYourMood/codeCYM/CSS/header-component.css">
        <link rel="stylesheet" href="/CheckYourMood/codeCYM/third-party/fontawesome-free-6.2.0-web/css/all.css">
        
        <link rel="apple-touch-icon" sizes="180x180" href="/CheckYourMood/codeCYM/assets/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/CheckYourMood/codeCYM/assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/CheckYourMood/codeCYM/assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/CheckYourMood/codeCYM/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">


        <header>
            <div class="burger-menu"><i class="fa-solid fa-bars"></i></div>
            <img src="/CheckYourMood/codeCYM/assets/images/logoCYM.png" height="70px">
            &nbsp; &nbsp;
            <form action="#" method="get" class="space">
                <input hidden name="action" value="index">
                <input hidden name="controller" value="home">
                <button type="submit" class="link">Check Your Mood</button>
            </form>
            <form action="" method="get" class="h">
                <input hidden name="action" value="index">
                <input hidden name="controller" value="stats">
                <button type="submit" class="link mobile">Stats</button>
            </form>
            <form action="" method="get" class="h">
                <input hidden name="action" value="historyVal">
                <input hidden name="controller" value="stats">
                <input hidden name="page" value="1">
                <button type="submit" class="link mobile">Historique</button>
            </form>
            <form action="#" method="get" class="h">
                <input hidden name="action" value="index">
                <input hidden name="controller" value="humeurs">
                <button type="submit" class="link mobile">Humeurs</button>
            </form>
            <form action="#" method="get" class="h">
                <input hidden name="action" value="index">
                <input hidden name="controller" value="register">
                <button type="submit" class="link mobile"><span class='fa-regular fa-user'></button>
            </form>
        </header><div class="burger"><i class="fa-solid fa-bars burger-in"></i></div>
        <nav class="nav-menu">
            <li>
                <form action="#" method="get" class="hBurger">
                    <input hidden name="action" value="index">
                    <input hidden name="controller" value="register">
                    <button type="submit" class="link Phone">Compte</button>
                </form>
            </li>
            <li>
                <form action="#" method="get" class="hBurger">
                    <input hidden name="action" value="index">
                    <input hidden name="controller" value="humeurs">
                    <button type="submit" class="link Phone">Humeurs</button>
                </form>
            </li>
            <li>
                <form action="" method="get" class="hBurger">
                    <input hidden name="action" value="index">
                    <input hidden name="controller" value="stats">
                    <input hidden name="page" value="1">
                    <button type="submit" class="link Phone">Stats</button>
                </form>
            </li>
            <li>
                <form action="" method="get" class="hBurger">
                    <input hidden name="action" value="historyVal">
                    <input hidden name="controller" value="stats">
                    <button type="submit" class="link Phone">Historique</button>
                </form>
            </li>
        </nav>`
        
    }
}

customElements.define('header-component', headerComponent)

function toggleMenu() {
    const navbar = document.querySelector('body');
    const burger = document.querySelector('.burger-menu');
    const burger_in = document.querySelector('.burger-in');
    burger.addEventListener('click', () => {
        navbar.classList.toggle('show-nav');
    })
    burger_in.addEventListener('click', () => {
        navbar.classList.toggle('show-nav');
    })
}
toggleMenu();