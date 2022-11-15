class accountComponent extends HTMLElement {
    constructor() {
        super()
        this.innerHTML = `
        <div class="main-container">
            <div class="row main">
                <div class="col-md-6 col-sm-8 col-xs-12 d-grid gap-5">
                    <h1>Profil</h1>
                    <div class="form-control">
                        <h2>Email :</h2>
                    </div>
                    <div class="form-control">
                        <h2>Nom d'utilisateur :</h2>
                    </div>
                    <div class="form-control">
                        <h2>Mot de passe : </h2>
                    </div>
                </div>
                <div class="col-md-6 col-sm-4 d-flex justify-content-md-end justify-content-sm-end justify-content-center align-items-start">
                    <div class="row col-xs-hidden flex-md-row flex-sm-column justify-content-between justify-content-sm-center justify-content-between" style="padding: 10px;">
                        <input class="button col-md-6 col-sm-12" type="button" value="Modifier le mot de passe"/>
                        <input class="button col-md-6 col-sm-12" type="button" value="Modifier le profil"/>
                    </div>
                </div>
            </div>
            <input class="buttonD" type="button" value="Désinscription"/>
        </div>
        `
    }
}

customElements.define('account-component', accountComponent)