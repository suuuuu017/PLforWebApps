/**
 * This function will query the CS4640 server for a new word.
 *
 * It makes use of AJAX and Promises to await the result.  We won't discuss
 * promises in detail, so you're welcome to review this code for more
 * details.  However, essentially we need the browser to send an AJAX query
 * to our API and then wait for a reply.  If it just waits, then the browser
 * tab will appear to be frozen briefly while the HTTP request is taking place.
 * Therefore, we send the request with a Promise that awaits the results.  When
 * the response comes back from the server, the promise will return the result
 * to our getRandomWord() function and that will call your function.  This happens
 * asynchronously, so you should treat your function like you would an event
 * handler.
 */
function queryWord() {
    return new Promise( resolve => {
        // instantiate the object
        var ajax = new XMLHttpRequest();
        // open the request
        ajax.open("GET", "https://cs4640.cs.virginia.edu/api/wordleword.php", true);
        // ask for a specific response
        ajax.responseType = "text";
        // send the request
        ajax.send(null);

        // What happens if the load succeeds
        ajax.addEventListener("load", function() {
            // Return the word as the fulfillment of the promise
            if (this.status == 200) { // worked
                resolve(this.response);
            } else {
                console.log("When trying to get a new word, the server returned an HTTP error code.");
            }
        });

        // What happens on error
        ajax.addEventListener("error", function() {
            console.log("When trying to get a new word, the connection to the server failed.");
        });
    });
}

/**
 * This is the function you should call to request a new word.
 * It takes one parameter: a callback function.  The function
 * passed in (i.e., a function you write) should take one
 * parameter (the new word provided by the server) and handle the
 * setup of your new game.  For example, if you write a function
 * named "setUpNewGame(newWord)", then in your event handler for a new
 * game, you should call this function as:
 *     getRandomWord(setUpNewGame);
 * Our getRandomWord function  will wait for the server to provide
 * a new word, and then it will call **your** function, passing in
 * the word, so that your fucntion can continue setting up the new game.
 */
async function getRandomWord(callback) {
    var newWord = await queryWord();
    callback(newWord);
    document.getElementById("historyGuess").innerHTML = "";
    if(localStorage.getItem("justwon") === "null"){
        localStorage.setItem("winStreak", JSON.stringify(0));
    }
    localStorage.setItem("history", JSON.stringify([]));
    document.getElementById("guess").value = "";
    printStats();
    enableGuess();
}

function callback(word) {
    console.log(word);
    localStorage.setItem("word", word);
    if(localStorage.getItem("gamesPlayed") == null){
        localStorage.setItem("gamesPlayed", JSON.stringify(1));
    }
    else{
        var tmp = localStorage.getItem("gamesPlayed");
        var gamesPlayed = JSON.parse(tmp);
        gamesPlayed = gamesPlayed + 1;
        localStorage.setItem("gamesPlayed", JSON.stringify(gamesPlayed));
    }
}

