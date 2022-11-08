class headerComponent extends HTMLElement {
    constructor() {
        super()
        this.innerHTML = `
        <link rel="stylesheet" href="../CSS/Register.css">
        <link rel="stylesheet" href="../third-party/fontawesome-free-6.2.0-web/css/all.css">
        <header>
            <div class="burger-menu"><i class="fa-solid fa-bars"></i></div>
            <div class="logo">Check Your Mood</div>
            <div class="space hovered">Stats</div>
            <div class="hovered">Humeurs</div>
            <div class="icon-account hovered"><i class="fa-regular fa-user"></i></div>
        </header>`
    }
}

customElements.define('header-component', headerComponent)