const divMenu = document.querySelector("#menu");
const form = document.querySelector("#menu-form");
const userName = form.querySelector("#name");
const level = form.querySelector("#level");

const rulesButton = document.querySelector("#rules");
const rulesContent = document.querySelector("#rules-content");
const rulesClose = document.querySelector("#rules-close");

const divGame = document.querySelector("#game-screen");
const divGameOver = document.querySelector("#game-over");

export default {
    divMenu,
    form,
    userName,
    level,
    rulesButton,
    rulesContent,
    rulesClose,
    divGame,
    divGameOver
}