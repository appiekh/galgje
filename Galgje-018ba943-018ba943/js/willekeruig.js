const woorden = ["fortnite", "telescoop", "kees", "laptop", "stoel", "zesentwintig", "hallo daar"];


const randomIndex = Math.floor(Math.random() * woorden.length);
const randomWoord = woorden[randomIndex];

let hangmanImg = document.getElementById("hangman-img");

let correctGuesses = 0;


// for(let i = 0; i < woordLetters.length -1; i++){
//     if()
// }
underscoresMaken();

function underscoresMaken() {
    for (let i = 0; i < randomWoord.length; i++) {
        let underscore = document.createElement("span");
        underscore.className = "underscore";
        underscore.id = "underscore_" + i;
        document.body.appendChild(underscore);
    }
}

function updateWordDisplay(value) {
    for (let i = 0; i < randomWoord.length; i++) {
        if (randomWoord.charAt(i) === value) {
            let correctLetterSpan = document.getElementById("underscore_" + i);
            correctLetterSpan.textContent = value; 
            correctLetterSpan.classList.remove("underscore"); 
        }
    }
}


let form = document.getElementById("myForm");
let allLetters = document.getElementById("allLetters")
let letters = [];

document.write("<div>")
for (i = 1; i <= 26; i++) {
    console.log();
    let button = document.createElement("button");
    button.className = "alphabet";
    button.innerHTML = String.fromCharCode(i + 96);
    document.body.appendChild(button);
    if (i % 7 === 0) {
        document.body.appendChild(document.createElement("br"));
    }
    button.addEventListener("click", function (event) {
        let buttonValue = event.target.innerHTML;
        ButtonClicked(buttonValue, button);
    });
}
document.write("</div>")
let rightGuesses = 0;
let tries = 6;
let currentTries = document.getElementById("tries");
currentTries.innerHTML = `Tries : ${tries}`;

function handleForm(event) { event.preventDefault(); }

form.addEventListener('submit', handleForm);

let errorMsg = document.getElementById("errorMsg");
let rightGuessElement = document.getElementById("rightGuess");
let gameOver = document.getElementById("gameOver");
let gameOver2 = document.getElementById("gameOver2");
let goedeWoord = document.getElementById("goedeWoord");
let wrongGuess = [];
let rightGuess = [];

function ButtonClicked(value, button) {
    if (tries !== 0 & checkWin() == false) {
        console.log(tries);
        if (!randomWoord.includes(value)) {
            if (!wrongGuess.includes(value)) {
                wrongGuess.push(value);
                tries--;
                currentTries.innerHTML = `Tries : ${tries}`;
                button.classList.add("incorrect");
                let triesGereversd =  6 - tries;
                hangmanImg.src = `../images/hangman-${triesGereversd}.svg`;
            }
            if (tries === 0) {
                gameOver.innerHTML = "Game Over, Restart de game door een nieuwe game te starten !!!! :) ";
                console.log("Game Over");
                goedeWoord.innerHTML = `Het goede woord was: ${randomWoord}`;
            }
            // errorMsg.innerHTML = `Wrong guess: ${wrongGuess} `;
            
        } else {
            if (!rightGuess.includes(value)) {
                rightGuess.push(value);
                rightGuesses++; 
                if (checkWin()) { 
                    gameOver.innerHTML = "JE HEBT GEWONNNEN! Begin maar een nieuw potje! :)";
                }
            }
            for (let i = 0; i < randomWoord.length; i++) {
                if (randomWoord.charAt(i) == value) {
                    let correctCharater = randomWoord[i];
                    updateWordDisplay(correctCharater);
                }
            }
            // rightGuessElement.innerHTML = `Right guess: ${rightGuess} `;
            button.classList.add("correct");
        }
    } else {
        gameOver2.innerHTML = "gast, restart de game nou.";
    }
}
function checkWin() {
    for (let i = 0; i < randomWoord.length; i++) {
        if (!rightGuess.includes(randomWoord[i])) {
            return false;
        }
    }
    return true;
}
