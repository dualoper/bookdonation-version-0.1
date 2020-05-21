<?php 
    session_start();
    include('./account/conn.php');
    $_SESSION['cart'] = 1;
                                            // funcrion for display books
    function select_by_category($cat){
        include('./account/conn.php');
        $sql = "SELECT * FROM `books` WHERE ((`category` = '".$cat."') AND (`pickedup` = 'yes') AND (`remains` > 0)) ORDER BY `book_id` DESC LIMIT 6";
        $result = mysqli_query($conn,$sql);
        return($result);
    }

?>

<?php include_once('./header.php') ?>

<!-- carousel  -->
<div id="demo" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ul class="carousel-indicators" style="z-index: 1;">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2"></li>
    </ul>

    <!-- The slideshow -->
    <div class="carousel-inner">
        <div class="carousel-item bg-light active px-5" id="carousel1">
        <img src="http://localhost/bookdonation/links/image/carousel 1.jpg" alt="" class="float-right img-fluid mt-2" width="30%">
            <p><span class="h1 text-success">WE MAKE A</span><span class="display-4"> LIVING</span><span class="text-success">BY</span></p>
            <p><span class="text-danger display-3 font-weight-bold">WHAT WE GET</span><span class="text-dark h3"> BUT WE MAKE A</span><span class="display-4"> LIFE</span><span class="text-secondary">BY</span></p>
            <p class="display-1 text-primary text-center font-weight-bold">WHAT WE GIVE</p>
            <img src="http://localhost/bookdonation/links/image/carousel 1.jpg" alt="">
        </div>
        <div class="carousel-item" id="carousel2">
        </div>
        <div class="carousel-item" id="carousel3">
        </div>
    </div>

</div>

<!-- text black background -->
<div class="container-fluid">
    <div class="row my-5 py-5">
        <div class="col-md-5 text-center">
            <img src="./links/image/book balance.gif" alt="books" class="ml-5">
        </div>
        <div class="col-md-7 bg-black text-white p-5 text-justify w3-animate-left">
            Books are sources of information from very early time. Still they are considered as a medium to spread education to the people. 
            Form our childhood; we have started learning with the help of the books. As library professionals, the authors have seen many 
            instances where people are interested to donate books to the libraries but the libraries where they are contacting are unable 
            to receive the books due to their acquisition policies or may be due to lack of space.
            <br>
            Sometimes, many old books are sold at very less price to the persons who come home to receive used items. Many libraries also 
            weed out books due to lack of space which are still in good condition. On the contrary, there are many instances, where people 
            do not have money to procure books and many libraries also run out of budget and can’t procure books. Many people are interested 
            in reading but due to lack of money they cannot read. Many NGOs are existing which runs programmes like Donate-A-Book. But under 
            the programme, they collect money and with the money books are procured. But there should be some mechanism which will make use 
            of the available books rather than procuring new books as a part of helping needy people. The donated money may be then used 
            somewhere else for the development. This effort may also help to find out sources of donor who wants to donate text books of their 
            children after they pass out to some needy students. 
        </div>
    </div>
</div>

