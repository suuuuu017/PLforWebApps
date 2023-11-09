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
}

function callback(word) {
    console.log(word);
    localStorage.setItem("word", word);
}

function guessWord(newWord){

    var guess = document.getElementById("guess").value;
    var word = localStorage.getItem("word");
    console.log(guess);
    document.getElementById("guess").value = "";

    var lowerguess = guess.toLowerCase();
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
}