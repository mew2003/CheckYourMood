class headerComponent extends HTMLElement {
    constructor() {
        super()
        this.innerHTML = `
        <link rel="stylesheet" href="/CheckYourMood/codeCYM/CSS/header-component.css">
        <link rel="stylesheet" href="/CheckYourMood/codeCYM/third-party/fontawesome-free-6.2.0-web/css/all.css">
        <link rel="icon" type="image/x-icon" href="/CheckYourMood/codeCYM/images/favicon.ico">
        <header>
            <div class="burger-menu" onclick="add(this)"><i class="fa-solid fa-bars"></i></div>
            <img src="/CheckYourMood/codeCYM/assets/images/logoCYM.png" height="70px">
            &nbsp; &nbsp;
            <a class="link" href="/CheckYourMood/codeCYM/pages/index.php"><div class="logo">Check Your Mood</div></a>
            <a class="link hovered space" href=""><div>Stats</div></a>
            <a class="link hovered" href=""><div>Humeurs</div></a>
            <a class="link hovered" href=""><div class="icon-account"><i class="fa-regular fa-user"></i></div></a>
        </header>`
    }
}

customElements.define('header-component', headerComponent)