<!-- books  -->
<div class="container-fluid">

    <!-- Education  -->
    <?php
        $cat = "education";
        $result = select_by_category($cat);
        if(mysqli_num_rows($result)){
            echo '<a href="./search/?search=education" class="text-dark mt-5"><h2 class="shadow">Educational Books >></h2></a>
                <div class="row px-5 pb-5 bookrow">';
            while($row = mysqli_fetch_assoc($result)){
                echo'<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <a href="./search/book.php?id='.$row['book_id'].'">
                            <div class="card bg-dark border-warning w3-hover-shadow my-2">
                                <img src="./links/path/books/'.$row['book_image'].'" alt="j" class="card-img-top" height="200">
                                <div class="card-body">
                                    <h4 class="card-title text-warning text-truncate">'.ucwords($row['book_name']).'</h4>
                                    <h6 class="card-subtitle text-muted">'.$row['category'].' '.$row['class'].'</h6>';
                                    if(isset($_SESSION['email'])){
                                        echo '<a href="./cart/?id='.$row['book_id'].'" class="btn btn-success btn-sm">Add to Cart</a>';
                                    }
                                    else{
                                        echo '<a href="./#dropdownMenu2" class="btn btn-outline-danger btn-sm">Login to Order</a>';
                                    }
                                
                                echo '</div>
                            </div>
                        </a>
                    </div>';
            }
            echo '</div>';
        }
    ?>

    <!-- novel  -->
    <?php
        $cat = "novel";
        $result = select_by_category($cat);
        if(mysqli_num_rows($result)){
            echo '<a href="./search/?search=novel" class="text-dark mt-5"><h2  class="shadow">Novels >></h2></a>
                <div class="row px-5  pb-5 bookrow">';
            while($row = mysqli_fetch_assoc($result)){
                echo'<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <a href="./search/book.php?id='.$row['book_id'].'">
                            <div class="card bg-dark border-warning w3-hover-shadow my-2">
                                <img src="./links/path/books/'.$row['book_image'].'" alt="j" class="card-img-top" height="200">
                                <div class="card-body">
                                    <h4 class="card-title text-warning text-truncate">'.ucwords($row['book_name']).'</h4>
                                    <h6 class="card-subtitle text-muted">'.$row['category'].' '.$row['class'].'</h6>';
                                    if(isset($_SESSION['email'])){
                                        echo '<a href="./cart/?id='.$row['book_id'].'" class="btn btn-success btn-sm">Add to Cart</a>';
                                    }
                                    else{
                                        echo '<a href="./#dropdownMenu2" class="btn btn-outline-danger btn-sm">Login to Order</a>';
                                    }
                                
                                echo '</div>
                            </div>
                        </a>
                    </div>';
            }
            echo '</div>';
        }
    ?>
    
    <!-- Magazine  -->
    <?php
        $cat = "magazine";
        $result = select_by_category($cat);
        if(mysqli_num_rows($result)){
            echo '<a href="./search/?search=magazine" class="text-dark mt-5"><h2 class="shadow">Magazines >></h2></a>
                <div class="row px-5 pb-5 bookrow">';
            while($row = mysqli_fetch_assoc($result)){
                echo'<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <a href="./search/book.php?id='.$row['book_id'].'">
                            <div class="card bg-dark border-warning w3-hover-shadow my-2">
                                <img src="./links/path/books/'.$row['book_image'].'" alt="j" class="card-img-top" height="200">
                                <div class="card-body">
                                    <h4 class="card-title text-warning text-truncate">'.ucwords($row['book_name']).'</h4>
                                    <h6 class="card-subtitle text-muted">'.$row['category'].' '.$row['class'].'</h6>';
                                    if(isset($_SESSION['email'])){
                                        echo '<a href="./cart/?id='.$row['book_id'].'" class="btn btn-success btn-sm">Add to Cart</a>';
                                    }
                                    else{
                                        echo '<a href="./#dropdownMenu2" class="btn btn-outline-danger btn-sm">Login to Order</a>';
                                    }
                                
                                echo '</div>
                            </div>
                        </a>
                    </div>';
            }
            echo '</div>';
        }
    ?>

    <!-- Story Books  -->
    <?php
        $cat = "story book";
        $result = select_by_category($cat);
        if(mysqli_num_rows($result)){
            echo '<a href="./search/?search=story book" class="text-dark mt-5"><h2 class="shadow">Story Books >></h2></a>
                <div class="row px-5 pb-5 bookrow">';
            while($row = mysqli_fetch_assoc($result)){
                echo'<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <a href="./search/book.php?id='.$row['book_id'].'">
                            <div class="card bg-dark border-warning w3-hover-shadow my-2">
                                <img src="./links/path/books/'.$row['book_image'].'" alt="j" class="card-img-top" height="200">
                                <div class="card-body">
                                    <h4 class="card-title text-warning text-truncate">'.ucwords($row['book_name']).'</h4>
                                    <h6 class="card-subtitle text-muted">'.$row['category'].' '.$row['class'].'</h6>';
                                    if(isset($_SESSION['email'])){
                                        echo '<a href="./cart/?id='.$row['book_id'].'" class="btn btn-success btn-sm">Add to Cart</a>';
                                    }
                                    else{
                                        echo '<a href="./#dropdownMenu2" class="btn btn-outline-danger btn-sm">Login to Order</a>';
                                    }
                                
                                echo '</div>
                            </div>
                        </a>
                    </div>';
            }
            echo '</div>';
        }
    ?>

    <!-- Other books -->
    <?php
        $cat = "others";
        $result = select_by_category($cat);
        if(mysqli_num_rows($result)){
            echo '<a href="./search/?search=others" class="text-dark mt-5"><h2 class="shadow">Other Books >></h2></a>
                <div class="row px-5 pb-5 bookrow">';
            while($row = mysqli_fetch_assoc($result)){
                echo'<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <a href="./search/book.php?id='.$row['book_id'].'">
                            <div class="card bg-dark border-warning w3-hover-shadow my-2">
                                <img src="./links/path/books/'.$row['book_image'].'" alt="j" class="card-img-top" height="200">
                                <div class="card-body">
                                    <h4 class="card-title text-warning text-truncate">'.ucwords($row['book_name']).'</h4>
                                    <h6 class="card-subtitle text-muted">'.$row['category'].' '.$row['class'].'</h6>';
                                    if(isset($_SESSION['email'])){
                                        echo '<a href="./cart/?id='.$row['book_id'].'" class="btn btn-success btn-sm">Add to Cart</a>';
                                    }
                                    else{
                                        echo '<a href="./#dropdownMenu2" class="btn btn-outline-danger btn-sm">Login to Order</a>';
                                    }
                                
                                echo '</div>
                            </div>
                        </a>
                    </div>';
            }
            echo '</div>';
        }
    ?>

