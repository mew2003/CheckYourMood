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
            <form action="#" method="get">
                <input hidden name="action" value="index">
                <input hidden name="controller" value="home">
                <input type="submit" class="link" value="Check Your Mood"></input>
            </form>
            <form action="" method="get">
                <input hidden name="action" value="index">
                <input hidden name="controller" value="stats">
                <input type="submit" class="link" value="Stats"></input>
            </form>
            <form action="#" method="get">
                <input hidden name="action" value="index">
                <input hidden name="controller" value="humeurs">
                <input type="submit" class="link" value="Humeurs"></input>
            </form>
            <form action="#" method="get">
                <input hidden name="action" value="index">
                <input hidden name="controller" value="home">
                <input type="submit" class="link" value="Account"></input>
            </form>
        </header>`
    }
}

customElements.define('header-component', headerComponent)