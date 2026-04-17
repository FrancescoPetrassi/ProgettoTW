function generaLoginForm(loginerror = null) {
    let form = `
    <form action="#" method="POST">
        <h2>Login</h2>
        <p></p>
        <ul>
            <li>
                <label for="username">Username:</label><input type="text" id="username" name="username" />
            </li>
            <li>
                <label for="password">Password:</label><input type="password" id="password" name="password" />
            </li>
            <li>
                <input type="submit" name="submit" value="Invia" />
            </li>
        </ul>
    </form>`;
    return form;
}


function generaArticoli(articoli) {
    let result = `
    <section>
        <h2>Articoli</h2>
        <a href="gestisci-articoli.php?action=1">Inserisci Articolo</a>
        <table>
            <tr>
                <th>Titolo</th><th>Immagine</th><th>Azione</th>
            </tr> `

    for (let i = 0; i < articoli.length; i++) {
        result += `
            <tr>
                <td>${articoli[i]["titoloarticolo"]}</td>
                <td><img src="${articoli[i]["imgarticolo"]}" alt="" /></td>
                <td>
                    <a href="gestisci-articoli.php?action=2&id=${articoli[i]["idarticolo"]}">Modifica</a>
                    <a href="gestisci-articoli.php?action=3&id=${articoli[i]["idarticolo"]}">Cancella</a>
                </td>
            </tr>
        `;
    }
    result += `
        </table>
    </section>`;

    return result;
}

async function getLoginData() {
    const url = 'api-login.php';
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        console.log(json);
        if(json["logineseguito"]){
            visualizzaArticoli(json["articoliautore"]);
        }
        else{
            visualizzaLoginForm();
        }


    } catch (error) {
        console.log(error.message);
    }
}

const main = document.querySelector("main");
getLoginData();  

/*
axios.get('api-login.php').then(response => {
    console.log(response);
    if (response.data["logineseguito"]) {
        // Utente loggato
        visualizzaArticoli(response.data["articoliautore"]);
    } else {
        // Utente NON loggato
        visualizzaLoginForm();
    }
});
*/

function visualizzaArticoli(listaArticoli) {
    let articoli = generaArticoli(listaArticoli);
    main.innerHTML = articoli;
}

function visualizzaLoginForm() {
    // Utente NON loggato
    let form = generaLoginForm();
    main.innerHTML = form;
    // Gestisco tentativo di login
    document.querySelector("main form").addEventListener("submit", function (event) {
        event.preventDefault();
        const username = document.querySelector("#username").value;
        const password = document.querySelector("#password").value;
        login(username, password);
    });
}

async function login(username, password) {
    const url = 'api-login.php';
    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    try {

        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        if(json["logineseguito"]){
            visualizzaArticoli(json["articoliautore"]);
        }
        else{
            document.querySelector("form > p").innerText = json["errorelogin"];
        }


    } catch (error) {
        console.log(error.message);
    }
}