function guessWord(){

    if(localStorage.getItem("guessNum") == null){
        localStorage.setItem("guessNum", JSON.stringify(1));
    }
    else{
        var tmp = localStorage.getItem("guessNum");
        var guessNum = JSON.parse(tmp);
        guessNum = guessNum + 1;
        localStorage.setItem("guessNum", JSON.stringify(guessNum));
    }

    if(localStorage.getItem("history") == null){
        // TODO: dk why i can put getitem into parse
        localStorage.setItem("history", JSON.stringify([]));
        var s = localStorage.getItem("history");
        var history = JSON.parse(s);
    }
    else{
        history = JSON.parse(localStorage.getItem("history"));
    }

    var guess = document.getElementById("guess").value;
    var word = localStorage.getItem("word");
    console.log(guess);
    document.getElementById("guess").value = "";

    var lowerguess = guess.trim().toLowerCase();
    var lowerword = word.toLowerCase();

    if(lowerguess.length < lowerword.length){
        console.log("Your guess is too short.");
    }
    else{
        console.log("Your guess is too long.");
    }

    var count = 0;
    for(let i = 0; i < lowerguess.length; i++){
        if (lowerword.includes(lowerguess[i])) {
            count++;
        }
    }
    console.log("word is " + word);
    console.log(count + " characters are in the answer.");

    var locCount = 0;
    for(let i = 0; i < lowerword.length && i < lowerguess.length; i++) {
        if (lowerword[i] === lowerguess[i]) {
            locCount++;
        }
    }
    console.log(locCount + " characters are in the right location.");

    var thisguess = {"guess": lowerguess, "count": count, "locCount": locCount};

    history.push(thisguess);

    localStorage.setItem("history", JSON.stringify(history));

    printHistory();
    localStorage.setItem("justwon", JSON.stringify(null));

    if(lowerguess.length === lowerword.length && count === lowerword.length && locCount === lowerword.length){
        localStorage.setItem("justwon", JSON.stringify(1));
        if(localStorage.getItem("win") == null){
            localStorage.setItem("win", JSON.stringify(0));
            var w = localStorage.getItem("win");
            var win = JSON.parse(w);
        }
        else{
            w = localStorage.getItem("win");
            win = JSON.parse(w);
        }
        win = win + 1;
        localStorage.setItem("win", JSON.stringify(win));
        disableGuess();
        alert("You won, plese start a new game.");
        if(localStorage.getItem("winStreak") == null){
            localStorage.setItem("winStreak", JSON.stringify(1));
            var ws = localStorage.getItem("winStreak");
            var winStreak = JSON.parse(ws);
        }
        else{
            ws = localStorage.getItem("winStreak");
            winStreak = JSON.parse(ws);
            winStreak = winStreak + 1;
            localStorage.setItem("winStreak", JSON.stringify(winStreak));
        }
    }


    printStats();

}

function enableGuess() {
    var inputElement = document.getElementById('guess');
    inputElement.disabled = false;
}

function disableGuess() {
    var inputElement = document.getElementById('guess');
    inputElement.disabled = true;
}

function printStats(){
    if(localStorage.getItem("win") == null){
        var win = 0;
    }
    else{
        var w = localStorage.getItem("win");
        win = JSON.parse(w);
    }
    var printhis = "You have won " + win + " times.";

    if(localStorage.getItem("gamesPlayed") == null){
        var gamesPlayed = 0;
    }
    else{
        var gp = localStorage.getItem("gamesPlayed");
        gamesPlayed = JSON.parse(gp);
    }

    printhis = printhis + " You have played " + gamesPlayed + " games.";


    if(localStorage.getItem("guessNum") == null){
        var guessNum = 0;
    }
    else{
        var gn = localStorage.getItem("guessNum");
        guessNum = JSON.parse(gn);
    }
    printhis = printhis + " Your average guesses per game is " + guessNum/gamesPlayed + ".";

    if(localStorage.getItem("winStreak") == null){
        var winStreak = 0;
    }
    else{
        var ws = localStorage.getItem("winStreak");
        winStreak = JSON.parse(ws);
    }
    printhis = printhis + " You are on a " + winStreak + " win streak.";

    document.getElementById("statics").innerHTML = printhis;
}

function printHistory(){
    if(localStorage.getItem("history") == null){
        // TODO: dk why i can put getitem into parse
        localStorage.setItem("history", JSON.stringify([]));
        var s = localStorage.getItem("history");
        var history = JSON.parse(s);
    }
    else{
        history = JSON.parse(localStorage.getItem("history"));
    }

    var printhis = history.map(h => {
        return `Guess was: ${h.guess}, ${h.count} characters are in the answer,
         ${h.locCount} characters are in the right location.`;
    }).join("<br>");

    document.getElementById("historyGuess").innerHTML = printhis;
}

function clearhistory(){
    localStorage.removeItem("word");
    localStorage.removeItem("history");
    localStorage.removeItem("win");
    localStorage.removeItem("gamesPlayed");
    localStorage.removeItem("guessNum");
    localStorage.removeItem("winStreak");
    document.getElementById("historyGuess").innerHTML = "";
    printStats();
}

function savestuff(){
    localStorage.setItem("word", document.getElementById("word").value);
    localStorage.setItem("preGuess", document.getElementById("guess").value);
}

function loadstuff(){
    document.getElementById("guess").value = localStorage.getItem("preGuess");
    enableGuess();
    printHistory();
    printStats();
}