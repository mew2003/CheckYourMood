class headerComponent extends HTMLElement {
    constructor() {
        super()
        this.innerHTML = `
        <link rel="stylesheet" href="../CSS/header-component.css">
        <link rel="stylesheet" href="../third-party/fontawesome-free-6.2.0-web/css/all.css">
        <header>
            <div class="burger-menu" onclick="add(this)"><i class="fa-solid fa-bars"></i></div>
            <a class="link" href="#"><div class="logo">Check Your Mood</div></a>
            <a class="link hovered space" href="#"><div>Stats</div></a>
            <a class="link hovered" href="Humeurs.php"><div>Humeurs</div></a>
            <a class="link hovered" href="Register.php"><div class="icon-account"><i class="fa-regular fa-user"></i></div></a>
        </header>`
    }
}

customElements.define('header-component', headerComponent)