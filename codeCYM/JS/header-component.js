class headerComponent extends HTMLElement {
    constructor() {
        super()
        this.innerHTML = `
        <link rel="stylesheet" href="../CSS/Register.css">
        <div class="d-flex mb-4 header-bar align-items-center">
            <div class="me-auto p-2 LOGO">Check your mood</div>
            <div class="p-2 header-hover">Stats</div>
            <div class="p-2 header-hover">Humeurs</div>
            <div class="p-2 header-hover"><i class="fa-regular fa-user"></i></div>
        </div>`
    }
}

customElements.define('header-component', headerComponent)