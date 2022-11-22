class headerComponent extends HTMLElement {
    constructor() {
        super()
        this.innerHTML = `
        <link rel="stylesheet" href="../CSS/header-component.css">
        <link rel="stylesheet" href="../third-party/fontawesome-free-6.2.0-web/css/all.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
        <header>
            <div class="burger-menu" onclick="add(this)"><i class="fa-solid fa-bars"></i></div>
            <img src="../resources/images/logoCYM.png" height="70px">
            &nbsp; &nbsp;
            <a class="link" href="../pages/index.php"><div class="logo">Check Your Mood</div></a>
            <a class="link hovered space" href="../pages/Stats.php"><div>Stats</div></a>
            <a class="link hovered" href="../pages/Humeurs.php"><div>Humeurs</div></a>
            <a class="link hovered" href="../pages/Register.php"><div class="icon-account"><i class="fa-regular fa-user"></i></div></a>
        </header>`
    }
}

customElements.define('header-component', headerComponent)