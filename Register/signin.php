<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

    </style>
</head>

<body
    style="background: rgb(205,198,214); background: linear-gradient(90deg, rgba(205,198,214,1) 0%, rgba(204,126,219,1) 15%, rgba(235,169,75,1) 31%, rgba(163,233,27,1) 46%, rgba(90,227,92,1) 57%, rgba(73,240,132,1) 70%, rgba(48,209,183,1) 84%, rgba(110,167,201,1) 96%);">
    <div class="container">
        <div class="card  my-5 border-primary rounded-5 px-3 py-1"
            style="background: rgb(238,174,202); background: radial-gradient(circle, rgba(238,174,202,0.4962359943977591) 0%, rgba(148,187,233,0.5) 100%);">
            <div class="row text-center">
                <div class="col-6 align-self-center">
                    <div>
                        <img src="" alt="">
                    </div>
                    <div class="mx-5 text-start">
                        <p>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque voluptatum, impedit
                            distinctio cupiditate nulla consequuntur, dignissimos aliquid consequatur officia id ipsum
                            quibusdam rem quod adipisci. Similique et sed unde. Ipsam?
                        </p>
                    </div>
                </div>

                <div class="col-6 align-self-center bg-white border rounded-end rounded-5 p-0">
                    <div class="mx-3 my-3">
                        <h2>Welcome back!</h2>
                        <div class="" style="padding-left:40%;">
                            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                                type="module"></script>

                            <dotlottie-player
                                src="https://lottie.host/470b48f3-3ef7-4f60-974b-e860436c5abd/zz4iOzJzia.json"
                                background="transparent" speed="1" style="width: 100px; height: 100px;" loop
                                autoplay></dotlottie-player>
                        </div>
                        <h4>Login to Continute</h4>
                    </div>
                    <form>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-4 text-start fs-5">
                                <label for="email" class="form-label">Email</label>
                            </div>

                            <div class="col-6">
                                <input type="email" class="form-control" id="email">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-4 text-start fs-5">
                                <label for="passowrd" class="form-label">Password</label>
                            </div>

                            <div class="col-6">
                                <input type="password" class="form-control" id="password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <div class="form-check p-0 badge text-wrap text-dark mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            I have agreed to the terms and conditions.
                        </label>
                    </div>
                    <p>
                        Don't have an account?<a href="./signup.php">Sing up</a>
                    </p>
                </div>
            </div>

        </div>

    </div>
</body>

</html>