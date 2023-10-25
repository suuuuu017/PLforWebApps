<!-- Welcome page must ask for at least their name and email -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Website</title>
    <link rel="stylesheet" href="./welcomepage.css">

    </head>
  <body>
    <main>
        <h1 style="position: center;"class="greeting" > Welcome to Connections!</h1>  

        <form action="?command=login" method="post">

            <div class="form">

                <label for="name">Enter Your Name: </label>
                    <input type="text" id="name" name="name" placeholder="John Smith"/>
                <br> 

                <label for="email"> Enter your Email:</label>

                    <input id="email" name="email" placeholder="johnSmith@hotmail.com"> </input>
                </label>

                <!-- button code -->
                    <div class="container">
                        <button id="btn">
                            <p id="btnText">Play Now!</p>
                            <div class="check-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path fill="transparent" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                                </svg>
                            </div>
                        </button>
                    </div>
            </div>

        </form>

    </main>

  <script type="text/javascript">
        const btn = document.querySelector("#btn");
        const btnText = document.querySelector("#btnText");

        btn.onclick = () => {
            btnText.innerHTML = "Thanks";
            btn.classList.add("active");
        };
    
    </script>

  </body>
</html>
