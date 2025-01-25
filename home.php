<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Courier</title>
    <link rel="shortcut icon" href="./img/logo2.png" type="image/x-icon">
    <!-- fon t cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- daust yui css library link -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css" rel="stylesheet" type="text/css" />

    <!-- bostrap library link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- my css -->
    <style>
        .carousel {
            display: block;

        }

        .carousel_img img {
            height: 400px;

        }
    </style>
</head>

<body>

    <!-- nav var -->
    <header>
        <!-- fast nav -->
        <div class="navbar bg-base-100 container-fluid">
            <div class="navbar-start">
                <div class="navbar-center">
                    <a class="btn btn-ghost text-xl"><i class="fa-solid fa-phone"></i>Help:- 011231222</a>
                </div>
            </div>

            <div class="navbar-end">
                <a class="btn btn-ghost text-xl"><i class="fa-solid fa-right-to-bracket"></i>Go Sets</a>

            </div>
        </div>


        <nav class="container">
            <div class="navbar bg-base-100">
                <div class="navbar-start">
                    <a class="text-xl" href="#"><img src="./img/logo2.png" alt=""
                            style="width:200px; position:absolute; margin-top:-83px; border-radius: 50px 50px 50px 50px; margin-left:-30px;"></a>
                </div>
                <div class="navbar-center hidden lg:flex">
                    <ul class="menu menu-horizontal px-1">
                        <li><a>Home</a></li>
                        <li>
                            <details>
                                <summary>About us</summary>
                                <ul class="p-2 z-10">

                                    <li><a>Submenu 1</a></li>
                                    <li><a>Submenu 2</a></li>

                                </ul>
                            </details>
                        </li>
                        <li>
                            <details>
                                <summary>Our Service</summary>
                                <ul class="p-2 z-10">

                                    <li><a>Submenu 1</a></li>
                                    <li><a>Submenu 2</a></li>

                                </ul>
                            </details>
                        </li>
                        <li><a>Notice Board</a></li>
                        <li>
                            <details>
                                <summary>Supports</summary>
                                <ul class="p-2 z-10">

                                    <li><a>Submenu 1</a></li>
                                    <li><a>Submenu 2</a></li>

                                </ul>
                            </details>
                        </li>
                        <li> <a class="btn-danger" href="./rootfolder/track.php">Track Me</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <!-- carosoul -->
        <section>
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active carousel_img">
                        <img src="./img/carr1.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item carousel_img">
                        <img src="./img/car2.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item carousel_img">
                        <img src="./img/car5.png" class="d-block w-100" alt="...">
                    </div>
                </div>



                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section><br>

        <!-- carosoul end -->

        <!-- after carosoul -->

        <section>
            <div class="container">
                <h1 class="text-5xl font-bold text-center">Our Valueable Services</h1>
                <p class="text-center">Thanks for staying at <a href="#" style="color:orange;">Fast Track</a>.We hope to
                    have the pleasure of doing business with you in the future.</p>

                <div class="hero bg-base-200 min-h-screen">
                    <div class="hero-content flex-col lg:flex-row-reverse">
                        <div>
                            <div>
                                <img src="./img/ict.png" class="w-24 rounded-full" />

                                <h1 class="text-2xl font-bold">Mobile & ICT Equipment Service</h1>
                                <p class="py-6">
                                    These are regular parcel services limited to the mobile and ICT
                                    importers/distributors/manufacturers and vendors. who seek the parcel delivery
                                    services
                                    from
                                    us.
                                </p>
                                <button class="btn btn-primary">Get Started</button>
                            </div><br>
                            <div>
                                <img src="./img/ECommerce.png" class="w-24 rounded-full" />

                                <h1 class="text-2xl font-bold">E-Commerce Service </h1>
                                <p class="py-6">
                                    These are regular parcel services limited to the mobile and ICT
                                    importers/distributors/manufacturers and vendors. who seek the parcel delivery
                                    services
                                    from
                                    us.
                                </p>
                                <button class="btn btn-primary">Get Started</button>
                            </div>
                        </div>
                        <div class="avatar">

                            <img src="./img/round.png" class="w-24 rounded-full" />

                        </div>
                        <div>
                            <div>
                                <img src="./img/doc.png" class="w-24 rounded-full" />
                                <h1 class="text-2xl font-bold">Document Service</h1>
                                <p class="py-6">
                                    Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi
                                    exercitationem
                                    quasi. In deleniti eaque aut repudiandae et a id nisi.
                                </p>
                                <button class="btn btn-primary">Get Started</button>

                            </div><br>
                            <div>
                                <img src="./img/dolar.png" class="w-24 rounded-full" />
                                <h1 class="text-2xl font-bold">Value Declared Service</h1>
                                <p class="py-6">
                                    Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi
                                    exercitationem
                                    quasi. In deleniti eaque aut repudiandae et a id nisi.
                                </p>
                                <button class="btn btn-primary">Get Started</button>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>
        <br>
        <section class="container">
            <div class="container" style="border:1px solid gray; padding: 20px;">
                <h1 class="text-5xl font-bold text-center">Our Location</h1>
                <p class="text-center text-2xl">Fast-track Courier Service has the most widespread network in
                    Bangladesh. Click below to view a list of all our Branches and Agencies.</p>
                <div class="text-center">
                    <button class="btn btn-info"><a href="./adminpannel/pages/branch/branchshow.php">View
                            list</a></button>
                </div>
            </div>
        </section>
        <br>
        <section>
            <div>
                <div class="container">
                    <h1 class="text-4xl font-bold text-center">Why First-track Courier Service (Pvt.) Ltd</h1>
                    <p class="text-center text-xl">First-track is a household name to all in Bangladesh for having been
                        the pioneer of Courier and Parcel Services in this country. From the Corporate Clients to the
                        average person all the persons have been availing the services of Sundarban.</p>
                </div>
            </div><br>
            <div style="display:flex;" class="container">
                <div>
                    <img src="./img/four.png" alt="img" style="width:300px;  heaight:240px; margin-left:150px;">

                </div>
                <div style="width:700px; margin-left:20px;">
                    <p><i class="fa-solid fa-circle-check" style="color:green;"></i> It is reliable and the label is a
                        trustworthy name to all who have taken, taking and will take the services of this Company. The
                        many years of service to the mass and to the corporates have made it the service for all to
                        take.</p>
                    <p><i class="fa-solid fa-circle-check " style="color:green;"></i> It is reliable and the label is a
                        trustworthy name to all who have taken, taking and will take the services of this Company. The
                        many years of service to the mass and to the corporates have made it the service for all to
                        take.</p>
                    <p><i class="fa-solid fa-circle-check" style="color:green;"></i> It is reliable and the label is a
                        trustworthy name to all who have taken, taking and will take the services of this Company. The
                        many years of service to the mass and to the corporates have made it the service for all to
                        take.</p>

                </div>
            </div>
        </section><br>
        <!-- ques patern -->
        <!-- bootstrap -->
        <section class="container p-5">
            <div class="accordion" id="accordionExample" style="border: 1px solid #ddd; border-radius: 5px;">
                <div class="accordion-item" style="border-bottom: 1px solid #ddd;">
                    <h2 class="accordion-header" id="headingOne" style="margin: 0; padding: 0;">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                            style="background-color: lightblue; color: black; font-size: 16px; padding: 10px 15px; border: none; outline: none; display: flex; align-items: center; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">
                            Our Speed
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample"
                        style="padding: 10px; font-size: 14px; background-color: #ffffff;">
                        <div class="accordion-body" style="margin: 0;">
                            <p style="margin: 0;">Why use a Courier Service if the item won’t arrive quickly? Our
                                streamlined network ensures the fastest possible movement of documents and packages.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item" style="border-bottom: 1px solid #ddd;">
                    <h2 class="accordion-header" id="headingTwo" style="margin: 0; padding: 0;">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
                            style="background-color: lightblue; color: black; font-size: 16px; padding: 10px 15px; border: none; outline: none; display: flex; align-items: center; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">
                            Low Cost
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample"
                        style="padding: 10px; font-size: 14px; background-color: #ffffff;">
                        <div class="accordion-body" style="margin: 0;">
                            <p style="margin: 0;">All rates are quite reasonable, even for heavy/lightweight items,
                                fragile items, articles or bulky printed materials.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree" style="margin: 0; padding: 0;">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"
                            style="background-color: lightblue; color: black; font-size: 16px; padding: 10px 15px; border: none; outline: none; display: flex; align-items: center; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">
                            Simplicity
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample"
                        style="padding: 10px; font-size: 14px; background-color: #ffffff;">
                        <div class="accordion-body" style="margin: 0;">
                            <p style="margin: 0;">One telephone call is all it takes to set the process in motion. After
                                that you can leave everything to us, including customs clearance and any last minute
                                details.</p>
                        </div>
                    </div>
                </div>
            </div>



        </section>

        <section>
            <div class="container">
                <div class="container">
                    <h1 class="text-5xl font-bold text-center">Asked Question About First-track</h1>
                    <p class="text-center text-xl">See the most frequently asked questions.We are here to help.</p>
                </div>
                <br>
                <h1 style="margin-left:90px" class="text-3xl"><span class="text-[#ffd600] font-bold">01</span> What is
                    Fast-track?</h1>
                <p style="margin-left:110px" class="text-2xl">Fast-track is a well-known courier & parcel services in
                    Bangladesh. </p>
            </div>
            <br>

        </section>


    </main>
    <footer>
        <footer class="footer bg-base-200 text-base-content p-10">
            <nav>
                <h6 class="footer-title">Services</h6>
                <a class="link link-hover">Branding</a>
                <a class="link link-hover">Design</a>
                <a class="link link-hover">Marketing</a>
                <a class="link link-hover">Advertisement</a>
            </nav>
            <nav>
                <h6 class="footer-title">Company</h6>
                <a class="link link-hover">About us</a>
                <a class="link link-hover">Contact</a>
                <a class="link link-hover">Jobs</a>
                <a class="link link-hover">Press kit</a>
            </nav>
            <nav>
                <h6 class="footer-title">Legal</h6>
                <a class="link link-hover">Terms of use</a>
                <a class="link link-hover">Privacy policy</a>
                <a class="link link-hover">Cookie policy</a>
            </nav>
        </footer>
        <footer class="footer bg-base-200 text-base-content border-base-300 border-t px-10 py-4">
            <aside class="grid-flow-col items-center">
                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd"
                    clip-rule="evenodd" class="fill-current">
                    <path
                        d="M22.672 15.226l-2.432.811.841 2.515c.33 1.019-.209 2.127-1.23 2.456-1.15.325-2.148-.321-2.463-1.226l-.84-2.518-5.013 1.677.84 2.517c.391 1.203-.434 2.542-1.831 2.542-.88 0-1.601-.564-1.86-1.314l-.842-2.516-2.431.809c-1.135.328-2.145-.317-2.463-1.229-.329-1.018.211-2.127 1.231-2.456l2.432-.809-1.621-4.823-2.432.808c-1.355.384-2.558-.59-2.558-1.839 0-.817.509-1.582 1.327-1.846l2.433-.809-.842-2.515c-.33-1.02.211-2.129 1.232-2.458 1.02-.329 2.13.209 2.461 1.229l.842 2.515 5.011-1.677-.839-2.517c-.403-1.238.484-2.553 1.843-2.553.819 0 1.585.509 1.85 1.326l.841 2.517 2.431-.81c1.02-.33 2.131.211 2.461 1.229.332 1.018-.21 2.126-1.23 2.456l-2.433.809 1.622 4.823 2.433-.809c1.242-.401 2.557.484 2.557 1.838 0 .819-.51 1.583-1.328 1.847m-8.992-6.428l-5.01 1.675 1.619 4.828 5.011-1.674-1.62-4.829z">
                    </path>
                </svg>
                <p>
                    First-track courier Ltd.
                    <br />
                    Providing reliable tech since 1992
                </p>
            </aside>
            <nav class="md:place-self-center md:justify-self-end">
                <div class="grid grid-flow-col gap-4">
                    <a style="color:red" href="https://x.com/" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="fill-current">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z">
                            </path>
                        </svg>
                    </a>
                    <a href="https://youtu.be/Kbs1whBR_io" style="color:red" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="fill-current">
                            <path
                                d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z">
                            </path>
                        </svg>
                    </a>
                    <a style="color:red" href="https://www.facebook.com" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="fill-current">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                            </path>
                        </svg>
                    </a>
                </div>
            </nav>
        </footer>
    </footer>



    <!-- taildwin -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- bootstrap -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>