</div>

                                        <!-- container for information -->
<div class="container my-5 text-white">
    <div class="row">
        <div class="col-md-7 p-5 shadow-lg my-5 bg-black order-md-first order-last">
            Book Donation System is committed to provide free books to the needy, but it gives priority to those who live in 
            countryside and mostly in such places where quality books are unavailable or/and expensive.
        </div>
        <div class="col-md-5 text-center order-first order-md-last"><img src="./links/image/book page.gif" alt="" class="img-fluid"></div>
    </div>
    <div class="row">
        <div class="col-md-5 py-5 text-center">
            <img src="./links/image/earth.gif" alt="earth" class="img-fluid">
        </div>
        <div class="col-md-7 p-5 shadow-lg my-5 bg-black-ltor" id="earth">
            Each book when published and printed releases ~2.71 kg CO2 equivalent. If this book goes from one hand to another 
            five times, it saves nearly 14 kg of CO2 equivalent (which would otherwise be released while production of new copies 
            of the book), thus reducing the carbon footprint manifolds. Additionally, a book when redistributed, saves lot of 
            trees as well that would be cut to make paper, thus it is supporting a sustainable environment as well. 
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 p-5 shadow-lg my-5 bg-black">
            Anyone can go to this website and place a request for any book that is displayed there. Due to constraints some people 
            are not able to access the books they desire to read. Book Donation System wish to fill this gap. 
            Generous giver tend to have more influence with their pet projects than others do. 
        </div>
        <div class="col-md-5 p-5 my-5"></div>
    </div>
    <div class="row">
        <div class="col-md-5 p-5 my-5">
        </div>
        <div class="col-md-7 p-5 shadow-lg my-5 bg-black-ltor">
            While life satisfaction is one thing, general happiness is another. In a study by professors at the University of 
            Missouri – Columbia and the University of California – Riverside, people who gave to others tend to score much higher 
            on feelings of joy and contentment than individuals who did not give to others
        </div>
    </div>
</div>
<?php include_once('./footer.php') ?>