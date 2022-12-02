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
        </header>`
    }
}

customElements.define('header-component', headerComponent)