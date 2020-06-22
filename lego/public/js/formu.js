const alpha = /^[A-Za-z\é\è\ê\ç\æ\œ\  \-]+$/;
const pass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/;
const mail = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
const adress = /^[0-9]([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]){1,500}$/;

let errName = document.getElementById("errName");
let errFirstName = document.getElementById("errFirstName");
let errMail = document.getElementById("errMail");
let errPassword = document.getElementById("errPassword");
let errPassword2 = document.getElementById("errPassword2");
let errAddress = document.getElementById("errAddress");
let errCity = document.getElementById("errCity");

function verifName(name) {
    if (name === "") {
        errName.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner votre nom</h6>";
        event.preventDefault();
    } else if (!alpha.test(name)) {
        errName.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner un nom valide</h6>";
        event.preventDefault();
    } else {
        errName.innerHTML = "<h6 class=\"alert alert-success text-center\" role=\"alert\">Ok</h6>";

    }
}

function verifFirstName(first) {
    if (first === "") {
        errFirstName.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner votre prénom</h6>";
        event.preventDefault();
    } else if (!alpha.test(first)) {
        errFirstName.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner un prénom valide</h6>";
        event.preventDefault();
    } else {
        errFirstName.innerHTML = "<h6 class=\"alert alert-success text-center\" role=\"alert\">Ok</h6>";

    }
}

function verifCity(city) {
    if (city === "") {
        errCity.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner votre ville</h6>";
        event.preventDefault();
    } else if (!alpha.test(city)) {
        errCity.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner une ville valide</h6>";
        event.preventDefault();
    } else {
        errCity.innerHTML = "<h6 class=\"alert alert-success text-center\" role=\"alert\">Ok</h6>";

    }
}

function verifPassword(password) {
    if (password === "") {
        errPassword.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner un mot de passe</h6>";
        event.preventDefault();
    } else if (!pass.test(password)) {
        errPassword.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\"> Votre mot de passe n'est pas assez complexe</h6>";
        event.preventDefault();
    } else {
        errPassword.innerHTML = "<h6 class=\"alert alert-success text-center\" role=\"alert\">Ok</h6>";

    }
}

function verifPassword2(password) {
    let pwd = document.getElementById("registration_form_plainPassword_first");
    if (password === "") {
        errPassword2.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner à nouveau votre mot de passe</h6>";
        event.preventDefault();
    } else if (pwd.value !== password) {
        errPassword2.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\"> Vos mots de passe sont différents</h6>";
        event.preventDefault();
    } else {
        errPassword2.innerHTML = "<h6 class=\"alert alert-success text-center\" role=\"alert\">Ok</h6>";

    }
}

function verifMail(email) {
    if (email === "") {
        errMail.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner votre adresse mail</h6>";
        event.preventDefault();
    } else if (!mail.test(email)) {
        errMail.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner une adresse mail valide</h6>";
        event.preventDefault();
    } else {
        errMail.innerHTML = "<h6 class=\"alert alert-success text-center\" role=\"alert\">Ok</h6>";

    }
}

function verifAddress(address) {
    if (address === "") {
        errAddress.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner votre adresse </h6>";
        event.preventDefault();
    } else if (!adress.test(address)) {
        errAddress.innerHTML = "<h6 class=\"alert alert-danger text-center\" role=\"alert\">Veuillez renseigner une adresse valide</h6>";
        event.preventDefault();
    } else {
        errAddress.innerHTML = "<h6 class=\"alert alert-success text-center\" role=\"alert\">Ok</h6>";

    }
}

var check = document.getElementById('envoie');
// Ajout de l'evenement click sur le bouton s'identifier
check.addEventListener("click", function verif(event) {
    // Recuperation des valeurs rentre dans chaque champs du formulaire
    let name = document.getElementById("registration_form_name").value;
    let first = document.getElementById("registration_form_firstName").value;
    let ville = document.getElementById("registration_form_city").value;
    let pass1 = document.getElementById("registration_form_plainPassword_first").value;
    let pass2 = document.getElementById("registration_form_plainPassword_second").value;
    let adrMail = document.getElementById("registration_form_email").value;
    let adr = document.getElementById("registration_form_delivryAdress").value;

    // Execution des fonctions de controle definit plus haut
    verifName(name);
    verifFirstName(first);
    verifCity(ville);
    verifPassword(pass1);
    verifPassword2(pass2);
    verifMail(adrMail);
    verifAddress(adr);
});

let name = document.getElementById("registration_form_name");
name.addEventListener("keyup", function keyName() {
    verifName(this.value);
});

let first = document.getElementById("registration_form_firstName");
first.addEventListener("keyup", function keyFirst() {
    verifFirstName(this.value);
});

let city = document.getElementById("registration_form_city");
city.addEventListener("keyup", function keyCity() {
    verifCity(this.value);
});

let pwd = document.getElementById("registration_form_plainPassword_first");
pwd.addEventListener("keyup", function keyPassword() {
    verifPassword(this.value);
});

let pwd2 = document.getElementById("registration_form_plainPassword_second");
pwd2.addEventListener("keyup", function keyPassword2() {
    verifPassword2(this.value);
});


let email = document.getElementById("registration_form_email");
email.addEventListener("keyup", function keyMail() {
    verifMail(this.value);
});

let home = document.getElementById("registration_form_delivryAdress");
home.addEventListener("keyup", function keyAddress() {
    verifAddress(this.value);
});